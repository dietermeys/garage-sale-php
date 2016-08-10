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
        DB::table('products')->insert([
            'user_id' => '1',
            'title' => 'Eerste product',
            'summary' => 'Eerste product dat te koop staat enzo!',
            'price' => '10',
            'category_id' => '2',
            'file_name' => 'product1.png',
        ]);
        DB::table('products')->insert([
            'user_id' => '1',
            'title' => 'Tweede product',
            'summary' => 'Tweede product dat te koop staat enzo!',
            'price' => '13',
            'category_id' => '1',
            'file_name' => 'product2.png',
        ]);
        DB::table('products')->insert([
            'user_id' => '1',
            'title' => 'Derde product',
            'summary' => 'Derde product dat te koop staat enzo!',
            'price' => '15',
            'category_id' => '3',
            'file_name' => 'product3.png',
        ]);
    }
}
