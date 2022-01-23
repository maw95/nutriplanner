@extends('layouts.app', [
    'namePage' => 'Products',
    'class' => 'sidebar-mini',
    'activePage' => 'products',
])

@section('content')
    <div class="panel-header d-flex p-4 justify-content-between">
        <h1 class="text-white d-flex align-items-center m-0">{{__('Products')}}</h1>
        <div class="d-flex align-items-end">
            <a class="btn btn-primary btn-lg btn-round text-white align-items-center d-flex" href="{{ route('products.create') }}">
                <i class="fa fa-plus mr-2 big-icon"></i> {{__('Add new product')}}
            </a>
        </div>
    </div>
    <div class="content">
        @include('alerts.success')
        @include('alerts.errors')
        <div class="row">
                @foreach($products as $product)
                <div class="col-md-3 col-sm-6 col-12 flex-wrap text-center mb-4">
                    <div class="card">
                        <a href="{{ route('products.show',[$product->id]) }}">
                            <div class="card-header bg-primary align-content-center p-2">
                                <h2 class="text-white m-0 justify-content-center align-content-center">
                                    {{$product->name}}
                                </h2>
                            </div>
                            <div class="card-body">
                                @if(isset($product->image_path))
                                    <img src="{{ asset('images/thumbnail/'. $product->image_path) }}" class="shadow-lg img-fluid img-thumbnail">
                                @endif
                                <p>{{$product->details}}</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
