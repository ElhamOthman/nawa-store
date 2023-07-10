<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function __construct() {
        $this->middleware('auth:sanctum')->except('index','show');
    }
    public function index(Request $request)
    {
        $user = $request->user('sanctum');
        if(!$user->tokenCan('products.create')){
            abort(403);
        }
       return product::with('user','category','gallery')
       ->filter($request->query())
       ->paginate(2);
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads/images', 'public');
            $data['image'] = $path;
        }
        $data['user-id'] = Auth::id();
        $product = Product::create($data);
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $file->store('uploads/images', 'public'),
                ]);
            }
        }
        return $product;
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return product::with('category','user','gallery')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, product $product)
    {
        
        $user = $request->user('sanctum');
        if(!$user->tokenCan('products.update')){
            abort(403);
        }
      $data = $request ->validate([
        'name' => ['sometimes','required'],
        'category_id' => ['sometimes','required'],
        'price' => ['sometimes','required','numeric','min:0'],
        ]);
      //$product = product::findOrFail($id);
      //  $data = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads/images', 'public');
            $data['image'] = $path;
        }
        $old_image = $product->image;
        $product->update($data);

        if ($old_image && $old_image != $product->image) {
            Storage::disk('public')->delete($old_image);
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $file->store('uploads/images', 'public'),
                ]);
            }
        }
        return [
         'massege' => 'product update',
         'product' => $product
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,  product $product)
    {   
        $user = $request->user('sanctum');
        if(!$user->tokenCan('products.destroy')){
            return response([
           'message' => 'forbidden'
            ], 403);
        }
        
        $product->delete();
        return [
            'massege' => 'product deleted'
           ];
    }
}
