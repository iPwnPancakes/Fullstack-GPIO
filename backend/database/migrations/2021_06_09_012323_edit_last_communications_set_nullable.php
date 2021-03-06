<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditLastCommunicationsSetNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacuum', function (Blueprint $table) {
            $table->dateTime('last_communication_at')->nullable(true)->change();
            $table->dateTime('last_communication_attempt_at')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacuum', function (Blueprint $table) {
            $table->dateTime('last_communication_at')->nullable(false)->change();
            $table->dateTime('last_communication_attempt_at')->nullable(false)->change();
        });
    }
}
