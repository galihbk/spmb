<?php

namespace App\Http\Controllers;

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
            ->orderByRaw('jadwal_test IS NOT NULL') // urutkan NULL terlebih dahulu
            ->select(['id', 'nama', 'jurusan', 'jadwal_test', 'hasil_test', 'status_daftar_ulang']);

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn(
                'jadwal_test',
                fn($row) =>
                $row->jadwal_test ? \Carbon\Carbon::parse($row->jadwal_test)->translatedFormat('d F Y') : '-'
            )
            ->editColumn('hasil_test', fn($row) => match ($row->hasil_test) {
                1 => '<span class="badge bg-success">Lulus</span>',
                0 => '<span class="badge bg-warning">Belum dinilai</span>',
                2 => '<span class="badge bg-danger text-dark">Tidak Lulus</span>',
                default => '<span class="badge bg-secondary">Belum Dinilai</span>'
            })
            ->editColumn(
                'status_daftar_ulang',
                fn($row) => $row->status_daftar_ulang
                    ? '<span class="badge bg-success">Sudah</span>'
                    : '<span class="badge bg-danger">Belum</span>'
            )
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
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalHasilTes" data-id="' . $id . '" data-hasil="' . $row->hasil_test . '">Update Hasil Tes</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalDaftarUlang" data-id="' . $id . '" data-status="' . $row->status_daftar_ulang . '">Update Daftar Ulang</a></li>
                    </ul>
                </div>';
            })
            ->rawColumns(['hasil_test', 'status_daftar_ulang', 'aksi'])
            ->make(true);
    }
    public function updateJadwal(Request $r)
    {
        Ppdb::where('id', $r->id)->update(['jadwal_test' => $r->jadwal_test]);
        return back()->with('success', 'Jadwal Tes diperbarui');
    }

    public function updateHasil(Request $r)
    {
        Ppdb::where('id', $r->id)->update(['hasil_test' => $r->hasil_test]);
        return back()->with('success', 'Hasil Tes diperbarui');
    }

    public function updateDaftarUlang(Request $r)
    {
        Ppdb::where('id', $r->id)->update(['status_daftar_ulang' => $r->status_daftar_ulang]);
        return back()->with('success', 'Status Daftar Ulang diperbarui');
    }
}
