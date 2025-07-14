<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ppdbs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('jurusan', ['DPB', 'TKJ', 'TBSM']);
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('nisn', 12);
            $table->string('nik', 16);
            $table->string('asal_sekolah');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->enum('kks', ['Ya', 'Tidak']);
            $table->enum('kps', ['Ya', 'Tidak']);
            $table->enum('kip', ['Ya', 'Tidak']);
            $table->string('wa', 15);
            $table->string('wa_ortu', 15)->nullable();
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('nama_wali')->nullable();
            $table->string('foto');
            $table->string('scan_ijazah');
            $table->string('scan_kk');
            $table->string('scan_raport');
            $table->string('ktp_ayah');
            $table->string('ktp_ibu');
            $table->string('scan_kip')->nullable();
            $table->string('scan_sktm')->nullable();
            $table->dateTime('jadwal_test')->nullable();
            $table->boolean('status_daftar_ulang')->default(0);
            $table->boolean('bukti_daftar_ulang')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ppdbs');
    }
};
