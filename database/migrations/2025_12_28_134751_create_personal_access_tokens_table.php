<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Buat tabel untuk menyimpan token API (untuk login mobile)
    public function up(): void
    {
        // Buat tabel personal_access_tokens
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            // Buat kolom id 1,2,3 dst...
            $table->id();
            
            // Membuat 2 kolom:
            // tokenable_id untuk menyimpan id
            // tokenable_type menyimpal asal tabel seperti 'App\Models\Petugas'
            $table->morphs('tokenable');

            $table->text('name'); // Label untuk token
            $table->string('token', 64)->unique(); // Menyimpan token unik 
            $table->text('abilities')->nullable(); // Hak akses sesuai role
            
            $table->timestamp('last_used_at')->nullable(); // Kapan terakhir kali digunakan
            $table->timestamp('expires_at')->nullable()->index(); // Kapan Expire?
            
            $table->timestamps();
        });
    }

    // Jika hapus tabel
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};