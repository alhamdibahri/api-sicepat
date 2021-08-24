<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
            $table->string('waybill_number');
            $table->string('kodeasal');
            $table->string('kodetujuan');
            $table->string('service');
            $table->float('weight');
            $table->string('partner')->nullable();
            $table->string('sender');
            $table->string('sender_address');
            $table->string('receiver_address');
            $table->string('receiver_name');
            $table->float('realprice');
            $table->float('totalprice');
            $table->text('POD_receiver');
            $table->string('POD_receiver_time');
            $table->string('send_date');
            $table->string('perwakilan');
            $table->string('pop_sigesit_img_path')->nullable();
            $table->string('pod_sigesit_img_path')->nullable();
            $table->string('pod_sign_img_path')->nullable();
            $table->string('pod_img_path')->nullable();
            $table->string('manifested_img_path')->nullable();
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
        Schema::dropIfExists('trackings');
    }
}
