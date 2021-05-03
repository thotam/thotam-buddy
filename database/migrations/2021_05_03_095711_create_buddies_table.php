<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuddiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buddies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('buddy_code', 15)->nullable()->default(null)->unique();
            $table->bigInteger('nhom_id')->unsigned()->nullable()->default(null);
            $table->string('quanly_hr_key')->nullable()->default(null);
            $table->longText('nhucau')->nullable()->default(null);
            $table->longText('ghichu')->nullable()->default(null);
            $table->timestamp('ngayvaolam')->nullable();
            $table->string('hr_key')->nullable()->default(null);
            $table->boolean('active')->nullable()->default(null);
            $table->bigInteger('trangthai_id')->unsigned()->nullable()->default(null);
            $table->unsignedBigInteger('created_by')->nullable()->default(null);
            $table->unsignedBigInteger('updated_by')->nullable()->default(null);
            $table->unsignedBigInteger('deleted_by')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('hr_key')->references('key')->on('hrs')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('nhom_id')->references('id')->on('nhoms')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('quanly_hr_key')->references('key')->on('hrs')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('trangthai_id')->references('id')->on('buddy_trangthais')->onDelete('SET NULL')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buddies');
    }
}
