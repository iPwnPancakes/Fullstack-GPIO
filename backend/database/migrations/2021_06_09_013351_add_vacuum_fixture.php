<?php

use App\Models\Vacuum;
use Illuminate\Database\Migrations\Migration;

class AddVacuumFixture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $vacuum = new Vacuum();

        $vacuum->public_ip = '192.168.1.10';
        $vacuum->port = 80;

        $vacuum->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $vacuum = Vacuum::where('public_ip', '192.168.1.10')->first();

        if ($vacuum) {
            $vacuum->delete();
        }
    }
}
