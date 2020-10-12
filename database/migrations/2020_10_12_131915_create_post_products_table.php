<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_id')->unsigned()->unique();
            $table->integer('price')->unsigned();
            $table->string('interval', 8)->comment('決済期間: day, week, month or year (Stripeに合わせる)');
            $table->tinyInteger('payment_count')->unsigned()->nullable()->comment('支払回数: 単発購入の場合、1。期間制限なしのSubscriptionはnull');
            $table->string('stripe_product_id')->nullable()->comment('StripeのProduct ID');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_products');
    }
}
