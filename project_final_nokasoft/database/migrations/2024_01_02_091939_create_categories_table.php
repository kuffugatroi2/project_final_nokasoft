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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands');
            $table->string('name', 50);
            $table->enum('status', ['active', 'unactive']);
            $table->string('type', 30);
            $table->foreignId('created_by')->constrained('admins');
            $table->foreignId('updated_by')->constrained('admins');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
