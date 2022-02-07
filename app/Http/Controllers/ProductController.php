<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{

    public function index()
    {
        return Product::all();
    }


    public function store(Request $request)
    {
        $product = Product::create($request->only('title', 'description', 'image', 'price'));

        return response($product, 201);
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, Product $product)
    {
        $product->update($request->only('title', 'description', 'image', 'price'));

        return response($product, 201);

    }


    public function destroy(Product $product)
    {
        $product->delete();

        return response(null, 204);
    }

    public function frontend()
    {


//        if ($products = \Cache::get('products_frontend')) {
//            return $products;
//        }
//
//        sleep(2);
//        $products = Product::all();
//        \Cache::set('products_frontend', $products, 30 * 60);
        return 1;
    }

    public function backend()
    {
//        $products = Cache::remember('products_backend', 60 * 30, fn() => Product::all());
        return 1;
    }
}
