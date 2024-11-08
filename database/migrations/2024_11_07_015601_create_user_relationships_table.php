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
        Schema::create('user_relationships', function (Blueprint $table) {
            $table->id();
            $table->char('user_a', 19);
            $table->char('user_b', 19);
            $table->foreignId('relationship_type_id')->constrained('relationship_types')->onDelete('cascade');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('user_a')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_b')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_a', 'user_b', 'relationship_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_relationships');
    }
};
