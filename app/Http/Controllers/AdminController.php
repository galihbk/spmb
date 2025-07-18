<?php

namespace App\Http\Controllers;

use App\Models\NilaiTest;
use App\Models\Ppdb;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

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
        $query = Ppdb::leftJoin('nilai_tests', 'ppdbs.id', '=', 'nilai_tests.ppdb_id')
        ->orderByRaw('jadwal_test IS NOT NULL')
        ->select([
            'ppdbs.id',
            'ppdbs.nama',
            'ppdbs.jurusan',
            'ppdbs.jadwal_test',
            'ppdbs.status_daftar_ulang',
            'ppdbs.bukti_daftar_ulang',
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
            ->editColumn('status_daftar_ulang', function ($row) {
    return match ((int)$row->status_daftar_ulang) {
        0 => '<span class="badge bg-warning text-dark">Belum Upload</span>',
        1 => '<span class="badge bg-success">Diterima</span>',
        2 => '<span class="badge bg-danger">Ditolak</span>',
        3 => '<span class="badge bg-info text-dark">Menunggu Verifikasi</span>',
        default => '<span class="badge bg-secondary">Tidak Diketahui</span>',
    };
})
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

    if ($rata2 <= 50) {
        return '<span class="badge bg-danger">Ditolak</span>';
    }

    return match ((int) $row->status_daftar_ulang) {
        0 => '<span class="badge bg-warning text-dark">Belum Daftar Ulang</span>',
        3 => '<span class="badge bg-info text-dark">Menunggu Verifikasi</span>',
        2 => '<span class="badge bg-danger">Bukti Ditolak</span>',
        1 => '<span class="badge bg-success">Lulus</span>',
        default => '<span class="badge bg-secondary">Status Tidak Dikenal</span>',
    };
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
                        <li>
  <a class="dropdown-item"
     href="#"
     data-bs-toggle="modal"
     data-bs-target="#modalDaftarUlang"
     data-id="' . $id . '"
     data-status="' . $row->status_daftar_ulang . '"
     data-bukti="' . ($row->bukti_daftar_ulang ? Storage::url($row->bukti_daftar_ulang) : '') . '">
     Update Daftar Ulang
  </a>
</li>
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

    public function update(Request $request, $id)
    {
        $rules = [
            'jurusan' => 'required|in:DPB,TKJ,TBSM',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'nisn' => 'required|digits_between:8,12|numeric',
            'nik' => 'required|digits:16|numeric',
            'asal_sekolah' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:500',
            'kks' => 'required|in:Ya,Tidak',
            'kps' => 'required|in:Ya,Tidak',
            'kip' => 'required|in:Ya,Tidak',
            'wa' => 'required|string|regex:/^08[0-9]{8,12}$/',
            'wa_ortu' => 'nullable|string|regex:/^08[0-9]{8,12}$/',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'nama_wali' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'scan_ijazah' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'scan_kk' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'scan_raport' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_ayah' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_ibu' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'scan_kip' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'scan_sktm' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        $validated = $request->validate($rules);

        try {
            $ppdb = Ppdb::findOrFail($id);
            $folder = 'dokumen-ppdb';

            if ($request->hasFile('foto')) {
                if ($ppdb->foto) Storage::disk('public')->delete($ppdb->foto);
                $validated['foto'] = $request->file('foto')->store($folder, 'public');
            }
            if ($request->hasFile('scan_ijazah')) {
                if ($ppdb->scan_ijazah) Storage::disk('public')->delete($ppdb->scan_ijazah);
                $validated['scan_ijazah'] = $request->file('scan_ijazah')->store($folder, 'public');
            }
            if ($request->hasFile('scan_kk')) {
                if ($ppdb->scan_kk) Storage::disk('public')->delete($ppdb->scan_kk);
                $validated['scan_kk'] = $request->file('scan_kk')->store($folder, 'public');
            }
            if ($request->hasFile('scan_raport')) {
                if ($ppdb->scan_raport) Storage::disk('public')->delete($ppdb->scan_raport);
                $validated['scan_raport'] = $request->file('scan_raport')->store($folder, 'public');
            }
            if ($request->hasFile('ktp_ayah')) {
                if ($ppdb->ktp_ayah) Storage::disk('public')->delete($ppdb->ktp_ayah);
                $validated['ktp_ayah'] = $request->file('ktp_ayah')->store($folder, 'public');
            }
            if ($request->hasFile('ktp_ibu')) {
                if ($ppdb->ktp_ibu) Storage::disk('public')->delete($ppdb->ktp_ibu);
                $validated['ktp_ibu'] = $request->file('ktp_ibu')->store($folder, 'public');
            }
            if ($request->hasFile('scan_kip')) {
                if ($ppdb->scan_kip) Storage::disk('public')->delete($ppdb->scan_kip);
                $validated['scan_kip'] = $request->file('scan_kip')->store($folder, 'public');
            }
            if ($request->hasFile('scan_sktm')) {
                if ($ppdb->scan_sktm) Storage::disk('public')->delete($ppdb->scan_sktm);
                $validated['scan_sktm'] = $request->file('scan_sktm')->store($folder, 'public');
            }

            $ppdb->update($validated);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal update PPDB: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }
}
