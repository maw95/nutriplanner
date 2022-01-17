<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'name' => 'required|unique:products|max:255',
            'image' => 'mimes:jpg,png,jpeg|max:5048'
        ]);

        $product = Product::find($id);
        if(!is_null($request->image))
        {
            $image_path = time().'-'.$request->name . '.'.$request->image->extension();
            $request->image->move(public_path('images'), $image_path);
            $product->image_path = $image_path;
        }

        if(!is_null($request->input('details')))
            $product->details = $request->details;

        $product->name = $request->input('name');

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
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg|max:5048'
        ]);
        $image_name = time() . '.' . $request->image->extension();
        $image = $request->image;
        $img = Image::make($image->path());
        $img->resize(300, 300, function ($const) {
            $const->aspectRatio();
        })->save(public_path('images/thumbnail/').'/'.$image_name);

        $img->move(public_path('images/original/'), $image_name);


        return response()->json([
            'status' => 'success',
            'image_name' => $image_name,
            'public_path' => public_path('images')
        ]);
    }

}
