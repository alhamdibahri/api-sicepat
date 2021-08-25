<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SiCepat\Customer as SiCepatCustomer;
use App\Models\Tracking;
use App\Services\SiCepat\Pickup as SiCepatPickup;
use App\Http\Requests\PickupRequest;
use App\Http\Requests\CancelPickup;
use App\Models\Pickup;
use App\Models\PackageList;

class SiCepatController extends Controller
{
    public function __construct(SiCepatCustomer $SiCepatCustomer, SiCepatPickup $SiCepatPickup)
    {
        $this->SiCepatCustomer = $SiCepatCustomer;
        $this->SiCepatPickup = $SiCepatPickup;
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

    public function waybill_refno(Request $request){
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

    public function pickup(PickupRequest $request){
        try {

            $payload = $request->all();

            $datas = $this->SiCepatPickup->pickup($payload);

            if($datas->status === "400"){
                return response()->json([
                    'success' => false,
                    'message' => $datas->error_message,
                ], 400);
            }else{
                $pickup = Pickup::create($payload);
                $lists = [];
                foreach($payload['PackageList'] as $list){
                    $list['pickup_id'] = $pickup->id;
                    $lists [] = $list;
                }
                $pickup->package_list()->insert($lists);

                return response()->json([
                    'success' => false,
                    'values' => $payload,
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

    public function cancel_pickup(CancelPickup $request){
        try {

            $payload = $request->all();

            $datas = $this->SiCepatPickup->cancel_pickup($payload);

            if($datas->status === "400"){
                return response()->json([
                    'success' => false,
                    'message' => $datas->error_message,
                ], 400);
            }else{
                $package_list = PackageList::where('receipt_number', $payload['receipt_number'])->first();
                if($package_list){
                    $package_list->delete();
                    return response()->json([
                        'success' => false,
                        'message' => $datas->message,
                    ], 200);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'receipt_number tidak ditemukan',
                    ], 400);
                }
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
