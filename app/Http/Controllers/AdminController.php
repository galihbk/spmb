<?php

namespace App\Http\Controllers;

use App\Models\NilaiTest;
use App\Models\Ppdb;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Setting;

class AdminController extends Controller
{
    public function index()
    {
         $setting= Setting::first()?? (object)[
        'status_pendaftaran' => 0
    ];
        return view('admin.index', compact('setting'));
    }
    public function toggle(Request $request)
{
    $status = $request->input('status'); // status berupa 0 atau 1 dari AJAX

    $setting = Setting::first();

    if (!$setting) {
        // Insert jika belum ada
        $setting = new Setting();
    }

    $setting->status_pendaftaran = $status;
    $setting->save();

    return response()->json(['message' => 'Status berhasil diperbarui.']);
}
    public function data(Request $request)
    {
        $query = Ppdb::where('status_daftar_ulang', 0)
            ->leftJoin('nilai_tests', 'ppdbs.id', '=', 'nilai_tests.ppdb_id')
        ->orderByRaw('jadwal_test IS NOT NULL')
        ->select([
            'ppdbs.id',
            'ppdbs.nama',
            'ppdbs.jurusan',
            'ppdbs.jadwal_test',
            'ppdbs.status_daftar_ulang',
            'nilai_tests.wawancara',
            'nilai_tests.baca_tulis',
            'nilai_tests.btq',
            'nilai_tests.buta_warna',
            'nilai_tests.fisik',
        ]);

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn(
                'jadwal_test',
                fn($row) =>
                $row->jadwal_test ? \Carbon\Carbon::parse($row->jadwal_test)->translatedFormat('d F Y') : '-'
            )
            ->editColumn('nilai_test', fn($row) => match ($row->hasil_test) {
                1 => '<span class="badge bg-success">Lulus</span>',
                0 => '<span class="badge bg-warning">Belum dinilai</span>',
                2 => '<span class="badge bg-danger text-dark">Tidak Lulus</span>',
                default => '<span class="badge bg-secondary">Belum Dinilai</span>'
            })
            ->editColumn('nilai_test', function ($row) {
            $nilai = collect([
                $row->test,
                $row->wawancara,
                $row->baca_tulis,
                $row->btq,
                $row->buta_warna,
                $row->fisik
            ])->filter(fn($n) => $n !== null); // buang null biar bisa dicek apakah memang belum dinilai

            if ($nilai->isEmpty()) {
                return '<span class="badge bg-warning">Belum dinilai</span>';
            }

            $rata2 = $nilai->avg();
            if ($rata2 > 50) {
                return '<span class="badge bg-success">Lulus</span>';
            } else {
                return '<span class="badge bg-danger text-dark">Tidak Lulus</span>';
            }
        })
            ->editColumn(
                'status_daftar_ulang',
                fn($row) => $row->status_daftar_ulang
                    ? '<span class="badge bg-success">Sudah</span>'
                    : '<span class="badge bg-danger">Belum</span>'
            )
->addColumn('status', function ($row) {
    $nilai = collect([
        $row->test,
        $row->wawancara,
        $row->baca_tulis,
        $row->btq,
        $row->buta_warna,
        $row->fisik
    ])->filter(fn($n) => $n !== null);

    if ($nilai->isEmpty()) {
        return '<span class="badge bg-warning text-dark">Belum Selesai</span>';
    }

    $rata2 = $nilai->avg();

    // Langsung nyatakan ditolak jika rata-rata ≤ 50
    if ($rata2 <= 50) {
        return '<span class="badge bg-danger">Ditolak</span>';
    }

    // Jika belum daftar ulang, tetap belum selesai
    if ($row->status_daftar_ulang == 0) {
        return '<span class="badge bg-warning text-dark">Belum Selesai</span>';
    }

    // Lulus jika nilai bagus dan sudah daftar ulang
    return '<span class="badge bg-success">Lulus</span>';
})

            ->addColumn('aksi', function ($row) {
                $id = $row->id;

                return '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                        Aksi
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="' . route('admin.detail', $id) . '">Detail</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalJadwalTes" data-id="' . $id . '" data-jadwal="' . $row->jadwal_test . '">Update Jadwal Tes</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalHasilTes" data-id="' . $id . '" data-hasil="">Update Hasil Tes</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalDaftarUlang" data-id="' . $id . '" data-status="' . $row->status_daftar_ulang . '">Update Daftar Ulang</a></li>
                    </ul>
                </div>';
            })
            ->rawColumns(['nilai_test', 'status_daftar_ulang', 'aksi', 'status'])
            ->make(true);
    }
    public function updateJadwal(Request $r)
    {
        Ppdb::where('id', $r->id)->update(['jadwal_test' => $r->jadwal_test]);
        return back()->with('success', 'Jadwal Tes diperbarui');
    }

    public function updateHasil(Request $request)
    {
        $request->validate([
        'id' => 'required|exists:ppdbs,id', // pastikan id peserta ada
        'wawancara' => 'required|numeric|min:0|max:100',
        'baca_tulis' => 'required|numeric|min:0|max:100',
        'btq' => 'required|numeric|min:0|max:100',
        'buta_warna' => 'required|numeric|min:0|max:100',
        'fisik' => 'required|numeric|min:0|max:100',
    ]);
    $nilai = NilaiTest::where('ppdb_id', $request->id)->first();

    if ($nilai) {
        $nilai->update([
            'wawancara' => $request->wawancara,
            'baca_tulis' => $request->baca_tulis,
            'btq' => $request->btq,
            'buta_warna' => $request->buta_warna,
            'fisik' => $request->fisik,
        ]);
    } else {
        NilaiTest::create([
            'ppdb_id' => $request->id,
            'wawancara' => $request->wawancara,
            'baca_tulis' => $request->baca_tulis,
            'btq' => $request->btq,
            'buta_warna' => $request->buta_warna,
            'fisik' => $request->fisik,
        ]);
    }

    return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }

    public function updateDaftarUlang(Request $r)
    {
        Ppdb::where('id', $r->id)->update(['status_daftar_ulang' => $r->status_daftar_ulang]);
        return back()->with('success', 'Status Daftar Ulang diperbarui');
    }
    public function show($id){
        $ppdb = Ppdb::with('NilaiTest')->findOrFail($id);
        // dd($ppdb->jurusan);
        return view('admin.detail', compact('ppdb'));
    }
}
