<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacuumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacuum', function (Blueprint $table) {
            $table->id();
            $table->timestamp('last_communication_at');
            $table->boolean('connected')->default(false);
            $table->ipAddress('public_ip');
            $table->unsignedInteger('port')->default(80);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacuum');
    }
}
