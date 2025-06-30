<?php

namespace App\Http\Controllers;

use App\Models\Ppdb;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Total seluruh pendaftar
        $totalPendaftar = Ppdb::count();

        // Total yang sudah diterima dan sudah daftar ulang
        $totalSudahDaftarUlang = Ppdb::where('hasil_test', 1)
            ->where('status_daftar_ulang', 1)
            ->count();

        // Total yang sudah tes tapi belum selesai prosesnya
        $totalBelumSelesai = Ppdb::where('hasil_test', '!=', 1)
            ->where('status_daftar_ulang', '!=', 1)
            ->whereNotNull('jadwal_test')
            ->count();

        return view('home.index', compact(
            'totalPendaftar',
            'totalSudahDaftarUlang',
            'totalBelumSelesai'
        ));
    }

    public function persyaratan()
    {
        return view('home.persyaratan');
    }
    public function faq()
    {
        return view('home.faq');
    }
}
