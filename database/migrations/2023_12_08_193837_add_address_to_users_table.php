<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('shipping_address_id');
            $table->foreign('shipping_address_id')->references('id')->on('shipping_address')->onDelete('cascade');

            $table->uuid('billing_address_id');
            $table->foreign('billing_address_id')->references('id')->on('billing_address')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['shipping_address_id']);
            $table->dropColumn('shipping_address_id');

            $table->dropForeign(['billing_address_id']);
            $table->dropColumn('billing_address_id');
        });
    }
};
