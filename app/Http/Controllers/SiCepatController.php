<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SiCepat\Customer as SiCepatCustomer;
use App\Models\Tracking;

class SiCepatController extends Controller
{
    public function __construct(SiCepatCustomer $SiCepatCustomer)
    {
        $this->SiCepatCustomer = $SiCepatCustomer;
    }

    public function get_tarif(Request $request){

        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
            'weight' => 'required|min:1',
        ]);

        $payload = '?origin=' . $request->origin . '&destination=' . $request->destination . '&weight=' . $request->weight;
        $datas = $this->SiCepatCustomer->get_tarif($payload);
        return $datas;
    }

    public function waybill(Request $request){
        try {
            $request->validate([
                'waybill' => 'required',
            ]);

            $payload = '?waybill=' . $request->waybill;

            $datas = $this->SiCepatCustomer->waybill($payload);

            
            if($datas->sicepat->status->code == 400){
                return response()->json([
                    'success' => false,
                    'message' => 'Resi Yang Anda Masukkan Salah',
                ], 400);
            }else{
                $result = $datas->sicepat->result;
                $payloadTracking = [
                    'waybill_number' => $result->waybill_number,
                    'kodeasal' => $result->kodeasal,
                    'kodetujuan' => $result->kodetujuan,
                    'service' => $result->service,
                    'weight' => $result->weight,
                    'partner' => $result->partner,
                    'sender' => $result->sender,
                    'sender_address' => $result->sender_address,
                    'receiver_address' => $result->receiver_address,
                    'receiver_name' => $result->receiver_name,
                    'realprice' => $result->realprice,
                    'totalprice' => $result->totalprice,
                    'POD_receiver' => $result->POD_receiver,
                    'POD_receiver_time' => $result->POD_receiver_time,
                    'send_date' => $result->send_date,
                    'perwakilan' => $result->perwakilan,
                    'pop_sigesit_img_path' => $result->pop_sigesit_img_path,
                    'pod_sigesit_img_path' => $result->pod_sigesit_img_path,
                    'pod_sign_img_path' => $result->pod_sign_img_path,
                    'pod_img_path'=> $result->pod_img_path,
                    'manifested_img_path' => $result->manifested_img_path,
                ];
                $tracking = Tracking::create($payloadTracking);

                $tracking_details = [];
                foreach($result->track_history as $detail){
                    $tracking_details[] = [
                        'date_time' => $detail->date_time,
                        'status' => $detail->status,
                        'city' => $detail->status == 'DELIVERED' ? $detail->receiver_name : $detail->city,
                        'tracking_id' => $tracking->id
                    ];
                }

                $tracking->tracking_details()->insert($tracking_details);

                return response()->json([
                    'success' => false,
                    'values' => $result,
                    'message' => 'Data Berhasil Di simpan',
                ], 201);
            }


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
        

       
    }
}
