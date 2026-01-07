<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  
    // Membuat struktur tabel
    public function up(): void
    {
        // Tabel instansi
        Schema::create('instansi', function (Blueprint $table) {
            // Primary key custom (bukan id default)
            $table->id('Id_Instansi');
            $table->string('Nama_Instansi', 60)->nullable();
            $table->string('Jenis_Instansi', 30)->nullable();
            $table->string('Alamat_Instansi', 200)->nullable();
            $table->string('Email_Instansi', 30)->nullable();
            $table->string('Password_Instansi', 255)->nullable();
        });

        // Tabel petugas/admin
        Schema::create('petugas', function (Blueprint $table) {
            $table->id('Id_Petugas');
            $table->string('Nama_Petugas', 60)->nullable();
            $table->string('Username_Ptgs', 30)->nullable();
            $table->bigInteger('NIK_Petugas')->nullable();
            $table->string('Alamat_Petugas', 200)->nullable();
            $table->string('Email_Petugas', 30)->nullable();
            $table->string('Password_Petugas', 255)->nullable();
        });

        // Tabel masyarakat
        Schema::create('masyarakat', function (Blueprint $table) {
            $table->id('Id_Masyarakat');
            $table->string('Nama_Masyarakat', 60)->nullable();
            $table->string('Username_Msy', 30)->unique()->nullable();
            $table->bigInteger('NIK_Masyarakat')->nullable();
            $table->string('Alamat_Masyarakat', 200)->nullable();
            $table->string('Email_Masyarakat', 30)->nullable();
            $table->string('Password_Msy', 255)->nullable();
            $table->string('foto_profile', 255)->nullable();
            $table->integer('Poin')->default(0);
        });

        // Tabel pengaduan
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id('Id_Pengaduan');

            // Foreign Keys 
            $table->unsignedBigInteger('Id_Petugas')->nullable();
            $table->unsignedBigInteger('Id_Instansi')->nullable();
            $table->unsignedBigInteger('Id_Masyarakat')->nullable();

            $table->string('Judul_Pengaduan', 30)->nullable();
            $table->string('Kategori', 50)->nullable();
            $table->string('Deskripsi', 255)->nullable();
            $table->string('Keterangan', 50)->default('Ditinjau');
            $table->date('Tanggal_Pengaduan')->nullable();

            // Koordinat lokasi
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('dokumentasi')->nullable();

            // Definisi Relasi
            // Jika Petugas dihapus, Id_Petugas jadi NULL
            $table->foreign('Id_Petugas')->references('Id_Petugas')->on('petugas')->onDelete('set null');
            // Jika Instansi dihapus, Id_Instansi jadi NULL
            $table->foreign('Id_Instansi')->references('Id_Instansi')->on('instansi')->onDelete('set null');
            // Jika Masyarakat dihapus, data pengaduannya ikut terhapus 
            $table->foreign('Id_Masyarakat')->references('Id_Masyarakat')->on('masyarakat')->onDelete('cascade');
        });

        // Tabel feedback
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('Id_Feedback');
            $table->unsignedBigInteger('Id_Masyarakat')->nullable();
            $table->unsignedBigInteger('Id_Pengaduan')->nullable();

            $table->string('Komentar', 255)->nullable();
            $table->enum('Konfirmasi', ['Selesai', 'Belum Selesai'])->nullable();
            $table->string('Efektivitas')->nullable();
            $table->string('Kemudahan')->nullable();
            $table->string('Reward')->nullable();

            // Relasi, hapus feedback jika user atau pengaduan dihapus
            $table->foreign('Id_Masyarakat')->references('Id_Masyarakat')->on('masyarakat')->onDelete('cascade');
            $table->foreign('Id_Pengaduan')->references('Id_Pengaduan')->on('pengaduan')->onDelete('cascade');
        });

        // Tabel riwayat poin
        Schema::create('riwayat_poin', function (Blueprint $table) {
            $table->id('Id_Poin');
            $table->unsignedBigInteger('Id_Masyarakat');
            $table->unsignedBigInteger('Id_Feedback')->nullable();

            $table->integer('Jumlah_Poin')->default(1);
            $table->enum('Jenis_Transaksi', ['Masuk', 'Keluar'])->default('Masuk');
            $table->string('Keterangan', 255)->nullable();
            $table->dateTime('Tanggal_Transaksi')->useCurrent();

            $table->foreign('Id_Masyarakat')->references('Id_Masyarakat')->on('masyarakat')->onDelete('cascade');
            $table->foreign('Id_Feedback')->references('Id_Feedback')->on('feedback')->onDelete('set null');
        });

        // Tabel thread 
        Schema::create('thread', function (Blueprint $table) {
            $table->id('Id_Thread');
            $table->unsignedBigInteger('Id_Masyarakat')->nullable();

            $table->string('Isi_Thread', 255)->nullable();
            $table->string('Gambar_Thread', 255)->nullable();
            $table->date('Tanggal')->nullable();

            $table->foreign('Id_Masyarakat')->references('Id_Masyarakat')->on('masyarakat')->onDelete('cascade');
        });

        // Tabel Reward 
        Schema::create('reward', function (Blueprint $table) {
            $table->id('Id_Reward');
            $table->unsignedBigInteger('Id_Masyarakat')->nullable();
            $table->string('Jenis_Reward', 100)->nullable();
            $table->string('Deskripsi_Rwd', 150)->nullable();

            $table->foreign('Id_Masyarakat')->references('Id_Masyarakat')->on('masyarakat')->onDelete('cascade');
        });
    }

    // Menghapus tabel jika dibalik dari anak ke induk
    public function down(): void
    {
        Schema::dropIfExists('riwayat_poin');
        Schema::dropIfExists('feedback');
        Schema::dropIfExists('thread');
        Schema::dropIfExists('reward');
        Schema::dropIfExists('pengaduan');
        Schema::dropIfExists('masyarakat');
        Schema::dropIfExists('petugas');
        Schema::dropIfExists('instansi');
    }
};