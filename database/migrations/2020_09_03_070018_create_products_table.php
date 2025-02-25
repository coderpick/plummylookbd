<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            //$table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('code')->nullable();
            $table->text('size')->nullable();
            $table->text('color')->nullable();
            $table->longText('details')->nullable();
            $table->float('price',12,2);
            $table->float('new_price',12,2)->nullable();
            $table->integer('stock');
            $table->integer('point')->nullable();
            $table->string('status');
            $table->tinyInteger('is_featured')->default('0');
            $table->string('view_count')->nullable();
            $table->string('meta_key')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('youtube_link')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
