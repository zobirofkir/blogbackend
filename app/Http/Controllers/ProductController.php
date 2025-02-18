<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : AnonymousResourceCollection
    {
        return ProductResource::collection(
            Product::all()
        );
    }

    /**
     * Create Authentication Product
     */
    public function auth() : AnonymousResourceCollection
    {
        return ProductResource::collection(
            Product::where('user_id', Auth::id())->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request) : ProductResource
    { 
        $requestValifated = $request->validated();

        if (isset($requestValifated['title'])) {
            $requestValifated['slug'] = Str::slug($requestValifated['title']);
        }

        return ProductResource::make(
            Product::create(array_merge(
                $requestValifated,
                ['user_id' => Auth::id()]
            ))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) : ProductResource
    {
        return ProductResource::make($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        try {
            // Find the product by ID
            $product = Product::findOrFail($id);
    
            // Update the product
            $product->update(array_merge(
                $request->validated(),
                ['user_id' => Auth::id()]
            ));
    
            return ProductResource::make($product->refresh());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case where the product is not found
            return response()->json([
                'error' => 'Product not found.'
            ], 404);
        } catch (\Exception $e) {
            // Handle any other errors
            return response()->json([
                'error' => 'An error occurred while updating the product.'
            ], 500);
        }
    }
                
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) : bool
    {
        return $product->delete();
    }
}
