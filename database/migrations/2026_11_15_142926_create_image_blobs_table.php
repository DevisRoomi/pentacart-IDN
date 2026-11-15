<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('image_blobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->nullable()->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->unique()->constrained()->cascadeOnDelete();
            $table->string('mime_type', 30);
            $table->char('content_hash', 64);
            $table->binary('content');
            $table->timestamps();
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE image_blobs MODIFY content LONGBLOB NOT NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_blobs');
    }
};
