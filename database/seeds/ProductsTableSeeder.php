<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::all();
        $categories = \App\Category::all();
        factory(App\Product::class, 50)->make()->each(function(\App\Product $product) use ($users, $categories){
            $user = $users->random();
            $category = $categories->random();
            $product->seller()->associate($user);
            $product->category()->associate($category);
            $product->save();
        });
    }
}
