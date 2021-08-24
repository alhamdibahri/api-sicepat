<?php

namespace App\Services\SiCepat;

class Customer {

    protected $url = "http://apitrek.sicepat.com/customer/";

    public function get_services($url, $method, $data){
        $url_services = $this->url . $url . $data;
        $key="c3898756d1a9ce2d0c7c5316d73a6273";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url_services,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data, 
            CURLOPT_HTTPHEADER => [
                "api-key: ".$key
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

    public function get_tarif($request){
        try {
            $data = $this->get_services('tariff', 'GET', $request);
            if($data->error == null){
                return $data->response;
            }else{
                return $data->error;
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function waybill($request){
        try {
            $data = $this->get_services('waybill', 'GET', $request);
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
