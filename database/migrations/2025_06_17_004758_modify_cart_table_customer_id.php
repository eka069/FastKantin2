<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cart', function (Blueprint $table) {
            // Hapus kolom yang tidak dibutuhkan jika ada
            if (Schema::hasColumn('cart', 'user_id')) $table->dropColumn('user_id');
            if (Schema::hasColumn('cart', 'food_name')) $table->dropColumn('food_name');
            if (Schema::hasColumn('cart', 'price')) $table->dropColumn('price');
            if (Schema::hasColumn('cart', 'quantity')) $table->dropColumn('quantity');
            if (Schema::hasColumn('cart', 'total')) $table->dropColumn('total');

            // Tambahkan kolom baru jika belum ada
            if (!Schema::hasColumn('cart', 'customer_id')) {
                $table->unsignedBigInteger('customer_id')->nullable()->after('id');
            }

            if (!Schema::hasColumn('cart', 'food_id')) {
                $table->unsignedBigInteger('food_id')->nullable()->after('customer_id');
            }

            if (!Schema::hasColumn('cart', 'qty')) {
                $table->integer('qty')->nullable()->after('food_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cart', function (Blueprint $table) {
            // Rollback: hapus kolom baru
            if (Schema::hasColumn('cart', 'customer_id')) $table->dropColumn('customer_id');
            if (Schema::hasColumn('cart', 'food_id')) $table->dropColumn('food_id');
            if (Schema::hasColumn('cart', 'qty')) $table->dropColumn('qty');

            // Tambah kembali kolom lama
            if (!Schema::hasColumn('cart', 'user_id')) $table->integer('user_id')->nullable();
            if (!Schema::hasColumn('cart', 'food_name')) $table->integer('food_name');
            if (!Schema::hasColumn('cart', 'price')) $table->integer('price');
            if (!Schema::hasColumn('cart', 'quantity')) $table->integer('quantity');
            if (!Schema::hasColumn('cart', 'total')) $table->integer('total');
        });
    }
};

