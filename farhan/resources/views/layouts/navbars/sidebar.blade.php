@if(auth()->check())
    <div class="sidebar">
        <div class="sidebar-wrapper">
            <div class="logo">
                {{-- <img src="{{asset('assets/images/logo-AK-Booker-white.png')}}" alt='Logo' style="height: 85px; padding-left: 48px; width: 135px;"> --}}
                <h2 class="p-4 m-4">LAYBULL</h2>
            </div>
            <ul class="nav">
                <li  class="{{$pageSlug == 'dashboard' ? 'active':''}}" style="{{ $pageSlug == 'dashboard' ? 'background-color: black;' : '' }}">
                    <a href="{{ route('home') }}">
                        <i class="tim-icons icon-chart-pie-36"></i>
                        <p>{{ __('Dashboard') }}</p>
                    </a>
                </li>
                <li>
                    <a data-toggle="collapse" href="#laravel-examples" aria-expanded="true">
                        <i class="fas fa-users" ></i>
                        <span class="nav-link-text" >{{ __('Users') }}</span>
                        <b class="caret mt-1"></b>
                    </a>
                    <div class="{{ $pageSlug == 'profile' ? 'collapse.show' : '' }} {{ $pageSlug == 'users' ? 'collapse.show':''}} collapse" id="laravel-examples">
                        <ul class="nav pl-4">
                        <li class="{{ $pageSlug == 'reset' ? 'active' : ''}}" style="{{$pageSlug == 'reset' ? 'background-color:black;' : ''}}">
                                <a href="{{ route('profile.edit')  }}">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>{{ __('Reset Password') }}</p>
                                </a>
                            </li>
                            @if(auth()->user()->role == 'admin')
                                <li class="{{ $pageSlug == 'users' ? 'active' : '' }}" style="{{ $pageSlug == 'users' ? 'background-color:black;' : '' }}">
                                    <a href="{{ route('user.index')  }}">
                                        <i class="tim-icons icon-bank"></i>
                                        <p>{{ __('Vendors Management') }}</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle="collapse" href="#categories" aria-expanded="true">
                        <i class="fas fa-copyright" ></i>
                        <span class="nav-link-text" >{{ __('Categories') }}</span>
                        <b class="caret mt-1"></b>
                    </a>
                    <div class="{{ $pageSlug == 'categories' ? 'active' : ''}} {{ $pageSlug == 'categories' ? 'collapse.show' : ''}} collapse" id="categories">
                        <ul class="nav pl-4">
                            <li class="{{$pageSlug == 'categories' ? 'active':''}}" style="{{$pageSlug == 'categories' ? 'background-color:black;' : ''}}">
                                <a href="{{ route('categories.index') }}">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>{{ __('All Categories') }}</p>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle="collapse" href="#brands" aria-expanded="true">
                        <i class="fab fa-adn" ></i>
                        <span class="nav-link-text" >{{ __('Brands') }}</span>
                        <b class="caret mt-1"></b>
                    </a>
                    <div class="{{ $pageSlug == 'brands' ? 'active' : '' }} {{ $pageSlug == 'brands' ? 'collapse.show' : '' }} collapse" id="brands">
                        <ul class="nav pl-4">
                            <li class="{{$pageSlug == 'brands' ? 'active' : ''}}" style="{{$pageSlug == 'brands' ? 'background-color:black;' : ''}}">
                                <a href="{{ route('brands.index') }}">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>{{ __('Brands') }}</p>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle="collapse" href="#products" aria-expanded="true">
                        <i class="fab fa-product-hunt" ></i>
                        <span class="nav-link-text" >{{ __('Products') }}</span>
                        <b class="caret mt-1"></b>
                    </a>
                    <div class="{{ $pageSlug == 'products' ? 'active' : '' }}{{ $pageSlug == 'products' ? 'collapse.show' : '' }} collapse" id="products">
                        <ul class="nav pl-4">
                            <li class="{{ $pageSlug == 'products' ? 'active' : '' }}" style="{{ $pageSlug == 'products' ? 'background-color:black;' : ''}}">
                                <a href="{{ route('products.index') }}">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>{{ __('Products') }}</p>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
             @if(in_array("food", explode(',', auth()->user()->modules)))
                    <li>
                        <a data-toggle="collapse" href="#laravel-examples1" aria-expanded="true">
                            <i class="fab fa-laravel" ></i>
                            <span class="nav-link-text" >{{ __('FOODS') }}</span>
                            <b class="caret mt-1"></b>
                        </a>

                        <div class="{{$pageSlug == 'foodcategory' ?'collapse.show':''}}{{$pageSlug == 'foodproduct' ?'collapse.show':''}}{{$pageSlug == 'foodproductreview' ?'collapse.show':''}}{{$pageSlug == 'foodvendorreview' ?'collapse.show':''}}{{$pageSlug == 'foodreservation' ?'collapse.show':''}}collapse" id="laravel-examples1">
                            <ul class="nav pl-4">
                            <li class="{{$pageSlug =='foodcategory' ? 'active':''}}" style="{{$pageSlug == 'foodcategory'?'background-color:black;':'' }}">
                                <a href="{{ route('foodcategory.index') }}">
                                    <i class="tim-icons icon-atom"></i>
                                    <p>{{ __('Food Category') }}</p>
                                </a>
                            </li>
                        <li class="{{$pageSlug == 'foodproduct'?'active':''}}" style="{{$pageSlug == 'foodproduct'?'background-color:black;':'' }}">
                                    <a href="{{ route('food.index')  }}">
                                        <i class="tim-icons icon-bullet-list-67"></i>
                                        <p>{{ __('Food Products') }}</p>
                                    </a>
                                </li>
                                <li class="{{$pageSlug == 'foodproductreview'?'active':''}}" style="{{$pageSlug == 'foodproductreview'?'background-color:black;':'' }}">
                                    <a href="{{ route('foodProductReview')  }}">
                                        <i class="tim-icons icon-bullet-list-67"></i>
                                        <p>{{ __('Food Products Review') }}</p>
                                    </a>
                                </li><li class="{{$pageSlug == 'foodvendorreview'?'active':''}}" style="{{$pageSlug == 'foodvendorreview'?'background-color:black;':'' }}">
                                    <a href="{{ route('foodVendorReview')  }}">
                                        <i class="tim-icons icon-bullet-list-67"></i>
                                        <p>{{ __('Food Vendor Review') }}</p>
                                    </a>
                                </li>
                                @if(auth()->user()->role == 'admin' || auth()->user()->reservation)
                                    </li><li class="{{$pageSlug == 'foodreservation'?'active':''}}" style="{{$pageSlug == 'foodreservation'?'background-color:black;':'' }}">
                                        <a href="{{ route('reservation.index')}}">
                                            <i class="tim-icons icon-bullet-list-67"></i>
                                            <p>{{ __('Food Reservation') }}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if(in_array("grocery", explode(',', auth()->user()->modules)))
                    <li>
                        <a data-toggle="collapse" href="#laravel-examples2" aria-expanded="true">
                            <i class="fab fa-laravel" ></i>
                            <span class="nav-link-text" >{{ __('Grocery') }}</span>
                            <b class="caret mt-1"></b>
                        </a>

                        <div class="{{$pageSlug=='grocerycategory' ? 'collapse.show' : ' '}}{{$pageSlug=='groceryproduct' ? 'collapse.show':''}}{{$pageSlug=='groceryproductreviews' ? 'collapse.show':''}}{{$pageSlug=='groceryvendorreviews' ? 'collapse.show':''}}collapse" id="laravel-examples2">
                            <ul class="nav pl-4">
                            <li class="{{$pageSlug =='grocerycategory' ? 'active':''}}" style="{{$pageSlug == 'grocerycategory'?'background-color:black;':'' }}">
                                <a href="{{ route('grocerycategory.index') }}">
                                    <i class="tim-icons icon-atom"></i>
                                    <p>{{ __('Grocery Category') }}</p>
                                </a>
                            </li>
                            <li class="{{$pageSlug =='groceryproduct' ? 'active':''}}" style="{{$pageSlug == 'groceryproduct'?'background-color:black;':'' }}">
                                <a href="{{ route('groceryproduct.index')  }}">
                                    <i class="tim-icons icon-bullet-list-67"></i>
                                    <p>{{ __('Grocery Products') }}</p>
                                </a>
                            </li>
                            <li class="{{$pageSlug =='groceryproductreviews' ? 'active':''}}" style="{{$pageSlug == 'groceryproductreviews'?'background-color:black;':'' }}">
                                <a href="{{ route('groceryProductReview')  }}">
                                    <i class="tim-icons icon-bullet-list-67"></i>
                                    <p>{{ __('Grocery Products Reviews') }}</p>
                                </a>
                            </li>
                            <li class="{{$pageSlug =='groceryvendorreviews' ? 'active':''}}" style="{{$pageSlug == 'groceryvendorreviews'?'background-color:black;':'' }}">
                                <a href="{{ route('groceryVendorReview')  }}">
                                    <i class="tim-icons icon-bullet-list-67"></i>
                                    <p>{{ __('Grocery Vendor Reviews') }}</p>
                                </a>
                            </li>
                        </ul>
                        </div>
                    </li>
                @endif

                @if(in_array("store", explode(',', auth()->user()->modules)))
                    <li>
                        <a data-toggle="collapse" href="#laravel-examples3" aria-expanded="true">
                            <i class="fab fa-laravel" ></i>
                            <span class="nav-link-text" >{{ __('Store') }}</span>
                            <b class="caret mt-1"></b>
                        </a>

                        <div class="{{$pageSlug == 'storecategory' ? 'collapse.show':'' }}{{$pageSlug == 'storeproduct' ? 'collapse.show':'' }}{{$pageSlug == 'storeproductreviews' ? 'collapse.show':'' }}{{$pageSlug == 'storevendorreviews' ? 'collapse.show':'' }}collapse" id="laravel-examples3">
                            <ul class="nav pl-4">
                        <li class="{{$pageSlug == 'storecategory' ? 'active':'' }}" style="{{$pageSlug == 'storecategory' ? 'background-color:black':''}}">
                            <a href="{{ route('storecategory.index') }}">
                                <i class="tim-icons icon-atom"></i>
                                <p>{{ __('Store Category') }}</p>
                            </a>
                        </li>
                        <li class="{{$pageSlug == 'storeproduct' ? 'active' : ''}}" style="{{$pageSlug == 'storeproduct'? 'background-color:black':''}}">
                                    <a href="{{route('storeproduct.index')}}">
                                        <i class="tim-icons icon-bullet-list-67"></i>
                                        <p>{{ __('Store Products') }}</p>
                                    </a>
                                </li>
                                <li class="{{$pageSlug == 'storeproductreviews' ? 'active' : ''}}" style="{{$pageSlug == 'storeproductreviews'? 'background-color:black':''}}">
                                    <a href="{{route('storeProductReviews')}}">
                                        <i class="tim-icons icon-bullet-list-67"></i>
                                        <p>{{ __('Store Products Reviews') }}</p>
                                    </a>
                                </li>
                                <li class="{{$pageSlug == 'storevendorreviews' ? 'active' : ''}}" style="{{$pageSlug == 'storevendorreviews'? 'background-color:black':''}}">
                                    <a href="{{route('storeVendorReviews')}}">
                                        <i class="tim-icons icon-bullet-list-67"></i>
                                        <p>{{ __('Store Vendor Reviews') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if(in_array("hotel", explode(',', auth()->user()->modules)))
                    <li>
                        <a data-toggle="collapse" href="#laravel-examples4  " aria-expanded="true">
                            <i class="fab fa-laravel" ></i>
                            <span class="nav-link-text" >{{ __('Hotel') }}</span>
                            <b class="caret mt-1"></b>
                        </a>

                        <div class="{{$pageSlug == 'hotel' ? 'collapse.show':''}}{{$pageSlug == 'hotelreview' ? 'collapse.show':''}}collapse" id="laravel-examples4">
                            <ul class="nav pl-4">
                        <li class="{{$pageSlug == 'hotel' ? 'active' : '' }}" style="{{$pageSlug=='hotel' ? 'background-color:black':'' }}">
                            <a href="{{ route('hotel.index') }}">
                                <i class="tim-icons icon-atom"></i>
                                <p>{{ __('Hotel List') }}</p>
                            </a>
                        </li>
                        <li class="{{$pageSlug == 'hotelreview' ? 'active' : '' }}" style="{{$pageSlug=='hotelreview' ? 'background-color:black':'' }}">
                                    <a href="{{route('review')}}">
                                        <i class="tim-icons icon-bullet-list-67"></i>
                                        <p>{{ __('Hotel Reviews') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if(in_array("car", explode(',', auth()->user()->modules)))
                    <li>
                        <a data-toggle="collapse" href="#laravel-examples5  " aria-expanded="true">
                            <i class="fab fa-laravel" ></i>
                            <span class="nav-link-text" >{{ __('Cars') }}</span>
                            <b class="caret mt-1"></b>
                        </a>

                        <div class="{{$pageSlug == 'showroom' ? 'collapse.show' : ''}}{{$pageSlug == 'showroomreview' ? 'collapse.show' : ''}}{{$pageSlug == 'carlist'?'collapse.show':''}}{{$pageSlug == 'carreviews'?'collapse.show':''}}collapse" id="laravel-examples5">
                            <ul class="nav pl-4">
                                <li class="{{$pageSlug == 'showroom' ? 'active':'' }}" style="{{$pageSlug=='showroom'?'background-color:black':''}}">
                                    <a href="{{ route('showroom.index') }}">
                                        <i class="tim-icons icon-atom"></i>
                                        <p>{{ __('Showroom List') }}</p>
                                    </a>
                                </li>
                                <li class="{{$pageSlug == 'showroomreview' ? 'active':'' }}" style="{{$pageSlug=='showroomreview'?'background-color:black':''}}">
                                    <a href="{{ route('showroomreview') }}">
                                        <i class="tim-icons icon-atom"></i>
                                        <p>{{ __('Showroom Reviews') }}</p>
                                    </a>
                                </li>
                                <li class="{{$pageSlug == 'carlist' ? 'active':'' }}" style="{{$pageSlug=='carlist'?'background-color:black':''}}">
                                    <a href="{{route('cars.index')}}">
                                        <i class="tim-icons icon-bullet-list-67"></i>
                                        <p>{{ __('Cars List') }}</p>
                                    </a>
                                </li>
                                <li class="{{$pageSlug == 'carreviews' ? 'active':'' }}" style="{{$pageSlug=='carreviews'?'background-color:black':''}}">
                                    <a href="{{ route('carreview') }}">
                                        <i class="tim-icons icon-atom"></i>
                                        <p>{{ __('Cars Reviews') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

{{--                <li>--}}
{{--                    <a data-toggle="collapse" href="#laravel-examples6" aria-expanded="true">--}}
{{--                        <i class="fab fa-laravel" ></i>--}}
{{--                        <span class="nav-link-text" >{{ __('All Bookings') }}</span>--}}
{{--                        <b class="caret mt-1"></b>--}}
{{--                    </a>--}}
{{--                    <div class="{{$pageSlug=='foodbooking'?'collapse.show':''}}{{$pageSlug=='grocerybooking'?'collapse.show':''}}{{$pageSlug=='storebooking'?'collapse.show':''}}collapse" id="laravel-examples6">--}}
{{--                        <ul class="nav pl-4">--}}
{{--                            @if(in_array("food", explode(',', auth()->user()->modules)))--}}
{{--                                <li class="{{$pageSlug == 'foodbooking'}} ? 'active':' '" style="{{$pageSlug == 'foodbooking'?'background-color:black':''}}" >--}}
{{--                                    <a href="{{ route('foodbooking.index') }}">--}}
{{--                                        <i class="tim-icons icon-atom"></i>--}}
{{--                                        <p>{{ __('Food Booking Details') }}</p>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endif--}}
{{--                            @if(in_array("grocery", explode(',', auth()->user()->modules)))--}}
{{--                                <li class="{{$pageSlug == 'grocerybooking' ? 'active':''}}" style="{{$pageSlug == 'grocerybooking'? 'background-color:black':''}}">--}}
{{--                                    <a href="{{route('grocerybooking.index')}}">--}}
{{--                                        <i class="tim-icons icon-bullet-list-67"></i>--}}
{{--                                        <p>{{ __('Grocery Booking Details') }}</p>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endif--}}
{{--                            @if(in_array("store", explode(',', auth()->user()->modules)))--}}
{{--                            <li class="{{$pageSlug == 'storebooking' ? 'active':''}}" style="{{$pageSlug == 'storebooking'? 'background-color:black':''}}">--}}
{{--                                    <a href="{{route('storebooking.index')}}">--}}
{{--                                        <i class="tim-icons icon-bullet-list-67"></i>--}}
{{--                                        <p>{{ __('store Booking Details') }}</p>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endif--}}
{{--                            <!-- @if(in_array("hotel", explode(',', auth()->user()->modules)))--}}
{{--                                <li @if ($pageSlug ?? '' == 'hotelreview') class="active " @endif>--}}
{{--                                    <a href="{{route('review')}}">--}}
{{--                                        <i class="tim-icons icon-bullet-list-67"></i>--}}
{{--                                        <p>{{ __('hotel Booking Details') }}</p>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endif--}}
{{--                            @if(in_array("car", explode(',', auth()->user()->modules)))--}}
{{--                                <li @if ($pageSlug ?? '' == 'hotelreview') class="active " @endif>--}}
{{--                                    <a href="{{route('review')}}">--}}
{{--                                        <i class="tim-icons icon-bullet-list-67"></i>--}}
{{--                                        <p>{{ __('cars Booking Details') }}</p>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endif -->--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>
@endif
