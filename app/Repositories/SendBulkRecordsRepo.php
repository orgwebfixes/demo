<?php
/**
 * send bulk data to particular ERP
 */

namespace App\Repositories;

use App;
use Carbon\Carbon;
use Config;
use DB;
use GuzzleHttp\Client;
use Exception;

class SendBulkRecordsRepo
{
    public function __Construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * sending feature module data into particular ERP
     *
     * @param [type] $features
     * @return void
     * @date 12-12-2019
     * @author ketan savaliya <savaliya11.ketan@gmail.com>
     */
    /* public function insertAllFeatures($features){

    } */

    public function callApiRequest($baseUrl, $apiName, $postType, $params)
    {
        try {
            $baseUrl = preg_replace('{/$}', '', $baseUrl);
            \Log::info($baseUrl . '-' . $apiName . '-' . $postType);
            //\Log::info($params);
            /* echo "<pre>"; print_r($baseUrl); echo "</pre>";
            echo "<pre>"; print_r($apiName); echo "</pre>";
            echo "<pre>"; print_r($params); echo "</pre>"; exit; */
            $res = $this->client->request($postType, $baseUrl . '/' . $apiName, [
                'form_params' => $params
            ]);
            return true;
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return false;
        }
    }
}
