@extends('layouts.app', [
    'namePage' => 'Products',
    'class' => 'sidebar-mini',
    'activePage' => 'products',
])

@section('content')
    <div class="panel-header d-flex p-4 justify-content-between">
        <h1 class="text-white d-flex align-items-center m-0">{{__('Add new product')}}</h1>
        <div class="d-flex align-items-end">
            <a class="btn btn-primary btn-lg btn-round text-white align-items-center d-flex" href="{{ route('products.index') }}">
                <i class="fa fa-arrow-left mr-2 big-icon"></i> {{__('Back to list')}}
            </a>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-12 flex-wrap mb-4">
                    <div class="card">
                            <div class="card-body">
                                <form id="product-form" method="post" action="{{ route('products.store') }}">
                                @csrf
                                    <div class="form-group">
                                        <label for="name">{{__('Name')}}</label>
                                        <input type="text" class="form-control" name="name" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="details">{{__('Details')}}</label>
                                        <input type="text" class="form-control" name="details"/>
                                    </div>
                                </form>
                                <div class="form-group">
                                    <label for="image">{{__('Image')}}</label>
                                    <br>
                                        <form id="ajax_image" method="post" action="{{route('products_ajax_image')}}" enctype="multipart/form-data" method="post">
                                            @csrf
                                            <span class="btn btn-raised btn-round btn-default btn-file">
                                                <span class="fileinput-new">{{__('Select image')}}</span>
                                                <input type="file" class="with-preview form-control-file" name="image" for="image_name" accept="image/png, image/jpeg, image/jpg"/>
                                            </span>
                                            <input type="hidden" form="product-form" name="image_name"/>
                                            <br>
                                            <img class="image-preview img-thumbnail img-fluid hidden shadow-lg" src=""/>
                                            <div class="image-preview-error transition-03 transform-origin-center hidden alert alert-danger">
                                                <span>
                                                    {{__('Image couldn\'t be uploaded.')}}
                                                </span>
                                                <span class="d-block hidden transition-03 transform-origin-center image-preview-error-info">
                                                </span>
                                            </div>
                                        </form>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" form="product-form" class="btn btn-primary btn-round ">{{__('Submit')}}</button>
                            </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
