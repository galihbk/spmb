<?php

namespace App\Http\Controllers;

use App\Models\Ppdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PpdbController extends Controller
{
    public function index()
    {
        return view('ppdb.index');
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
        ];

        $validated = $request->validate($rules, $messages);

        try {
            $validated['user_id'] = auth()->id();
            Ppdb::create($validated);
            return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data PPDB: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }
}
