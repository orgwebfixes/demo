<?php

namespace App\Repositories;

use App;
use Carbon\Carbon;
use Config;
use DB;
use GuzzleHttp\Client;
use App\Models\ApiLogsStatus;
use App\Models\Basic;
use App\Models\Plan;
use Exception;

class RestAPIsRepo
{
    public function __Construct(Client $client)
    {
        $this->client = $client;
    }

    protected function getBaseUrl()
    {
        return false;
    }
    
}
