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
        // Create the 'playlists' table
        Schema::create('playlists', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name'); // A string column to store the name of the playlist
            $table->string('slug'); // A string column to store the slug of the playlist
            $table->string('image'); // A string column to store the image file name
            $table->string('linkcapcut');
            $table->string('duration'); // A string column to store the duration of the playlist
            $table->timestamps(); // Automatically adds 'created_at' and 'updated_at' columns for timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'playlists' table if it exists
        Schema::dropIfExists('playlists');
    }
};

