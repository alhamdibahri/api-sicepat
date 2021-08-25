<?php

namespace App\Services\SiCepat;

class Pickup {

    protected $url = "http://pickup.sicepat.com:8087/api/partner/";

    public function get_services($url, $method, $data){
        $url = "http://pickup.sicepat.com:8087/api/partner/" . $url;
        $data['auth_key'] = "834DEF2BCAB449D0BFC9DA2925A85B2A";
        $postdata = http_build_query($data);
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postdata, 
            CURLOPT_HTTPHEADER => [
                "content-type: application/x-www-form-urlencoded",
            ],
        ]);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        return (object)[
            'error' =>  $error,
            'response' =>  json_decode($response),
        ];
    }

    public function pickup($request){
        try {
            $data = $this->get_services('requestpickuppackage', 'POST', $request);
            if($data->error == null){
                return $data->response;
            }else{
                return $data->error;
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function cancel_pickup($request){
        try {
            $data = $this->get_services('cancelpickup', 'POST', $request);
            if($data->error == null){
                return $data->response;
            }else{
                return $data->error;
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
     
}
