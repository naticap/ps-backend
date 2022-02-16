<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product = new Product();
        $limit = isset($request->limit) ? $request->limit : 15;

        if(isset($request->keyword)) {
            $product = $product->where('name', 'like', '%'.$request->keyword.'%')
                            ->orWhere('description', 'like', '%'.$request->keyword.'%')
                            ->orWhere('price', 'like', '%'.$request->keyword.'%')
                            ->orWhere('quantity', 'like', '%'.$request->keyword.'%')
                            ->paginate($limit)->withQueryString();                            
        } else {
            $product = $product->paginate($limit);
        }

        return ProductResource::make($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Product::create($request->all());

        return response("Product sucessfully created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ProductResource::make(Product::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return response("Product sucessfully updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response("Product sucessfully deleted");

    }
}
