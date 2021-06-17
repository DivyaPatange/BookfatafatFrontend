<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMobileNoColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('google_id')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('otp')->nullable();
            $table->boolean('verified')->default(0);
            $table->string('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('google_id');
            $table->dropColumn('mobile_no');
            $table->dropColumn('otp');
            $table->dropcolumn('verified');
            $table->dropColumn('avatar');
        });
    }
}
