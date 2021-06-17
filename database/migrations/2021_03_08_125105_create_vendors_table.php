<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('business_owner_name');
            $table->string('business_name');
            $table->string('business_type');
            $table->string('business_start_date');
            $table->string('location');
            $table->string('address');
            $table->string('gst_no')->nullable();
            $table->string('aadhar_img')->nullable();
            $table->string('pan_img')->nullable();
            $table->string('shop_img')->nullable();
            $table->string('username');
            $table->string('password');
            $table->string('show_pwd');
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
        Schema::dropIfExists('vendors');
    }
}
