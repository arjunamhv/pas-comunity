<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->char('id', 19)->primary();
            $table->string('name', 255);
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('telepon', 15)->nullable()->unique();
            $table->char('kota_tempat_lahir_id')->nullable();
            $table->date('tanggal_lahir')->nullable(false);
            $table->string('foto')->nullable();
            $table->char('provinsi_id')->nullable(false);
            $table->char('kota_id')->nullable(false);
            $table->char('kecamatan_id')->nullable(false);
            $table->char('kelurahan_id')->nullable(false);
            $table->string('kode_pos', 5)->nullable();
            $table->string('detail_alamat', 255)->nullable();
            $table->boolean('is_admin')->default(0);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('kota_tempat_lahir_id')->references('id')->on('regencies')->onDelete('cascade');
            $table->foreign('provinsi_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->foreign('kota_id')->references('id')->on('regencies')->onDelete('cascade');
            $table->foreign('kecamatan_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('kelurahan_id')->references('id')->on('villages')->onDelete('cascade');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
