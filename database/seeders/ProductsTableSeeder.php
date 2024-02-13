<?php

// database/seeders/ProductsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        // Create 10 users
        $users = User::factory(20)->create();

        // For each user, create 5 products associated with that user
        $users->each(function ($user) {
            Product::factory(50)->create(['user_id' => $user->id]);
        });
    }
}



