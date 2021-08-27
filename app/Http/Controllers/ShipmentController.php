<?php

namespace App\Http\Controllers;
 Use \Carbon\Carbon;
use App\Shipment;
use App\Product;
use App\Country;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Octw\Aramex\Aramex;
use SoapClient;
use stdClass;
class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $model = new Shipment();
       
    //   dd($model);
        $records = $model->latest()->paginate(config('app.pagination_length'));
        $display= array('#','Seller Name','Buyer Name','Product','Total Amount','Action');
        return view('Order.index')
            ->with('records',$records)
            ->with('display',$display);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $validator = Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'user_id'=>'required',
            'product_id' => 'required',
            'city' => 'required',
            'country'=>'required',
            'address_1' => 'required',
            'phone' => 'required',
            'discount_percent'=>'required',
             'amount' => 'required|numeric',
             'email' => 'required|email',
           
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        
 $data = Aramex::validateAddress([
    'line1'=>$request->address_1, // optional (Passing it is recommended)
    // 'line2'=>'Test', // optional
    // 'line3'=>'Test', // optional
    'country_code'=>$request->country_code,
    // 'postal_code'=>'', // optional
    'city'=>$request->city,
  ]);
  if(!isset($data->error)){
        try {
            $amount1=$request->amount;
            $amount = ($request->amount)*100;
            $email = $request->email;
            // $price_unit = $request->price_unit;
            $shipment = new Shipment();
            $shipment->first_name = $request->first_name;
            $shipment->last_name = $request->last_name;
            $shipment->email = $request->user_email;
            $shipment->phone = $request->phone;
            $shipment->address_1 = $request->address_1;
            $shipment->address_2 = $request->address_2;
            $shipment->city = $request->city;
            $shipment->country = $request->country;
            $shipment->currency_unit = $request->currency_unit;
            $shipment->discount_percent = $request->discount_percent;
            $shipment->user_id = $request->user_id;
            $shipment->product_id = $request->product_id;
            $shipment->shipment_charges = $request->shipment_charges;
            $shipment->seller_id=$request->seller_id;
             $shipment->total_amount=$amount1;
            $shipment->save();
        //     $apikey = "MWQ0ZjBlMzEtMWU5MS00YWJjLWEzMzctOGIyMTc3MmQ0Mzk1OmVlODhmZTNiLTdkZjgtNDdkZS1hMTQ1LWRjMmI4M2Q0OTFhMQ==";     // enter your API key here
        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, "https://api-gateway.sandbox.ngenius-payments.com/identity/auth/access-token");
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //         "accept: application/vnd.ni-identity.v1+json",
        //         "authorization: Basic ".$apikey,
        //         "content-type: application/vnd.ni-identity.v1+json"
        //     ));
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS,  "{\"realmName\":\"ni\"}");
        //     $output = json_decode(curl_exec($ch));
        //     $access_token = $output->access_token;
        //   $postData = new StdClass();
        //     $postData->action = "SALE";
        //      $postData->amount = new StdClass();
        //      $postData->amount->currencyCode = "AED";
        //      $postData->amount->value = $amount;
        //      $postData->emailAddress= $email;
        //     $outlet = "6186e5ee-4407-4885-8808-636919548ea8";
        //     $token = $access_token;

        //     $json = json_encode($postData);
        //     $ch = curl_init();

        //     curl_setopt($ch, CURLOPT_URL, "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outlet."/orders");
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //         "Authorization: Bearer ".$token,
        //         "Content-Type: application/vnd.ni-payment.v2+json",
        //         "Accept: application/vnd.ni-payment.v2+json"));
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        //     $output = json_decode(curl_exec($ch));
        //     $order_reference = $output->reference;
        //     $order_paypage_url = $output->_links->payment->href;

        //     curl_close ($ch);
    return response()->json(['status'=>'True']);

            // return response()->json(['status'=>'True','payment_link'=>$order_paypage_url,'price_unit'=>$request->price_unit]);

        }
        catch (\Exception $e){
            return response()->json(['status'=>false,'error',$e->getMessage()]);
        }
  }
  else
  {
            return response()->json(['status'=>false,'error'=>1,'data'=>$data]);
         
  }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function list_of_sold_product(Request $request)
    {
        $data['list_of_sold_product']=Shipment::where('user_id',Auth::user()->id)->get();
        return response()->json(compact('data'),200);
    }
    public function placeOrder1(Request $request)
{
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	ini_set("soap.wsdl_cache_enabled", "0");
// 	ini_set("default_socket_timeout", 200);
	ini_set('default_socket_timeout', 5000);
$soapClient = new \SoapClient('https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc?wsdl',array(
    'trace' =>true,
    'connection_timeout' => 5000,
    'cache_wsdl' => WSDL_CACHE_NONE,
    'keep_alive' => false,
));
	
// 	$soapClient = new SoapClient('https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc?wsdl');
	echo '<pre>';
	print_r($soapClient->__getFunctions());

	$params = array(
			'Shipments' => array(
				'Shipment' => array(
						'Shipper'	=> array(
										'Reference1' 	=> 'Ref 111111',
										'Reference2' 	=> 'Ref 222222',
								// 		'AccountNumber' => '20016',
								// 		'PartyAddress'	=> array(
								// 			'Line1'					=> 'Mecca St',
								// 			'Line2' 				=> '',
								// 			'Line3' 				=> '',
								// 			'City'					=> 'DUBAI',
								// 			'StateOrProvinceCode'	=> '',
								// 			'PostCode'				=> '',
								// 			'CountryCode'			=> 'AE'
								// 		),
								// 		'Contact'		=> array(
								// 			'Department'			=> '',
								// 			'PersonName'			=> 'Michael',
								// 			'Title'					=> '',
								// 			'CompanyName'			=> 'Aramex',
								// 			'PhoneNumber1'			=> '5555555',
								// 			'PhoneNumber1Ext'		=> '125',
								// 			'PhoneNumber2'			=> '',
								// 			'PhoneNumber2Ext'		=> '',
								// 			'FaxNumber'				=> '',
								// 			'CellPhone'				=> '07777777',
								// 			'EmailAddress'			=> 'michael@aramex.com',
								// 			'Type'					=> ''
								// 		),
						),
												
						'Consignee'	=> array(
										'Reference1'	=> 'Ref 333333',
										'Reference2'	=> 'Ref 444444',
										'AccountNumber' => '',
										'PartyAddress'	=> array(
											'Line1'					=> '15 ABC St',
											'Line2'					=> '',
											'Line3'					=> '',
											'City'					=> 'Dubai',
											'StateOrProvinceCode'	=> '',
											'PostCode'				=> '',
											'CountryCode'			=> 'AE'
										),
										
								// 		'Contact'		=> array(
								// 			'Department'			=> '',
								// 			'PersonName'			=> 'Mazen',
								// 			'Title'					=> '',
								// 			'CompanyName'			=> 'Aramex',
								// 			'PhoneNumber1'			=> '6666666',
								// 			'PhoneNumber1Ext'		=> '155',
								// 			'PhoneNumber2'			=> '',
								// 			'PhoneNumber2Ext'		=> '',
								// 			'FaxNumber'				=> '',
								// 			'CellPhone'				=> '',
								// 			'EmailAddress'			=> 'mazen@aramex.com',
								// 			'Type'					=> ''
								// 		),
						),
						
				// 		'ThirdParty' => array(
				// 						'Reference1' 	=> '',
				// 						'Reference2' 	=> '',
				// 						'AccountNumber' => '',
				// 						'PartyAddress'	=> array(
				// 							'Line1'					=> '',
				// 							'Line2'					=> '',
				// 							'Line3'					=> '',
				// 							'City'					=> '',
				// 							'StateOrProvinceCode'	=> '',
				// 							'PostCode'				=> '',
				// 							'CountryCode'			=> ''
				// 						),
				// 						'Contact'		=> array(
				// 							'Department'			=> '',
				// 							'PersonName'			=> '',
				// 							'Title'					=> '',
				// 							'CompanyName'			=> '',
				// 							'PhoneNumber1'			=> '',
				// 							'PhoneNumber1Ext'		=> '',
				// 							'PhoneNumber2'			=> '',
				// 							'PhoneNumber2Ext'		=> '',
				// 							'FaxNumber'				=> '',
				// 							'CellPhone'				=> '',
				// 							'EmailAddress'			=> '',
				// 							'Type'					=> ''							
				// 						),
				// 		),
						
						'Reference1' 				=> 'Shpt 0001',
						'Reference2' 				=> '',
						'Reference3' 				=> '',
						'ForeignHAWB'				=> 'ABC 000111',
						'TransportType'				=> 0,
						'ShippingDateTime' 			=> time(),
						'DueDate'					=> time(),
						'PickupLocation'			=> 'Reception',
						'PickupGUID'				=> '',
						'Comments'					=> 'Shpt 0001',
						'AccountingInstrcutions' 	=> '',
						'OperationsInstructions'	=> '',
						
						'Details' => array(
										'Dimensions' => array(
											'Length'				=> 10,
											'Width'					=> 10,
											'Height'				=> 10,
											'Unit'					=> 'cm',
											
										),
										
										'ActualWeight' => array(
											'Value'					=> 0.5,
											'Unit'					=> 'Kg'
										),
										
										'ProductGroup' 			=> 'EXP',
										'ProductType'			=> 'PDX',
										'PaymentType'			=> 'P',
										'PaymentOptions' 		=> 'null',
										'Services'				=> 'null',
										'NumberOfPieces'		=> 1,
										'DescriptionOfGoods' 	=> 'Docs',
										'GoodsOriginCountry' 	=> 'DUBAI',
										
										'CashOnDeliveryAmount' 	=> array(
											'Value'					=> 0,
											'CurrencyCode'			=> ''
										),
										
										'InsuranceAmount'		=> array(
											'Value'					=> 0,
											'CurrencyCode'			=> ''
										),
										
										'CollectAmount'			=> array(
											'Value'					=> 0,
											'CurrencyCode'			=> ''
										),
										
										'CashAdditionalAmount'	=> array(
											'Value'					=> 0,
											'CurrencyCode'			=> ''							
										),
										
										'CashAdditionalAmountDescription' => '',
										
										'CustomsValueAmount' => array(
											'Value'					=> 0,
											'CurrencyCode'			=> 'AED'								
										),
										
										'Items' 				=> array(
											
										)
						),
				),
		),
		
			'ClientInfo'  			=> array(
										'AccountCountryCode'	=> 'AE',
										'AccountEntity'		 	=> 'DXB',
										'AccountNumber'		 	=> '20016',
										'AccountPin'		 	=> '116216',
										'UserName'			 	=> 'reem@reem.com',
										'Password'			 	=> '123456789',
										'Version'			 	=> '1.0'
									),

			'Transaction' 			=> array(
										'Reference1'			=> '001',
										'Reference2'			=> '', 
										'Reference3'			=> '', 
										'Reference4'			=> '', 
										'Reference5'			=> '',									
									),
			'LabelInfo'				=> array(
										'ReportID' 				=> 9201,
										'ReportType'			=> 'URL',
			),
	);
	
	$params['Shipments']['Shipment']['Details']['Items'][] = array(
		'PackageType' 	=> 'Box',
		'Quantity'		=> 1,
		'Weight'		=> array(
				'Value'		=> 0.5,
				'Unit'		=> 'Kg',		
		),
		'Comments'		=> 'Docs',
		'Reference'		=> ''
	);
	
// 	print_r($params);
	
	try {
		$auth_call = $soapClient->CreateShipments($params);
		echo '<pre>';
		print_r($auth_call);
		die();
	} catch (SoapFault $fault) {
		die('Error : ' . $fault->faultstring);
	}

}
public function placeOrder(Request $request)
{
//   $date= time() + 60000;
// //   $date = Carbon::now()->format('D');
// //  $time=(int)61200;
//  dd( date('y:m:d', $date));
// dd( $date);
//      $data = Aramex::validateAddress([
//     'line1'=>'Lahore', // optional (Passing it is recommended)
//     // 'line2'=>'Test', // optional
//     // 'line3'=>'Test', // optional
//     'country_code'=>'AE',
//     'postal_code'=>'', // optional
//     'city'=>'DUBAI',
//   ]);
//       return response()->json(compact('data'),200);
    
//   $data = Aramex::fetchCities('PK'); 
// //   return response()
//     return response()->json(compact('data'),200);
// //     $data = Aramex::validateAddress([
//     'line1'=>'dar al zahya building,block B,Apartment no 101 Dubai', // optional (Passing it is recommended)
//     // 'line2'=>'Dubai', // optional
//     // 'line3'=>'Test', // optional
//     'country_code'=>'US',
//     // 'postal_code'=>'00000', // optional
//     'city'=>'DUBAI',
//   ]);
//   dd($data->error);

$shipment=Shipment::where('product_id',$request->product_id)->first();
$country_code=Country::where('country_name',$shipment->product->user->detail->country)->first();
 $date = Carbon::now()->format('D');
 if($date=="Fri"){
    $date_pickup= time()+ (1 * 24 * 60 * 60);
 }
 else{
     $date_pickup=time();
 }
      $current_time=time()+(4*60*60);
 
//   $time= date('h:i:s', $time);
// dd($time);
 $start=(int)43200;
 $end=(int)61200;
//  $time1= date('h:i:s', $time1);
 if($current_time>=$start && $current_time <=$end)
 {
    //  /dd("greater");
 $readytime=time();    

 }
 elseif($current_time < $start){
    //  dd('less');
     $readytime=(int)43200;
 }
 elseif($current_time > $end){
    //  dd("cureent time greater");
         $date_pickup= time()+ (1 * 24 * 60 * 60);
         $readytime=(int)43200;
 }
 
 
 
  $data = Aramex::createPickup([
    		'name' => $shipment->product->user->name,
    		'cell_phone' => $shipment->product->user->detail->phone,
    		'phone' => $shipment->product->user->detail->phone,
    		'email' => $shipment->product->user->email,
    		'city' => $shipment->product->user->detail->city,
    		'country_code' => $country_code->country_code,
            // 'zip_code'=> 99501,
    		'line1' => $shipment->product->user->detail->address,
            'line2' => $shipment->product->user->detail->country,
    // 		'line3' => 'The line2 Details',
    	     "pickup_date" =>  $date_pickup,    // time()+ (14 * 60 * 60), // time parameter describe the date of the pickup
            // "ready_time" => time()+ (15 * 60 * 60), // time parameter describe the ready pickup date
            "ready_time" =>$readytime, // time parameter describe the ready pickup date
            "last_pickup_time" => (int)61200, // time parameter
            "closing_time" => (int)61200 ,// time parameter
    
            // "closing_time" => time()+ (3 * 24 * 60 * 60) ,// time parameter
    		'status' => 'Pending', 
    		'pickup_location' => 'From Shop Reception',
    		'weight' => 1,
    		'volume' => 1
    	]);
        // extracting GUID
         if (!$data->error){
          
          $guid = $data->pickupGUID;
       }
       else{
            return response()->json(['status'=>false,'error'=>1,'data'=>$data]);
       }
      $callResponse = Aramex::createShipment([
            'shipper' => [
             'name' => $shipment->product->user->name,
    		'cell_phone' => $shipment->product->user->detail->phone,
    		'phone' => $shipment->product->user->detail->phone,
    		'email' =>  $shipment->product->user->email,
    		'city' => $shipment->product->user->detail->city,
    		'country_code' => $country_code->country_code,
            // 'zip_code'=> 99501,
    		'line1' => $shipment->product->user->detail->address,
            'line2' => $shipment->product->user->detail->country,
    		'line3' => '',
            ],
            'consignee' => [
                'name' => 'Laybull',
                'email' => 'Laybullshipping@hotmail.com',
                'phone'      => '+9710561395988',
                'cell_phone' => '+9710561395988',
                'country_code' => 'AE',
                'city' => 'DUBAI',
                // 'zip_code' => 32160,
                'line1' => 'Dar al zahya building,block B,Apartment no 101.',
                'line2' => 'DUBAI',
                // 'line3' => 'Line3 Details',
            ],
            'shipping_date_time' => time(),
            'due_date' => time() + 60000,
            'comments' => 'No Comment',
            'pickup_location' => 'At Shop Address',
            'pickup_guid' => $guid,
            'weight' => 1,
            'number_of_pieces' => 1,
            'description' => "The Condition of the ".$shipment->product->name." is ".$shipment->product->condition,
        ]);
 if (!empty($callResponse->error))
    {
        foreach ($callResponse->errors as $errorObject) {
            $data['code']=$errorObject->Code;
            $data['message']=$errorObject->Message;
             return response()->json(compact('data'),200);
            // return response().jason($errorObject->Code, $errorObject->Message);
        }
    }
    else {
          $shipmentId = $callResponse->Shipments->ProcessedShipment->ID;
         $labelUrl = $callResponse->Shipments->ProcessedShipment->ShipmentLabel->LabelURL;
        $update=Shipment::where('product_id', $request->product_id)
      ->update(['tracking_number' => $shipmentId,
      'Pickup_id'=>$guid
      ]);
      
        return response()->json(['status'=>'True','payment_link'=>$labelUrl,'Tracking Number'=>$shipmentId]);
        //  $shipmentId = $callResponse->Shipments->ProcessedShipment->ID;
        //  $labelUrl = $callResponse->Shipments->ProcessedShipment->ShipmentLabel->LabelURL;
        //  return response()->json(compact('data'),200);
        
    }
        //     $shipmentId = $anotherData->Shipments->ProcessedShipment->ID;
        //  $labelUrl = $anotherData->Shipments->ProcessedShipment->ShipmentLabel->LabelURL;
        //   return([$guid,$shipmentId, $labelUrl]);
        // print_r(json_encode($anotherData, JSON_PRETTY_PRINT));

        
    // $data = Aramex::createPickup([
    // "name" => 'Farhan Zafar', // User’s Name, Sent By or in the case of the consignee, to the Attention of.
    // "cell_phone" => '+971568041706', // Phone Number
    // "phone" => '+971568041706', // Phone Number
    // "email" => 'farhanzafar1643@gmail.com',
    // "country_code" => 'AE', // ISO 3166-1 Alpha-2 Code
    // "city" => 'DUBAI', // City Name
    // "zip_code" => 00000, // Postal Code
    // "line1" => 'dar al zahya building,block B,Apartment no 101',
    // "line2" => 'DUBAI',
    // "line3" => 'UAE',
    // "pickup_date" => time()+ (1 * 24 * 60 * 60), // time parameter describe the date of the pickup
    // "ready_time" => time()+ (1 * 24 * 60 * 60), // time parameter describe the ready pickup date
    // "last_pickup_time" => time()+ (2 * 24 * 60 * 60), // time parameter
    // "closing_time" => time()+ (3 * 24 * 60 * 60) ,// time parameter
    // "status" => 'Ready' ,// or Pending
    // "pickup_location" => 'at company', // location details
    // "weight" => 12 ,// wieght of the pickup (in KG)
    // "volume" => 80 ,// volume of the pickup  (in CM^3)
    // ]);
//  dd( $data);
        // extracting GUID
    //   if (!$data->error){
          
    //       $guid = $data->pickupGUID;
    //   }
      
//     $callResponse = Aramex::createShipment([
//         'shipper' => [
//             'name' => 'Steve',
//             'email' => 'email@users.companies',
//             'phone'      => '+123456789982',
//             'cell_phone' => '+321654987789',
//             'country_code' => 'US',
//             'city' => 'New York',
//             'zip_code' => 32160,
//             'line1' => 'Line1 Details',
//             'line2' => 'Line2 Details',
//             'line3' => 'Line3 Details',
//         ],
//         'consignee' => [
//             'name' => 'Steve',
//             'email' => 'email@users.companies',
//             'phone'      => '+123456789982',
//             'cell_phone' => '+321654987789',
//             'country_code' => 'US',
//             'city' => 'New York',
//             'zip_code' => 32160,
//             'line1' => 'Line1 Details',
//             'line2' => 'Line2 Details',
//             'line3' => 'Line3 Details',
//         ],
//         'shipping_date_time' => time() + 50000,
//         'due_date' => time() + 60000,
//         'comments' => 'No Comment',
//         'pickup_location' => 'at reception',
//         'pickup_guid' => $guid,
//         'weight' => 1,
//         'number_of_pieces' => 1,
//         'description' => 'Goods Description, like Boxes of flowers',
//     ]);
//   dd($callResponse);
//       $shipmentId = $callResponse->Shipments->ProcessedShipment->ID;
//          $labelUrl = $callResponse->Shipments->ProcessedShipment->ShipmentLabel->LabelURL;
//      return([$shipmentId, $labelUrl]);
//     if (!empty($callResponse->error))
//     {
//         foreach ($callResponse->errors as $errorObject) {
//             handleError($errorObject->Code, $errorObject->Message);
//         }
//     }
//     else {
//         // extract your data here, for example
//          $shipmentId = $callResponse->Shipments->ProcessedShipment->ID;
//          $labelUrl = $callResponse->Shipments->ProcessedShipment->ShipmentLabel->LabelURL;
//     }
//     return([$shipmentId, $labelUrl]);

}

