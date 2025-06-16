<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Hapus kolom yang tidak digunakan
            if (Schema::hasColumn('order_items', 'product_id')) {
                $table->dropColumn('product_id');
            }
            if (Schema::hasColumn('order_items', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('order_items', 'total')) {
                $table->dropColumn('total');
            }

            // Tambah/ubah kolom yang dibutuhkan
            if (!Schema::hasColumn('order_items', 'item_id')) {
                $table->integer('item_id')->nullable()->after('order_id');
            }
            if (!Schema::hasColumn('order_items', 'price_per_item')) {
                $table->integer('price_per_item')->nullable()->after('quantity');
            }
            if (!Schema::hasColumn('order_items', 'subtotal')) {
                $table->integer('subtotal')->nullable()->after('price_per_item');
            }
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['item_id', 'price_per_item', 'subtotal']);
            $table->integer('product_id')->nullable();
            $table->integer('price')->nullable();
            $table->integer('total')->nullable();
        });
    }
};
