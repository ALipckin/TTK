<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Formulation;
use App\Models\FormulationHeatTreatment;
use App\Models\FormulationInitialTreatment;
use App\Models\Header;
use App\Models\HeatTreatment;
use App\Models\InitialTreatment;
use App\Models\OrgCharacteristic;
use App\Models\Package;
use App\Models\Product;
use App\Models\QualityRequirement;
use App\Models\RealizationRequirement;
use App\Models\Tp;
use App\Models\Ttk;
use App\Models\TtkCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $faker = Faker::create();

        $ttk_number = 40;
        $product_number = 30;
        $treatment_number = 10;
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
        TtkCategory::factory(10)->create();
        Ttk::factory($ttk_number)->create();
        Category::factory(10)->create();
        Product::factory($product_number / 2)->create();
        $i = 0;
        while ($i < $product_number / 2) {
            $faker = Faker::create();
            Product::factory(1)->create([
                'name' => $faker->unique()->word,
                'protein' => random_int(0, 10) / 10,
                'carbs' => random_int(0, 10) / 10,
                'fat' => random_int(0, 10) / 10,
                'water' => random_int(0, 10) / 10,
                'fiber' => random_int(0, 10) / 10,
                'ash' => random_int(0, 10) / 10,
                'user_id' => User::inRandomOrder()->first()->id,
                'category_id' => Category::inRandomOrder()->first()->id,
            ]);
            $i++;
        }
        QualityRequirement::factory($ttk_number)->create();
        Header::factory($ttk_number)->create();
        Tp::factory($ttk_number)->create();
        RealizationRequirement::factory($ttk_number)->create();
        OrgCharacteristic::factory($ttk_number)->create();
        HeatTreatment::factory($product_number * $treatment_number)->create();
        InitialTreatment::factory($product_number * $treatment_number)->create();
        Package::factory(10)->create();
        Formulation::factory($ttk_number)->create();;
        FormulationHeatTreatment::factory($ttk_number)->create();;
        FormulationInitialTreatment::factory($ttk_number)->create();;
    }
}
