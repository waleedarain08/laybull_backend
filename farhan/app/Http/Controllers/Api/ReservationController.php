<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{User,Reservation};
use Illuminate\Support\Facades\Validator;
use Exception;

class ReservationController extends Controller
{
   
    public function vendorreservation($vendorId = null)
    {
        try
        {
            $model =  new User();
            if($vendorId)
            {
                $record = $model->where('reservation',1)->with('reservations')->find($vendorId);
            }
            else
            $record = $model->where('reservation',1)->with('reservations')->get();
            if($record && $record->count() > 0 )
            {
                $success['record'] = $record;
                return response()->json(['success' => $success]);
            }else
            {
                $error['message'] = 'Data not found';
                return response()->json(['error' => $error], 404);
            }
        }
        catch(Exception $e){
            
            $error['message'] = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }
    }


    public function getreservation($id)
    {
        
        $model =  new User();
        $record = $model->where('reservation',1)->find($id);
        $reservation = new Reservation();
        $recordMorning = $reservation->where('vendor_id',$id)->where('name','morning')->get();
        $recordDinner = $reservation->where('vendor_id',$id)->where('name','dinner')->get();
        $recordLunch = $reservation->where('vendor_id',$id)->where('name','lunch')->get();
       
        $success = ['vendor'=>$record,'morning'=>$recordMorning,'lunch'=>$recordLunch,'dinner'=>$recordDinner];
        return response()->json(['success'=>$success]);


        
    }
    public function getallreservation()
    {
        
        try
        {
          $model =  new User();
        $records = $model->where('reservation',1)->whereHas('reservations')->with(['reservations', 'detail'])->get();
       
        $finalRecords = [];
        foreach($records->toArray() as $key=>$record){
            $obj = [];
            $obj = [
                'id' => $record['id'],
                'name' => $record['name'],
                'currency' => $record['currency'],
                'image' => $record['detail']['image']
            ];
            $finalRecords['vendor'][$key] = $obj;

            foreach($record['reservations'] as $reservation){
                if($reservation['name'] == 'breakfast'){
                    $finalRecords['vendor'][$key]['reservations']['Breakfast'][] =  $reservation;
                }
                if($reservation['name'] == 'lunch'){
                    $finalRecords['vendor'][$key]['reservations']['Lunch'][] =  $reservation;                    
                }
                if($reservation['name'] == 'dinner'){
                    $finalRecords['vendor'][$key]['reservations']['Dinner'][] =  $reservation;                    
                }
            }
            
        }
        
        return response()->json(['success'=> $finalRecords]);
  
        }
        catch(Exception $e)
        {
           return response()->json(['error'=>$e]); 
        }
        
        


        
    }
     public function getallreservationdetail()
    {
        
        try
        {
          $model =  new User();
        $records = $model->where('reservation',1)->whereHas('reservations')->with(['reservations', 'detail', 'locations'])->get();
       
        $finalRecords = [];
        foreach($records->toArray() as $key=>$record){
            $obj = [];
            $obj = [
                'id' => $record['id'],
                'name' => $record['name'],
                'currency' => $record['currency'],
                'image' => $record['detail']['image'],
                'address'=> $record['locations'] && count($record['locations']) > 0 ? $record['locations'][0]['address'] : 'N/A',
                'phone' => $record['detail']['phone'],
                'serviceTax' => $record['detail']['service_tax'],
                'deliveryFees' => $record['detail']['delivery_fees'],
                'takeawayTax' => $record['detail']['takeaway_tax'],
                'advance' => $record['detail']['advance'],
            ];
            $names = [];
            $finalRecords['vendor'][$key] = $obj;
            foreach($record['reservations'] as $resKey => $reservation){

                if($reservation['name'] == 'breakfast'){
                    if(!in_array($reservation['name'], $names)){
                        array_push($names, $reservation['name']);
                        $abj = [];
                        $abj = [
                            'vendor_id' => $reservation['vendor_id'],
                            'name'=> $reservation['name'],                    
                        ];
                        $finalRecords['vendor'][$key]['reservations'][$resKey] = $abj;
                        $finalRecords['vendor'][$key]['reservations'][$resKey]['time'] = collect($record['reservations'])->where('name', 'breakfast')->toArray();
                        $finalRecords['vendor'][$key]['reservations'][$resKey]['time'] = array_values($finalRecords['vendor'][$key]['reservations'][$resKey]['time']);                    
                    }
                    // $finalRecords['vendor'][$key]['reservations'] = array_values($finalRecords['vendor'][$key]['reservations']);
                    // $finalRecords['vendor'][$key]['reservations'][$resKey]['time'][] = $reservation;
                }

                if($reservation['name'] == 'lunch'){
                    if(!in_array($reservation['name'], $names)){
                        array_push($names, $reservation['name']);
                        $abj = [];
                        $abj = [
                            'vendor_id' => $reservation['vendor_id'],
                            'name'=> $reservation['name'],                    
                        ];
                        $finalRecords['vendor'][$key]['reservations'][$resKey] = $abj;
                        $finalRecords['vendor'][$key]['reservations'][$resKey]['time'] = collect($record['reservations'])->where('name', 'lunch')->toArray();
                        $finalRecords['vendor'][$key]['reservations'][$resKey]['time'] = array_values($finalRecords['vendor'][$key]['reservations'][$resKey]['time']);                    
                    }
                    // $finalRecords['vendor'][$key]['reservations'] = array_values($finalRecords['vendor'][$key]['reservations']);
                    // $finalRecords['vendor'][$key]['reservations'][$resKey]['time'][] = $reservation;
                }

                if($reservation['name'] == 'dinner'){
                    if(!in_array($reservation['name'], $names)){
                        array_push($names, $reservation['name']);
                        $abj = [];
                        $abj = [
                            'vendor_id' => $reservation['vendor_id'],
                            'name'=> $reservation['name'],                    
                        ];
                        $finalRecords['vendor'][$key]['reservations'][$resKey] = $abj;
                        $finalRecords['vendor'][$key]['reservations'][$resKey]['time'] = collect($record['reservations'])->where('name', 'dinner')->toArray();
                        $finalRecords['vendor'][$key]['reservations'][$resKey]['time'] = array_values($finalRecords['vendor'][$key]['reservations'][$resKey]['time']);                    
                    }
                    // dd(collect($record['reservations'])->where('name', 'dinner'));
                    // $finalRecords['vendor'][$key]['reservations'][$resKey]['time'][] = $reservation;
                }
                                
                $finalRecords['vendor'][$key]['reservations'] = array_values($finalRecords['vendor'][$key]['reservations']);


                
                // print_r($names);
                
                // $finalRecords['vendor'][$key]['reservations']['records'] = $abj;
            //    if($reservation['name'] == 'breakfast'){
            //         $finalRecords['vendor'][$key]['reservations'] = $abj;
            //         $finalRecords['vendor'][$key]['reservations']['time'][] = $reservation; 

            //     }
            //     if($reservation['name'] == 'lunch'){
                   
            //         $finalRecords['vendor'][$key]['reservations'] = $abj;
            //         $finalRecords['vendor'][$key]['reservations']['time'][] = $reservation;                    
            //     }
            //     if($reservation['name'] == 'dinner'){
                   
            //         $finalRecords['vendor'][$key]['reservations'] = $abj;
            //         $finalRecords['vendor'][$key]['reservations']['time'][] = $reservation;                        
            //     }
            }
            
        }
        
        return response()->json(['success'=> $finalRecords]);
  
        }
        catch(Exception $e)
        {
           return response()->json(['error'=>$e->getMessage()]); 
        }
        
        


        
    }




    
}
