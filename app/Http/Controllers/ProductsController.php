<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\UploadedFile;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with("seller", "category")->paginate(10);
        return view('products.index', compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\ProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\ProductStoreRequest $request)
    {
        $user = \Auth::user();
        $product = new Product($request->all());
        $user->productsForSale()->save($product);

        //http://stackoverflow.com/a/36834321
        $files = $request->file('images');
        foreach ($files as $file) {
            /* @var UploadedFile $file */
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture = date('His') . $product->id . $filename;
            $destinationPath = base_path() . '/public/images/products';
            $file->move($destinationPath, $picture);
            $product->photos()->create([
                'filename' => $picture
            ]);
        }

        return redirect()->route('products.show', [
            'id' => $product->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('seller', 'category', 'photos')->find($id);
        $product->distance;
        return view('products.detail', compact("product"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::with('seller', 'category', 'photos')->find($id);
        return view('products.edit', compact("product", "categories"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* @var Product $product */
        $product = Product::find($id);
        if($request->hasFile('images')) {
            //http://stackoverflow.com/a/36834321
            $files = $request->file('images');
            foreach ($files as $file) {
                /* @var UploadedFile $file */
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $picture = date('His') . $product->id . $filename;
                $destinationPath = base_path() . '/public/images/products';
                $file->move($destinationPath, $picture);
                $product->photos()->create([
                    'filename' => $picture
                ]);
            }
        }

        $product->update($request->all());

        return redirect()->route('products.show', [
            'id' => $product->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
