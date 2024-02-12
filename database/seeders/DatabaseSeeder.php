<?php

namespace Database\Seeders;

 use App\Models\Category;
        
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
  
            public function run()
            {
                \App\Models\Category::factory(20)->create();
                \App\Models\User::factory(100)->create();

                // Add other factories as needed
            }
    }

