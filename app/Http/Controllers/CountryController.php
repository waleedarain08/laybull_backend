<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use DataTables;
class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new Country();
        $records = $model->latest()->paginate(config('app.pagination_length'));
        $display= array('#', 'Country Name', 'Currency Label', 'Shipment Charges', 'Unit Price Difference With AED', 'Action');
        return view('country.index')
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
        $user = auth()->user();
        return view('country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $myObjects = json_decode($request->country_name);
       
        $country = new Country;
        $country->country_name = $myObjects->Name;
        $country->country_sname = $request->country_sname;
        $country->country_scharges = $request->country_scharges;
        $country->price_with = $request->price_with;
        $country->country_code = $myObjects->code;
        $country->save();
        return redirect()->route('countries.index')->with('update', 'Country Updated SuccessFully..');

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
        $country = Country::where('id',$id)->first();
        return view('country.edit')->with('country',$country);
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
           $myObjects = json_decode($request->country_name);
        $country = Country::findOrFail($id);
         $country->country_name = $myObjects->Name;
        $country->country_sname = $request->country_sname;
        $country->country_scharges = $request->country_scharges;
        $country->price_with = $request->price_with;
          $country->country_code = $myObjects->code;
        $country->save();
        return redirect()->route('countries.index')->with('update', 'Country Updated SuccessFully..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::find($id);
        $country->delete();

        return redirect()->route('countries.index')->with('delete', 'Country Deleted SuccessFully..');

    }
    public function list_of_sold_countries(Request $request)
    {
        $data['country']=Country::all();
        return response()->json(compact('data'),200);

    }
}
