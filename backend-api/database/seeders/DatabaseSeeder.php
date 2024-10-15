<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Formulation;
use App\Models\FormulationHeatTreatment;
use App\Models\FormulationInitialTreatment;
use App\Models\Header;
use App\Models\Treatment;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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

        $insertQueries = base_path('database/sql/insertTtkCategories.sql');
        // Проверяем, существует ли файл
        if (File::exists($insertQueries)) {
            // Читаем содержимое файла
            $sql = File::get($insertQueries);
            // Выполняем SQL-запросы
            DB::unprepared($sql); // Если в SQL содержатся несколько команд, используйте unprepared
        }

        Ttk::factory($ttk_number)->create();

        $insertProducts = base_path('database/sql/insertProducts.sql');
        // Проверяем, существует ли файл
        if (File::exists($insertProducts)) {
            // Читаем содержимое файла
            $sql = File::get($insertProducts);
            // Выполняем SQL-запросы
            DB::unprepared($sql); // Если в SQL содержатся несколько команд, используйте unprepared
        }

        QualityRequirement::factory($ttk_number)->create();
        Header::factory($ttk_number)->create();
        Tp::factory($ttk_number)->create();
        RealizationRequirement::factory($ttk_number)->create();
        OrgCharacteristic::factory($ttk_number)->create();
        Formulation::factory($ttk_number)->create();;
    }
}
