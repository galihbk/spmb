<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Persyaratan;
use App\Models\Ppdb;
use Illuminate\Http\Request;
use App\Models\Faq;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('urutan', 'asc')
            ->get();
        $totalPendaftar = Ppdb::count();

        $totalSudahDaftarUlang = Ppdb::where('status_daftar_ulang', 1)
            ->count();

        $totalBelumSelesai = Ppdb::where('status_daftar_ulang', '!=', 1)
            ->whereNotNull('jadwal_test')
            ->count();

        return view('home.index', compact(
            'totalPendaftar',
            'totalSudahDaftarUlang',
            'totalBelumSelesai',
            'banners'
        ));
    }
    public function storeBanner(Request $request)
    {
        $request->validate(['image' => 'required|image']);
        $folder = 'banners';

        $path = $request->file('image')->store($folder, 'public');
        Banner::create(['image' => basename($path), 'urutan' => $request->urutan,]);
        return response()->json(['message' => 'Banner added successfully.']);
    }

    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        if ($request->hasFile('image')) {
            Storage::delete('public/banners/' . $banner->image);
            $path = $request->file('image')->store('public/banners');
            $banner->update(['image' => basename($path)]);
        }
        return response()->json(['message' => 'Banner updated successfully.']);
    }

    public function destroyBanner($id)
    {
        $banner = Banner::findOrFail($id);
        Storage::delete('public/banners/' . $banner->image);
        $banner->delete();
        return response()->json(['message' => 'Banner deleted successfully.']);
    }
    public function persyaratan()
    {
        $data = Persyaratan::all();
        return view('home.persyaratan', compact('data'));
    }
    public function storePersyaratan(Request $request)
    {
        $request->validate(['nama' => 'required|string']);
        $item = Persyaratan::create(['persyaratan' => $request->nama]);
        return response()->json($item);
    }
    public function destroyPersyaratan($id)
    {
        Persyaratan::destroy($id);
        return response()->json(['status' => 'success']);
    }

    public function updatePersyaratan(Request $request, $id)
    {
        $request->validate(['nama' => 'required|string']);
        $item = Persyaratan::findOrFail($id);
        $item->update(['nama' => $request->nama]);
        return response()->json($item);
    }
    public function faq()
    {
        $faqs = Faq::all();
        return view('home.faq', compact('faqs'));
    }
    public function storeFaq(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ]);

        $faq = Faq::create($request->only('pertanyaan', 'jawaban'));
        return response()->json($faq);
    }

    public function updateFaq(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $faq = Faq::findOrFail($id);
        $faq->update($request->only('pertanyaan', 'jawaban'));
        return response()->json($faq);
    }

    public function destroyFaq($id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Faq::destroy($id);
        return response()->json(['status' => 'success']);
    }
}
