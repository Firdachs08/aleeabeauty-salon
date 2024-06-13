<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('code')->unique();
            $table->string('status');
            $table->datetime('order_date');
            $table->datetime('payment_due');
            $table->string('payment_status');
            $table->string('payment_token')->nullable();
            $table->string('payment_url')->nullable();
            $table->decimal('base_total_price', 16, 2)->default(0);
           
            $table->decimal('grand_total', 16, 2)->default(0);
            $table->text('note')->nullable();
            $table->string('customer_first_name')->nullable(); // Kolom nama
            $table->string('customer_phone')->nullable();
           
            

            $table->index('payment_token');
            $table->index('code');
            $table->index(['code', 'order_date']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
