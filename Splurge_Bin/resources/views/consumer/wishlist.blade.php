@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="bg-white rounded">
            <div class="card">
                <div class="card-body mainbody mt-4">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex justify-content-between">
                            <input class="form-control mr-sm-2" id = "searchBar" type="search" placeholder="Search" aria-label="Search" style = "width:15rem; margin-right : 5rem">
                            <select id="categories" class="form-select" style = "width:15rem">
                                <option selected value = '-1'>All</option>
                                @foreach($categories as $category)
                                    <option value = {{$category -> id}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <a href="{{route('home')}}" class = "btn btn-outline-secondary">
                            <i class="bi bi-house"></i>
                            Home
                        </a>
                    </div>
                    <div class="container mt-5 mb-5">
                        <div class="d-flex justify-content-center row">
                            <div class="col-md-10">
                                @if($products->count != 0)
                                    @foreach($products as $product)
                                        @if($product -> wishList != null)
                                        <div class="row p-2 bg-white border rounded items cat-{{$product -> category_id}} mt-2">
                                            <div class="col-md-3 mt-1">
                                                @php
                                                    $images = explode("->seperator<-", $product ->image);
                                                @endphp
                                                <img class="card-img-top object-fit-cover border rounded" style = "height : 15rem; width : 100%" src="{{asset('/storage/seller_uploads/'.$product -> seller -> id.'/'.$product -> id.'/'.$images[0])}}" alt="{{$product -> name}}">
                                            </div>
                                            <div class="col-md-6 mt-1">
                                                <h5>{{$product -> name}}</h5>
                                                <div class="d-flex flex-row">
                                                    <div class="text-warning mb-1 me-2">
                                                        @if($product -> rating != 0)
                                                            @for($i = $product->rating; $i >= 1; $i--)
                                                              <i class="bi bi-star-fill"></i>
                                                            @endfor
                                                            @if(fmod($product->rating, 1) !== 0.00)
                                                                <i class="bi bi-star-half"></i>
                                                            @endif
                                                            @for($i = 5 - $product->rating; $i >= 1; $i--)
                                                                <i class="bi bi-star"></i>
                                                            @endfor
                                                        @endif
                                                      <span class="ms-1 text-primary">
                                                        @if($product->rating != 0)
                                                            {{$product -> rating}} ({{count($product -> reviews)}})
                                                        @else
                                                            No reviews yet
                                                        @endif
                                                      </span>
                                                    </div>
                                                </div>
                                                <div class="mt-1 mb-1 spec-1">{{$product -> info}}</div>
                                                <div class="mt-1 mb-1 spec-1"><h5 class = "sellerName">Sold By : {{$product -> seller -> name}}</h5></div>
                                            </div>
                                            <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                                                <div class="d-flex flex-row align-items-center">
                                                    <h4 class="mr-1 productPrice">{{$product -> priceString}}</h4>
                                                </div>
                                                <div class="d-flex flex-column mt-4">
                                                    <a href = "{{route('products.consumer.view', $product -> id)}}" class="btn btn-primary btn-sm">
                                                        Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="text-center">
                                        <img src="{{asset('assets/img/no_data.jpg')}}" alt="No data found" style="height : 15rem; width : 50%; object-fit: contain">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        $(document).ready(function(){

            // Search
            // Search bar written with the help of ChatGPT

            $('#searchBar').on('input', function(){
                filterContent();
            });

            $("#categories").change(function(){
                filterContent();
            });

            function filterContent(){
                var searchTerm = $('#searchBar').val().toLowerCase();
                var value = $('#categories').val();
                var targetClass = "cat-" + value;
                $('.items').each(function(){
                    var className = $(this).attr("class");
                    var cardText = $(this).text().toLowerCase();
                    if((value == -1 && cardText.indexOf(searchTerm) != -1) || (className.includes(targetClass) && cardText.indexOf(searchTerm) != -1)){
                        $(this).show();
                    } else{
                        $(this).hide();
                    }
                });
            }
        });
    </script>
@endpush
