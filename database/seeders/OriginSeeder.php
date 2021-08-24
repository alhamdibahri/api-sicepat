<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Origin;

class OriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url = "http://apitrek.sicepat.com/customer/origin";
        $key="c3898756d1a9ce2d0c7c5316d73a6273";
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => null, 
            CURLOPT_HTTPHEADER => [
                "api-key: ".$key
            ],
        ]);
        $response = curl_exec($curl);

        $datas =  json_decode($response);

        $origins = [];
        foreach($datas->sicepat->results as $origin){
            $origins[] = [
                'origin_code' => $origin->origin_code,
                'origin_name' => $origin->origin_name
            ];
        }

        Origin::insert($origins);
    }
}
