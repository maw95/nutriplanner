@extends('layouts.app', [
    'namePage' => 'Products',
    'class' => 'sidebar-mini',
    'activePage' => 'products',
])

@section('content')
    <div class="panel-header d-flex p-4 justify-content-between">
        <h1 class="text-white d-flex align-items-center m-0">{{__('Edit')}} {{$product->name}}</h1>
        <div class="d-flex align-items-end">
            <a class="btn btn-primary btn-lg btn-round text-white align-items-center d-flex" href="{{ route('products.create') }}">
                <i class="fa fa-arrow-left mr-2 big-icon"></i> {{__('Back to list')}}
            </a>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-12 flex-wrap mb-4">
                <form method="post" enctype="multipart/form-data" action="{{ route('products.update',[$product->id]) }}">
                    <div class="card">
                        <div class="card-body">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">{{__('Name')}}</label>
                                <input type="text" class="form-control" name="name" value="{{ $product->name }}" required/>
                            </div>
                            <div class="form-group">
                                <label for="details">{{__('Details')}}</label>
                                <input type="text" class="form-control" name="details" value="{{ $product->details }}"/>
                            </div>
                            <div class="form-group">
                                <label for="image">{{__('Image')}}</label>
                                <br>
                                @if(isset($product->image_path))
                                    <img src="{{ asset('images/'. $product->image_path) }}" id="product-id" class="shadow-lg img-fluid img-thumbnail">
                                @endif
                                <br>
                                <span class="btn btn-raised btn-round btn-default btn-file">
                                            <span class="fileinput-new">{{__('Select image')}}</span>
                                            <input type="file" class="form-control-file" name="image" accept="image/png, image/jpeg, image/jpg" value="{{ $product->image_path }}"/>
                                        </span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-round ">{{__('Submit')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
