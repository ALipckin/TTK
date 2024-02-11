<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Header;
use App\Models\Org_characteristic;
use App\Models\Product;
use App\Models\Requirement;
use App\Models\Tp;
use App\Models\Ttk;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $ttk_number = 4;
        User::factory(5)->create();
        TTK::factory($ttk_number)->create();
        Category::factory(10)->create();
        Product::factory(20)->create();
        Requirement::factory($ttk_number)->create();
        Header::factory($ttk_number)->create();
        Tp::factory($ttk_number)->create();
        Org_characteristic::factory($ttk_number)->create();

    }
}
