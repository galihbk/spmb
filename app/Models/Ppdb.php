<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ppdb extends Model
{
    protected $fillable = [
        'user_id',
        'jurusan',
        'nama',
        'jenis_kelamin',
        'nisn',
        'nik',
        'asal_sekolah',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'kks',
        'kps',
        'kip',
        'wa',
        'wa_ortu',
        'nama_ayah',
        'nama_ibu',
        'nama_wali',
        'jadwal_test',
        'status_daftar_ulang',
        'foto',
        'scan_ijazah',
        'scan_kk',
        'scan_raport',
        'ktp_ayah',
        'ktp_ibu',
        'scan_kip',
        'scan_sktm',
        'bukti_daftar_ulang',
    ];
    public function NilaiTest()
{
    return $this->hasOne(NilaiTest::class, 'ppdb_id');
}
 public function hasilTes()
{
    return $this->hasOne(NilaiTest::class, 'ppdb_id');
}
}
