<?php

namespace App\Http\Controllers\Api;

use App\Bid;
use App\Brand;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

class BidController extends Controller
{

    public function saveBid(Request $request)
    {
        $user_id = auth('api')->user()->id;
        $seller_id = $request->seller_id;
        $product_id = $request->product_id;
        $price = $request->price;
        $counter = $request->counter_offer;
        $status = 'pending';

        $id = Bid::firstOrCreate([
            'user_id' => $user_id,
            'seller_id' => $seller_id,
            'product_id' => $product_id,
            'price' => $price,
            'status' => $status,
            'counter_offer' => $counter,
        ])->user_id;

        $product = Bid::where('user_id',$user_id)->where('status','pending')->get()->pluck('product_id');

        $products = array();
        $i = 0;
        $pro = Product::whereIn('id',$product)->get();

        foreach ($pro as $prod) {

            $prodBrand = Brand::where('id', '=', $prod->brand)->first();

            $products[$i] = $prod;
            $prod->color = $prod->color()->pluck('colour')->implode('colour');
            $prod->size = $prod->size()->pluck('size')->implode('size');
            $prod->image = $prod->image()->pluck('image');

            if ($prodBrand == null) {
                $products[$i]['brand'] = "No Brand";
            } else {
                $products[$i]['brand'] = $prodBrand->name;
            }
            $i++;
        }

        $pro = $products;
        foreach($pro as $offer){
            $offer->bidPrice = Bid::where('user_id',auth('api')->user()->id)->where('status','pending')->where('product_id',$offer->id)->first()->price;
        }

        return response()->json(['success' => true, 'message' => 'Bid Successful','products'=> $pro]);
    }

    public function receivedOffers()
    {
        $seller_id = auth('api')->user()->id;

        $offers = Bid::where('seller_id',$seller_id)->where('status','pending')->get()->pluck('product_id');


        $products = array();
        $i = 0;
        $pro = Product::whereIn('id',$offers)->get();

        foreach ($pro as $prod) {

            $prodBrand = Brand::where('id', '=', $prod->brand)->first();

            $products[$i] = $prod;
            $prod->color = $prod->color()->pluck('colour')->implode('colour');
            $prod->size = $prod->size()->pluck('size')->implode('size');
            $prod->image = $prod->image()->pluck('image');

            if ($prodBrand == null) {
                $products[$i]['brand'] = "No Brand";
            } else {
                $products[$i]['brand'] = $prodBrand->name;
            }


            $i++;

        }
        $offers = $products;
        foreach($offers as $offer){
            $offer->bidPrice = Bid::where('seller_id',auth('api')->user()->id)->where('status','pending')->where('product_id',$offer->id)->first()->price;
        }


        return $offers;
    }

    public function payment(Request $request)
    {
         $validator =  $request->validate([
             'amount' => 'required|numeric',
             'email' => 'required|email',
         ]);

        try{
            $amount = ($request->amount) * 100;
            $email = $request->email;

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

//        Create Order

        $postData = new StdClass();
        $postData->action = "SALE";
        $postData->amount = new StdClass();
        $postData->amount->currencyCode = "AED";
        $postData->amount->value = $amount;
        $postData->emailAddress= $email;

        $outlet = "6186e5ee-4407-4885-8808-636919548ea8";
        $token = $access_token;

        $json = json_encode($postData);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outlet."/orders");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer ".$token,
            "Content-Type: application/vnd.ni-payment.v2+json",
            "Accept: application/vnd.ni-payment.v2+json"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        $output = json_decode(curl_exec($ch));
        $order_reference = $output->reference;
        $order_paypage_url = $output->_links->payment->href;

        curl_close ($ch);

        return response()->json(['success'=>true,'payment_link'=>$order_paypage_url]);
        }
        catch (\Exception $e){
            return response()->json(['success'=>false,'error',$e->getMessage()]);
        }
    }
}
