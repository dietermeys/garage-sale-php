<?php

namespace App\Http\Controllers;

use App\Category;
use App\Image;
use App\Product;
use App\User;
use DB;
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
        $categories = Category::all();
        /** @var Builder $queryBuilder */
        $queryBuilder = Product::withDistance()->with("seller", "category");

        $this->buildSearchQuery($request, $queryBuilder);

        $products = $queryBuilder->simplePaginate(10);
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display a listing of all favorited Products
     *
     * @return \Illuminate\Http\Response
     */
    public function favorites(Request $request)
    {
        $categories = Category::all();
        $queryBuilder = Product::withDistance()
            ->with('seller', 'category')
            ->join('favorites', 'favorites.product_id', '=', 'products.id')
            ->where('favorites.user_id', '=', auth()->user()->id);

        $this->buildSearchQuery($request, $queryBuilder);

        $products = $queryBuilder->simplePaginate(10);
        return view('products.index', compact('products', 'categories'));
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
        $product->delete();
        return redirect()->to('/products');
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

    /**
     * @param Request $request
     * @param $queryBuilder
     */
    public function buildSearchQuery(Request $request, $queryBuilder)
    {
        if ($request->has('search')) {
            $queryBuilder->where(function ($query) use ($request) {
                $query->where(
                    'title', 'like', '%' . $request->get('search') . '%'
                );
                $query->orWhere(
                    'summary', 'like', '%' . $request->get('search') . '%'
                );
            });
        }
        if ($request->has('price_start')) {
            $queryBuilder->where(
                'price', '>=', $request->get('price_start')
            );
        }
        if ($request->has('price_end')) {
            $queryBuilder->where(
                'price', '<=', $request->get('price_end')
            );
        }
        if ($request->has('category_id')) {
            $queryBuilder->where(
                'category_id', '=', $request->get('category_id')
            );
        }
        if ($request->has('distance')) {
            $queryBuilder->having(
                'distance', '<=', $request->get('distance')
            );
        }
    }
}
