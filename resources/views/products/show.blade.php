@extends('layouts.app', [
    'namePage' => 'Products',
    'class' => 'sidebar-mini',
    'activePage' => 'products',
])

@section('content')
    <div class="panel-header d-flex p-4 justify-content-between">
        <h1 class="text-white d-flex align-items-center m-0">{{__('Edit')}} {{$product->name}}</h1>
        <div class="d-flex align-items-end">
            @if(!is_null(Auth::user()) and Auth::user()->admin)
            <a class="btn btn-primary btn-lg btn-round text-white align-items-center d-flex mr-5" href="{{ route('products.edit',[$product->id]) }}">
                <i class="fa fa-pencil-alt mr-2 big-icon"></i> {{__('Edit product')}}
            </a>
            @endif
            <a class="btn btn-primary btn-lg btn-round text-white align-items-center d-flex" href="{{ route('products.index') }}">
                <i class="fa fa-arrow-left mr-2 big-icon"></i> {{__('Back to list')}}
            </a>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-12 flex-wrap mb-4">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-lg-8 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="name">{{__('Name')}}</label>
                                <h2>{{ $product->name }}</h2>
                            </div>
                            <div class="form-group">
                                <label for="details">{{__('Details')}}</label>
                                <p>{{ $product->details }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group float-right">
                                <label for="image">{{__('Image')}}</label>
                                <br>
                                @if(isset($product->image_path))
                                    <img class="image-preview img-thumbnail img-fluid shadow-lg" src="{{ asset('images/thumbnail/'. $product->image_path) }}"/>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

