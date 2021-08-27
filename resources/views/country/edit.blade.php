@extends('layouts.app',['page' => __('Edit Country'), 'pageSlug' => 'countries.edit'])
@section('content')
  @php
                            use Octw\Aramex\Aramex;
                          
                             $data = Aramex::fetchCountries();
                           
                            @endphp
                           
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <form id="products-form" action="{{ route('countries.update', $country->id) }}" method="POST" enctype="multipart/form-data" >
                @csrf
                <input name="_method" type="hidden" value="PUT">
                <input type="hidden" id="country_name"  class="form-control" value='{"Name":"{{ $country->country_name }}", "code": "{{ $country->country_code }}"}'>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Country</h3>
                                <div class="card-tools">

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="name">Country Name</label>
                                            <select  name="country_name" id="country" class="form-control">
                                                 @foreach($data->Countries->Country as $da)
                                                
                                                <option value='{"Name":"{{ $da->Name }}", "code": "{{ $da->Code }}"}'>{{ $da->Name }}</option>
                                                <!--<option value={{$da->Code}}{{"|"}}{{(string)$da->Name}}>{{$da->Name}}</option>-->
                                                @endforeach
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="price">Currency Label</label>
                                            <input type="text" id="country_sname" name="country_sname" class="form-control" value="{{$country->country_sname}}">
                                            
                                        </div>
                                    </div>

                                </div>
                                <!-- 2nd row starts here -->
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="color">Country Shipment Charges</label>
                                            <input type="text" id="country_scharges" name="country_scharges" value="{{ $country->country_scharges }}" class="form-control" placeholder="Enter a country shipment charges">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="color">Unit Price Difference with AED</label>
                                            <input type="text" id="price_with" name="price_with" value="{{ $country->price_with }}" class="form-control" placeholder="Enter a country price">
                                        </div>
                                    </div>
                                </div><!-- /.2nd row ends -->

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <a href="{{route('countries.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Update Country" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </div>
    </section>


    <!-- /.content -->


 
    
@endsection
@section('java')
<script>
        $(document).ready(function() {
            var a = $("#country_name").val();
            $("#country").val(a).attr('selected', 'selected');
        });

</script>
@endsection 

