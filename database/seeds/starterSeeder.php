<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class starterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create 10 random users
        for ($i=0; $i < 9 ; $i++) { 
            DB::table('users')->insert([
                'name' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make('password'),
            ]);
        }
        
        //Create 5 categories
        $categories = ['Action', 'Fantasy','Drama','Horror','Romance'];
        foreach ($categories as $key => $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'description' => Str::random(10),
            ]);
        }
        
        //create 10 books
        
        for ($i=0; $i < 9 ; $i++) { 
            DB::table('books')->insert([
                'name' => Str::random(10),
                'author' => Str::random(10),
                'published_date' => date("Y-m-d"), 
                'category_id' => rand(1,5)
            ]);
        }
        
        
    }
}
