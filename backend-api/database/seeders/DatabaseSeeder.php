<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Formulation;
use App\Models\Header;
use App\Models\heat_treatment;
use App\Models\initial_processing;
use App\Models\Org_characteristic;
use App\Models\Product;
use App\Models\Requirement;
use App\Models\Tp;
use App\Models\Ttk;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $ttk_number = 0;
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => hash::make('password'),
        ]);
        TTK::factory($ttk_number)->create();
        Category::factory(10)->create();
        Product::factory(20)->create();
        Requirement::factory($ttk_number)->create();
        Header::factory($ttk_number)->create();
        Tp::factory($ttk_number)->create();
        Org_characteristic::factory($ttk_number)->create();
        heat_treatment::factory($ttk_number)->create();
        initial_processing::factory($ttk_number)->create();
        Formulation::factory($ttk_number*5)->create();
    }
}
