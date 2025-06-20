<?php

namespace App\Http\Controllers\admin;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\product;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

       public function __construct()
    {
        $this->allproduct = product::all();
    }  
    public function index()
    {
     return view('admin.product.index',['product'=>$this->allproduct]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
  public function store(StoreProductRequest $request)
{
   $validatedData = $request->validated();

    $product = new product();
    $product->product_name = $validatedData['product_name'];
    $product->description = $validatedData['description'];
    $product->url = $validatedData['url'];

     if ($request->hasFile('image')) {
        $file = $request->file('image');
        $path = 'uploads/customers/product/';
        $ext = $file->getClientOriginalExtension();
        $file_name = time() . '.' . $ext;
        $file->move(public_path($path), $file_name);
        $product->image = $path . $file_name;
    }
      $product->save();

    return redirect()->route('product.index')->with('success', 'Alert created successfully.');
}
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = product::findOrFail($id);
        return view('admin.product.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


public function update(UpdateProductRequest $request, $id)
{
    $validatedData = $request->validated();

    $product = Product::findOrFail($id);
    $product->product_name = $validatedData['product_name'];
    $product->description = $validatedData['description'];
    $product->url = $validatedData['url'];
    if ($request->hasFile('image')) {
        if (File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }
        $file = $request->file('image');
        $path = 'uploads/customers/product/';
        $ext = $file->getClientOriginalExtension();
        $file_name = time() . '.' . $ext;
        $file->move(public_path($path), $file_name);
        $product->image = $path . $file_name;
    }
    $product->save();
    return redirect()->route('product.index')->with('success', 'updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
   {
        $product = product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'product deleted successfully.');
    }
}
