<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pickup_id')->unsigned();
            $table->string('receipt_number');
            $table->string('origin_code');
            $table->string('delivery_type');
            $table->string('parcel_content');
            $table->string('parcel_category');
            $table->float('parcel_qty');
            $table->string('parcel_uom');
            $table->float('parcel_value');
            $table->float('total_weight');
            $table->string('shipper_name');
            $table->text('shipper_address');
            $table->string('shipper_province');
            $table->string('shipper_city');
            $table->string('shipper_district');
            $table->string('shipper_zip');
            $table->string('shipper_phone');
            $table->string('shipper_longitude');
            $table->string('shipper_latitude');
            $table->string('recipient_title');
            $table->string('recipient_name');
            $table->text('recipient_address');
            $table->string('recipient_province');
            $table->string('recipient_city');
            $table->string('recipient_district');
            $table->string('recipient_zip');
            $table->string('recipient_phone');
            $table->string('recipient_longitude');
            $table->string('recipient_latitude');
            $table->string('destination_code');
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
        Schema::dropIfExists('package_lists');
    }
}
