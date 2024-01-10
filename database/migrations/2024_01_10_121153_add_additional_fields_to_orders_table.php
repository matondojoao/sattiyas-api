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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('country_region')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email_address')->nullable();
            $table->string('house_number_and_street')->nullable();
            $table->string('apartment_suite_optional')->nullable();
            $table->text('order_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('company_name');
            $table->dropColumn('country_region');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('postal_code');
            $table->dropColumn('phone');
            $table->dropColumn('email_address');
            $table->dropColumn('order_notes');
            $table->dropColumn('house_number_and_street');
            $table->dropColumn('apartment_suite_optional');
        });
    }
};
