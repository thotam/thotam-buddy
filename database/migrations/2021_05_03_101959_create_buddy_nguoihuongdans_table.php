<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuddyNguoihuongdansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buddy_nguoihuongdans', function (Blueprint $table) {
            $table->string('hr_key', 10);
            $table->foreign('hr_key')->references('key')->on('hrs')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('buddy_id')->unsigned();
            $table->primary(['hr_key', 'buddy_id']);
            $table->foreign('buddy_id')->references('id')->on('buddies')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buddy_nguoihuongdans');
    }
}
