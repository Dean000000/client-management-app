<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveStatusFromAssetsTable extends Migration
{
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('status'); // Remove the status column
        });
    }

    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->unsignedInteger('status')->default(1); // Re-add the status column if needed
        });
    }
}
