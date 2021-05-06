<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuddyTieuchisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buddy_tieuchis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('buddy_id')->unsigned()->nullable()->default(null);
            $table->longText('tentieuchi')->nullable()->default(null);
            $table->longText('noidung')->nullable()->default(null);
            $table->longText('ketqua_candat')->nullable()->default(null);
            $table->longText('ghichu')->nullable()->default(null);
            $table->timestamp('deadline')->nullable();
            $table->string('hr_key')->nullable()->default(null);
            $table->boolean('lock')->nullable()->default(null);
            $table->boolean('active')->nullable()->default(null);
            $table->unsignedBigInteger('created_by')->nullable()->default(null);
            $table->unsignedBigInteger('updated_by')->nullable()->default(null);
            $table->unsignedBigInteger('deleted_by')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('hr_key')->references('key')->on('hrs')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('buddy_id')->references('id')->on('buddies')->onDelete('SET NULL')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buddy_tieuchis');
    }
}
