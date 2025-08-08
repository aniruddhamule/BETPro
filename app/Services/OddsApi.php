<?php

namespace App\Services;

use App\Models\General;
use GuzzleHttp\Client;

class OddsApi{

    protected $url;
    protected $headers;
    protected $api_key;
    protected $sub_url = 'sports';


    public function __construct()
    {
        $gnl = General::first();
        $this->url =  ''.$gnl->api_url.'';
        $this->api_key = config('betsapi')['odds_api_key'] ?? $gnl->api_key;
        $this->headers = [
            'cache-control' => 'no-cache',
            'content-type' => 'application/json',
        ];
    }

    private function getResponse(string $uri = null, array $post_params = [])
    {
        $full_path = $this->url.$this->sub_url.'/';
        $post_params['apiKey'] = $this->api_key;
        $full_path .= $uri.'?'.http_build_query($post_params);

        $fire = curl_get_file_contents($full_path);
        return json_decode($fire);
       
    }

    private function postResponse(string $uri = null, array $post_params = [])
    {
        $full_path = $this->url;
        $full_path .= $uri;

        $request = $this->http->post($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 3000,
            'connect_timeout' => true,
            'http_errors'     => true,
            'form_params'     => $post_params,
        ]);

        $response = $request ? $request->getBody()->getContents() : null;
        $status = $request ? $request->getStatusCode() : 500;

        if ($response && $status === 200 && $response !== 'null') {
            return (object) json_decode($response);
        }

        return null;
    }

    public static function getSports()
    {
        $params = ['all'=>'true'];
        return (new self)->getResponse(null,$params);
    }

    public static function groupBySports(string $group_name)
    {
        $params = ['regions'=>'au,uk,us,eu','oddsFormat'=>'decimal','dateFormat' => 'unix'];
        return (new self)->getResponse($group_name.'/odds',$params);
    }

    public static function getOdds(string $type)
    {
        $params = ['regions'=>'au,uk,us,eu','markets'=>'h2h,spreads', 'dateFormat' => 'unix', 'bookmakers' => 'betfair', 'oddsFormat' => 'decimal'];
        return (new self)->getResponse($type.'/odds',$params);
    }

    public static function getScores(string $group, int $days_from)
    {
        $params = ['daysFrom'=>$days_from];
        return (new self)->getResponse($group.'/scores',$params);
    }


}