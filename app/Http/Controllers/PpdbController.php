<?php

namespace App\Http\Controllers;

use App\Models\Ppdb;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PpdbController extends Controller
{
    public function index()
    {
        $setting = Setting::first() ?? (object)[
            'status_pendaftaran' => 0
        ];
        return view('ppdb.index', compact('setting'));
    }
    public function store(Request $request)
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
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'scan_ijazah' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'scan_kk' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'scan_raport' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_ayah' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_ibu' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'scan_kip' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'scan_sktm' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        $messages = [
            'jurusan.required' => 'Jurusan wajib dipilih.',
            'jurusan.in' => 'Jurusan yang dipilih tidak valid.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.digits_between' => 'NISN harus antara 8 sampai 12 digit.',
            'nisn.numeric' => 'NISN harus berupa angka.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'asal_sekolah.required' => 'Asal sekolah wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 500 karakter.',
            'kks.required' => 'Status KKS wajib dipilih.',
            'kks.in' => 'Status KKS tidak valid.',
            'kps.required' => 'Status KPS/PKH wajib dipilih.',
            'kps.in' => 'Status KPS/PKH tidak valid.',
            'kip.required' => 'Status KIP wajib dipilih.',
            'kip.in' => 'Status KIP tidak valid.',
            'wa.required' => 'Nomor WhatsApp wajib diisi.',
            'wa.regex' => 'Format nomor WhatsApp tidak valid (harus diawali 08 dan panjang 10-14 digit).',
            'wa_ortu.regex' => 'Format nomor WhatsApp orang tua tidak valid (harus diawali 08 dan panjang 10-14 digit).',
            'nama_ayah.required' => 'Nama ayah wajib diisi.',
            'nama_ibu.required' => 'Nama ibu wajib diisi.',
            'foto.required' => 'Pas foto wajib diunggah.',
            'foto.image' => 'Pas foto harus berupa gambar.',
            'foto.mimes' => 'Pas foto harus berformat JPG/PNG.',
            'foto.max' => 'Ukuran maksimal pas foto 2MB.',
            'scan_ijazah.required' => 'Pas foto wajib diunggah.',
            'scan_ijazah.image' => 'Pas foto harus berupa gambar.',
            'scan_ijazah.mimes' => 'Pas foto harus berformat JPG/PNG/PDF.',
            'scan_ijazah.max' => 'Ukuran maksimal pas foto 2MB.',
            'scan_kk.required' => 'Pas foto wajib diunggah.',
            'scan_kk.image' => 'Pas foto harus berupa gambar.',
            'scan_kk.mimes' => 'Pas foto harus berformat JPG/PNG.',
            'scan_kk.max' => 'Ukuran maksimal pas foto 2MB.',
            'scan_raport.required' => 'Pas foto wajib diunggah.',
            'scan_raport.image' => 'Pas foto harus berupa gambar.',
            'scan_raport.mimes' => 'Pas foto harus berformat JPG/PNG/PDF.',
            'scan_raport.max' => 'Ukuran maksimal pas foto 2MB.',
            'ktp_ayah.required' => 'Pas foto wajib diunggah.',
            'ktp_ayah.image' => 'Pas foto harus berupa gambar.',
            'ktp_ayah.mimes' => 'Pas foto harus berformat JPG/PNG/PDF.',
            'ktp_ayah.max' => 'Ukuran maksimal pas foto 2MB.',
            'ktp_ibu.required' => 'Pas foto wajib diunggah.',
            'ktp_ibu.image' => 'Pas foto harus berupa gambar.',
            'ktp_ibu.mimes' => 'Pas foto harus berformat JPG/PNG/PDF.',
            'ktp_ibu.max' => 'Ukuran maksimal pas foto 2MB.',
        ];

        $validated = $request->validate($rules, $messages);

        try {
            $validated['user_id'] = auth()->id();
            // Upload file
            $folder = 'dokumen-ppdb';

            $validated['foto'] = $request->file('foto')->store($folder, 'public');
            $validated['scan_ijazah'] = $request->file('scan_ijazah')->store($folder, 'public');
            $validated['scan_kk'] = $request->file('scan_kk')->store($folder, 'public');
            $validated['scan_raport'] = $request->file('scan_raport')->store($folder, 'public');
            $validated['ktp_ayah'] = $request->file('ktp_ayah')->store($folder, 'public');
            $validated['ktp_ibu'] = $request->file('ktp_ibu')->store($folder, 'public');

            // Optional
            if ($request->hasFile('scan_kip')) {
                $validated['scan_kip'] = $request->file('scan_kip')->store($folder, 'public');
            }

            if ($request->hasFile('scan_sktm')) {
                $validated['scan_sktm'] = $request->file('scan_sktm')->store($folder, 'public');
            }
            Ppdb::create($validated);
            return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data PPDB: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_daftar_ulang' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $ppdb = Ppdb::findOrFail($id);

        if ($ppdb->bukti_daftar_ulang && Storage::exists($ppdb->bukti_daftar_ulang)) {
            Storage::delete($ppdb->bukti_daftar_ulang);
        }

        $path = $request->file('bukti_daftar_ulang')->store('bukti-daftar-ulang', 'public');

        $ppdb->bukti_daftar_ulang = $path;
        $ppdb->status_daftar_ulang = 3;
        $ppdb->save();

        return redirect()->back()->with('success', 'Bukti daftar ulang berhasil diupload. Silakan tunggu verifikasi dari admin.');
    }
}
