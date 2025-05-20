<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Rename total_price to total to match your model
            $table->renameColumn('total_price', 'total');

            // Add all the new columns
            $table->string('first_name')->after('user_id');
            $table->string('company_name')->nullable()->after('first_name');
            $table->string('street_address')->after('company_name');
            $table->string('apartment')->nullable()->after('street_address');
            $table->string('town_city')->after('apartment');
            $table->string('phone')->after('town_city');
            $table->string('email')->after('phone');
            $table->string('payment_method')->after('email');
            $table->text('notes')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Reverse the changes
            $table->renameColumn('total', 'total_price');

            $table->dropColumn([
                'first_name',
                'company_name',
                'street_address',
                'apartment',
                'town_city',
                'phone',
                'email',
                'payment_method',
                'notes'
            ]);
        });
    }
};
