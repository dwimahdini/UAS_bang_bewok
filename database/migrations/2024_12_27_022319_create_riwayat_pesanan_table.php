<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatPesananTable extends Migration
{
    public function up()
    {
        Schema::create('riwayat_pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('keranjang_pesanan')->onDelete('cascade');
            $table->string('status');
            $table->decimal('total_harga', 10, 2);
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_pesanan');
    }
}
