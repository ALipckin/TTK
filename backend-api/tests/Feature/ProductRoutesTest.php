<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест получения всех продуктов.
     */
    public function test_can_get_all_products()
    {
        // Создаем пользователей и 5 продуктов
        $user = User::factory()->create(['role' => 'user']);
        Product::factory(5)->create(['user_id' => null]);

        Sanctum::actingAs($user, ['*']);

        $this->assertDatabaseCount('products', 5);
        // Выполнение запроса
        $response = $this->getJson('/api/products');

        // Проверка статуса ответа
        $response->assertStatus(200);

        // Проверка структуры ответа
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => [ // Здесь мы указываем, что каждый элемент в data - это массив с атрибутами продукта
                    'id',
                    'name',
                ]
            ],
            'pagination'
        ]);
        Log::info("response" . json_encode($response));
        // Получаем данные из ответа
        $data = $response->json('data');

        // Проверка количества записей в data
        $this->assertCount(5, $data); // Проверяем, что количество продуктов равно 5

    }


    /**
     * Тест получения своих продуктов.
     */
    public function test_can_get_own_products()
    {
        Sanctum::actingAs(
            User::factory()->create(['role' => 'user']),
            ['*']
        );

        $response = $this->getJson('/api/products/my');

        $response->assertStatus(200); // Успешный доступ
    }

    /**
     * Тест получения категорий продуктов.
     */
    public function test_can_get_all_categories()
    {
        Sanctum::actingAs(
            User::factory()->create(['role' => 'user']),
            ['*']
        );

        $response = $this->getJson('/api/products/all_categories');

        $response->assertStatus(200); // Успешный доступ
    }

    /**
     * Тест получения продукта по ID.
     */
    public function test_can_get_product_by_id()
    {
        $user = User::factory()->create(['role' => 'user']);
        $product = Product::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson("/api/products/{$product->id}");
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                // Здесь мы указываем, что 'data' - это массив, где каждый элемент является массивом (или объектом) с атрибутами продукта
                'name',
                'unit',
                'grm',
                'protein',
                'carbs',
                'fat',
                'water',
                'fiber',
                'dry',
                'alko',
                'sug',
                'ash',
                'rem',
                // добавьте другие поля продукта, если нужно
            ],
        ]);
        $response->assertStatus(200); // Успешный доступ, если пользователь владелец продукта
    }

    /**
     * Тест получения продукта, который не принадлежит пользователю (проверка verifyOwner).
     */
    public function test_cannot_access_other_users_product()
    {
        $user = User::factory()->create(['role' => 'user']);
        $anotherUser = User::factory()->create(['role' => 'user']);
        $product = Product::factory()->create(['user_id' => $anotherUser->id]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(403); // Доступ запрещен, так как продукт не принадлежит пользователю
    }

//    /**
//     * Тест обновления продукта.
//     */
//    public function test_can_update_own_product()
//    {
//        $user = User::factory()->create(['role' => 'user']);
//        $product = Product::factory()->create(['user_id' => null]);
//
//        Sanctum::actingAs($user, ['*']);
//
//        $response = $this->patchJson("/api/products/{$product->id}", [
//            'name' => 'Updated Product Name',
//        ]);
//
//        $response->assertStatus(200); // Успешное обновление
//    }

//    /**
//     * Тест удаления продукта.
//     */
//    public function test_can_delete_own_product()
//    {
//        $user = User::factory()->create(['role' => 'user']);
//        $product = Product::factory()->create(['user_id' => $user->id]);
//
//        Sanctum::actingAs($user, ['*']);
//
//        $response = $this->deleteJson("/api/products/{$product->id}");
//
//        $response->assertStatus(200); // Успешное удаление
//    }

    /**
     * Тест неудачной попытки обновления чужого продукта.
     */
    public function test_cannot_update_other_users_product()
    {
        $user = User::factory()->create(['role' => 'user']);
        $anotherUser = User::factory()->create(['role' => 'user']);
        $product = Product::factory()->create(['user_id' => $anotherUser->id]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->patchJson("/api/products/{$product->id}", [
            'name' => 'Updated Product Name',
        ]);

        $response->assertStatus(403); // Обновление запрещено
    }

    /**
     * Тест неудачной попытки удаления чужого продукта.
     */
    public function test_cannot_delete_other_users_product()
    {
        $user = User::factory()->create(['role' => 'user']);
        $anotherUser = User::factory()->create(['role' => 'user']);
        $product = Product::factory()->create(['user_id' => $anotherUser->id]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(403); // Удаление запрещено
    }
}
