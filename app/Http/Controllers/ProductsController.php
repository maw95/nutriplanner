<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Validator;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'products.index',
            [
                'products' => Product::all()
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->admin)
            return redirect()->route('products.index')->with('error', "Restricted for admins");
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->admin)
            return redirect()->route('products.index')->with('error', "Restricted for admins");

        $request->validate([
            'name' => 'required|unique:products|max:255',
        ]);
        $product = Product::create([
            'name' => $request->input('name'),
            'details' => $request->input('details'),
            'image_path' => $request->input('image_name')
        ]);

        return redirect()->route('products.index')->with('success', "{$product->name} has been added");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->admin)
            return redirect()->route('products.index')->with('error', "Restricted for admins");

        $product = Product::find($id);
        return view('products.edit')->with('product', $product);
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
        if(!Auth::user()->admin)
            return redirect()->route('products.index')->with('error', "Restricted for admins");

        $request->validate([
            'name' => 'required|unique:products|max:255',
        ]);
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->details = $request->input('details');
        $product->image_path = $request->input('image_path');
        $product->save();

        return redirect()->route('products.index')->with('success', "{$product->name} has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if(!Auth::user()->admin)
            return redirect()->route('products.index')->with('error', "Restricted for admins");

        $product->delete();
        return redirect()->route('products.index')->with('success', "{$product->name} has been deleted");
    }

    /**
     * Upload image via ajax
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax_image(Request $request)
    {
        if(!Auth::user()->admin)
            return redirect()->route('products.index')->with('error', "Restricted for admins");

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,png,jpeg|max:5048'
        ]);
        if(!$validator->passes())
        {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()->all()
            ]);
        }

        $image_name = time() . '.' . $request->image->extension();
        $image = $request->image;
        $img = Image::make($image->path());
        $img->save(public_path('images/original/'.$image_name) );
        $img->resize(300, 300, function ($const) {
            $const->aspectRatio();
        })->save(public_path('images/thumbnail/').$image_name);

        return response()->json([
            'status' => 'success',
            'image_src' => $image_name
        ]);
    }

}
