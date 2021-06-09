<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastCommunicationAttemptColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacuum', function (Blueprint $table) {
            $table->timestamp('last_communication_attempt_at');
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
            $table->dropColumn('last_communication_attempt_at');
        });
    }
}
