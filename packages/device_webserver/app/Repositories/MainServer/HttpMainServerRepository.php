<?php


namespace App\Repositories\MainServer;


use App\Core\Result;
use Illuminate\Support\Facades\Http;

class HttpMainServerRepository implements IMainServerRepository
{
    /**
     * @inheritDoc
     */
    public function checkIn(): Result
    {
        $main_server_url = env('MAIN_SERVER_URL');

        try {
            $response = Http::get($main_server_url . '/checkin');
        } catch(\Exception $e) {
            return Result::fail($e->getMessage());
        }

        if($response->failed()) {
            return Result::fail('Communication Failure. Response code ' . $response->status());
        }

        return Result::ok();
    }
}
