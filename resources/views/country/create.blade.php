@extends('layouts.app',['page' => __('countries'), 'pageSlug' => 'countries.create'])
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <form id="products-form" action="{{ route('countries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add Country</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            @php
                            use Octw\Aramex\Aramex;
                          
                             $data = Aramex::fetchCountries();
                           
                            @endphp
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="name">Country Name</label>
                                            
                                            <select  name="country_name" class="form-control">
                                                 @foreach($data->Countries->Country as $da)
                                                
                                                <option value='{"Name":"{{ $da->Name }}", "code": "{{ $da->Code }}"}'>{{ $da->Name }}</option>
                                                <!--<option value={{$da->Code}}{{"|"}}{{(string)$da->Name}}>{{$da->Name}}</option>-->
                                                @endforeach
                                                </select>
                                    
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-4">
                                        <label for="image">Currency Label</label>
                                        <div class="form-control" >
                                            <input type="text" id="country_sname" name="country_sname" class="form-control" placeholder="Enter the Country Short Name" required>
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="price">country shipment charges</label>
                                            <input type="text" id="country_scharges" name="country_scharges" class="form-control" placeholder="Enter the country shipment charges" required>
                                        </div>
                                    </div>
<div class="col-md-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="price">Unit Price Difference With AED</label>
                                            <input type="text" id="price_with" name="price_with" class="form-control" placeholder="Enter the Price with country" required>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('countries.index') }}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Create new Country" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection
