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
        Schema::create('movements',
            function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(\App\Models\User::class)
                    ->constrained()
                    ->restrictOnDelete()->restrictOnUpdate();
                $table->timestamps();
            });

        Schema::create('movement_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Movement::class)->constrained();
            $table->foreignIdFor(\App\Models\Product::class)->constrained();
            $table->unsignedBigInteger('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_product');

        Schema::dropIfExists('movements');
    }
};
