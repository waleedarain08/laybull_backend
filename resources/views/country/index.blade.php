@extends('layouts.app',['page' => __('Country List'), 'pageSlug' => 'countries'])
@section('content')
    <section class="content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Country</h3>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('countries.create') }}" class="nav-link pull-right">
                                <button class="btn btn-primary form-control text-capitalize">Add Country</button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0" style="padding:5px !important;">
                    @include('alert2.message')
                    <table class="table table-striped projects data-table" style="">
                        <thead>
                        <tr>
                            @foreach($display as $disp)
                                <th class="{{ $disp == 'Action' ? 'text-center' : '' }}">
                                    {{$disp}}
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($records as $key=>$record)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td style="width: 18.6%">{{$record->country_name}}</td>
                                <td>{{ $record->country_sname }}</td>
                                <td>{{ $record->country_scharges }}</td>
                                <td>{{ $record->price_with }}</td>
                                <td>

                                    <a class="btn btn-info btn-sm float-left mr-1" href="countries/{{ $record->id }}/edit">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </a>
                                    <form method="post" action="{{ route('countries.destroy',$record->id)  }}" class="">
                                        {{ csrf_field() }}
                                        {{ method_field("DELETE") }}
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt">
                                            </i></button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-center w-100">{{$records->links()}}</div>

            </div>
    </section>
@endsection


@section('script')
@endsection
