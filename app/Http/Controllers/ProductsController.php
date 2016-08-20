<?php

namespace App\Http\Controllers;

use App\Category;
use App\Image;
use App\Product;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /** @var Builder $queryBuilder */
        $queryBuilder = Product::with("seller", "category");

        if ($request->has('search')) {
            $queryBuilder->where(
                'title', 'like', '%' . $request->get('search') . '%'
            );
            $queryBuilder->orWhere(
                'summary', 'like', '%' . $request->get('search') . '%'
            );
        }

        $products = $queryBuilder->paginate(10);
        return view('products.index', compact("products"));
    }

    /**
     * Display a listing of all favorited Products
     *
     * @return \Illuminate\Http\Response
     */
    public function favorites()
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = auth()->user()->favorites()->with('product')->paginate(10);

        // Extract Products from Favorite collection
        $products = $paginator->map(function($favorite) {
            return $favorite->product;
        });

        // Fill paginator with Products instead of Favorites
        $paginator->setCollection($products);

        return view('products.index', [
            'products' => $paginator
        ]);
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

        if ($request->hasFile('images'))
            $this->storePhotos($request->file('images'), $product);

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

        if($request->hasFile('images'))
            $this->storePhotos($request->file('images'), $product);

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
        /* @var Product $product */
        $product = Product::find($id);
        $user = \Auth::user();

        if ($product->seller->id !== $user->id) {
            return redirect()->back()->withErrors(
                'You do not have sufficient rights to delete this product.'
            );
        }

        return redirect()->to('/');
    }

    /**
     * Delete a product image (ajax)
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($id)
    {
        /** @var Image $image */
        $image = Image::with('product.seller')->findOrFail($id);
        $user = auth()->user();

        if ($image->product->seller->id !== $user->id) {
            return redirect()->back()->withErrors(
                'You do not have sufficient rights to delete this product.'
            );
        }

        if (!$image->delete()) {
            return response()->json([
                'error' => 'Could not delete image'
            ]);
        }

        return response()->json([
            'response' => 'ok'
        ]);
    }

    /**
     * Favor/Unfavor a product (ajax)
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function toggleFavorite($id)
    {
        /** @var User $user */
        $user = auth()->user();
        $product = Product::findOrFail($id);
        $isFavorited = $user->toggleFavorited($product);

        return response()->json([
           'response' => [
               'favorited' => $isFavorited
           ]
        ]);
    }

    /**
     * Store uploaded product image(s) on disk and db
     *
     * @param UploadedFile[] $files
     * @param Product $product
     */
    protected function storePhotos($files, $product)
    {
        if (!is_array($files))
            $files = [$files];

        $urls = [];

        foreach ($files as $file) {
            $fileName = date('His') . $product->id . $file->hashName();

            // Save on disk
            $file->move(
                config('storage.images.products'),
                $fileName
            );

            $urls[] = [
                'filename' => $fileName
            ];
        }

        // Save in db
        $product->photos()->createMany($urls);
    }
}