public function order_detail($order_id)
{
    $orders=Shipment::where('id',$order_id)->first();
    return view('Order.order_detail')->with(['order'=>$orders]);
}

public function payment(Request $request)
{

$apikey = "MWQ0ZjBlMzEtMWU5MS00YWJjLWEzMzctOGIyMTc3MmQ0Mzk1OmVlODhmZTNiLTdkZjgtNDdkZS1hMTQ1LWRjMmI4M2Q0OTFhMQ==";     // enter your API key here
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api-gateway.sandbox.ngenius-payments.com/identity/auth/access-token");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "accept: application/vnd.ni-identity.v1+json",
                "authorization: Basic ".$apikey,
                "content-type: application/vnd.ni-identity.v1+json"
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,  "{\"realmName\":\"ni\"}");
            $output = json_decode(curl_exec($ch));
            $access_token = $output->access_token;
           $postData = new StdClass();
           $postData->order = new StdClass();
           
            $postData->order->action = "SALE";
             $postData->order->amount = new StdClass();
             
             $postData->order->amount->currencyCode = "AED";
             $postData->order->amount->value = $request->amount*100;
            //  $postData->emailAddress= "farhanzafar1643@gmail.com";
             $postData->payment = new StdClass();
            $postData->payment->pan=$request->card_number;
            $postData->payment->expiry=$request->expiry;
            $postData->payment->cvv=$request->cvv;
            $postData->payment->cardholderName=$request->account_name;
            $outlet = "6186e5ee-4407-4885-8808-636919548ea8";
            $token = $access_token;

            $json = json_encode($postData);
            // dd($json);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outlet."/payment/card");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer ".$token,
                "Content-Type: application/vnd.ni-payment.v2+json",
                "Accept: application/vnd.ni-payment.v2+json"));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

            $output = json_decode(curl_exec($ch));
        

            curl_close ($ch);
             $update=Product::where('id', $request->product_id)
      ->update(
          [
              'available' => "0", ]);
      
 return response()->json(['status'=>'True','payment_link'=>$output]);
       
       
       
    
}
public function dispatch($order_id)
{
$shipment=Shipment::where('id',$order_id)->first();
$buyer=Country::where('country_name',$shipment->country)->first();
// $seller_code=Country::where('country_name',$shipment->product->user->detail->country)->first();

 $date = Carbon::now()->format('D');
 if($date=="Fri"){
    $date_pickup= time()+ (1 * 24 * 60 * 60);
 }
 else{
     $date_pickup=time();
//  dd(date('y/m/d',$date_pickup));
     
 }
 $current_time=time()+(4*60*60);
 
//   $time= date('h:i:s', $time);
// dd($time);
 $start=(int)43200;
 $end=(int)61200;
//  $time1= date('h:i:s', $time1);
 if($current_time>=$start && $current_time <=$end)
 {
    //  /dd("greater");
 $readytime=time();    

 }
 elseif($current_time < $start){
    //  dd('less');
     $readytime=(int)43200;
 }
 elseif($current_time > $end){
    //  dd("cureent time greater");
         $date_pickup= time()+ (1 * 24 * 60 * 60);
         $readytime=(int)43200;
 }
 
  $data = Aramex::createPickup([
    		'name' => 'Laybull',
    		'cell_phone' => '+9710561395988',
    		'phone' => '+9710561395988',
    		'email' => 'Laybullshipping@hotmail.com',
    		'city' => 'DUBAI',
    		'country_code' => 'AE',
            // 'zip_code'=> 99501,
    		'line1' => 'Dar al zahya building,block B,Apartment no 101.',
            'line2' => 'DUBAI',
    // 		'line3' => 'The line2 Details',
    	     "pickup_date" =>  $date_pickup,    // time()+ (14 * 60 * 60), // time parameter describe the date of the pickup
            // "ready_time" => time()+ (15 * 60 * 60), // time parameter describe the ready pickup date
            "ready_time" =>$readytime, // time parameter describe the ready pickup date
            "last_pickup_time" => (int)61200, // time parameter
            "closing_time" => (int)61200 ,// time parameter
    
            // "closing_time" => time()+ (3 * 24 * 60 * 60) ,// time parameter
    		'status' => 'Pending', 
    		'pickup_location' => 'From Admin warehouse',
    		'weight' => 1,
    		'volume' => 1
    	]);
    	// extracting GUID
         if (!$data->error){
          
          $guid = $data->pickupGUID;
       }
       else{
           
            return redirect()->route('orders.index')->with('delete', 'Pickup Id Not Generated Now.');
    
            // return response()->json(['status'=>false,'error'=>1,'data'=>$data]);
       }
      $callResponse = Aramex::createShipment([
            'shipper' => [
             'name' => 'Laybull',
    		'cell_phone' => '+9710561395988',
    		'phone' => '+9710561395988',
    		'email' =>  'Laybullshipping@hotmail.com',
    		'city' => 'DUBAI',
    		'country_code' => 'AE',
            // 'zip_code'=> 99501,
    		'line1' => 'Dar al zahya building,block B,Apartment no 101.',
            'line2' => 'DUBAI',
    		'line3' => '',
            ],
            'consignee' => [
                'name' => $shipment->first_name.$shipment->last_name,
                'email' => $shipment->email,
                'phone'      => $shipment->phone,
                'cell_phone' => $shipment->phone,
                'country_code' => $buyer->country_code,
                'city' => $shipment->city,
                // 'zip_code' => 32160,
                'line1' =>  $shipment->address_1,
                'line2' => $shipment->country,
                // 'line3' => 'Line3 Details',
            ],
            'shipping_date_time' => time(),
            'due_date' => time() + 60000,
            'comments' => 'No Comment',
            'pickup_location' => 'From Admin warehouse',
            'pickup_guid' => $guid,
            'weight' => 1,
            'number_of_pieces' => 1,
            'description' => "The Condition of the ".$shipment->product->name." is ".$shipment->product->condition,
        ]);
 if (!empty($callResponse->error))
    {
        foreach ($callResponse->errors as $errorObject) {
            $data['code']=$errorObject->Code;
            $data['message']=$errorObject->Message;
         return redirect()->route('orders.index')->with('delete', 'Order Something Went Wrong');
        
            //  return response()->json(compact('data'),200);
            // return response().jason($errorObject->Code, $errorObject->Message);
        }
    }
    else {
          $shipmentId = $callResponse->Shipments->ProcessedShipment->ID;
         $labelUrl = $callResponse->Shipments->ProcessedShipment->ShipmentLabel->LabelURL;
        $update=Shipment::where('id', $order_id)
      ->update(['tracking_number1' => $shipmentId,
      'Pickup_id1'=>$guid,
      'is_confirm'=>1,
      ]);
      
        // return response()->json(['status'=>'True','URL'=>$labelUrl,'Tracking Number'=>$shipmentId]);
         return redirect()->route('orders.index')->with('delete', 'Order Dispatch To Buyer SuccessFully.');
        
    }

}
}

