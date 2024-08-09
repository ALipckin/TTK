<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Formulation;
use App\Models\Header;
use App\Models\HeatTreatment;
use App\Models\InitialProcessing;
use App\Models\OrgCharacteristic;
use App\Models\Product;
use App\Models\Requirement;
use App\Models\Tp;
use App\Models\Ttk;
use App\Models\User;
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

        $ttk_number = 5;
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => hash::make('password'),
            'role' => 'admin'
        ]);
        User::factory()->create([
            'name' => 'User',
            'email' => '123@example.com',
            'password' => hash::make('123'),
            'role' => 'user'
        ]);
        Ttk::factory($ttk_number)->create();
        Category::factory(10)->create();
        Product::factory(20)->create();
        Requirement::factory($ttk_number)->create();
        Header::factory($ttk_number)->create();
        Tp::factory($ttk_number)->create();
        OrgCharacteristic::factory($ttk_number)->create();
        HeatTreatment::factory($ttk_number)->create();
        InitialProcessing::factory($ttk_number)->create();
        Formulation::factory($ttk_number * 5)->create();
    }
}
