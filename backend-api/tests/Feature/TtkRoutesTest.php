<?php


use App\Models\TtkCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ttk;
use Laravel\Sanctum\Sanctum;

class TtkRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

    }

    /**
     * Тест получения всех категорий TTK.
     */
    public function test_can_get_all_categories()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/ttks/all_categories');

        $response->assertStatus(200); // Успешный доступ
    }

    /**
     * Тест получения своих TTK-записей.
     */
    public function test_can_get_own_ttks()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/ttks/my');

        $response->assertStatus(200); // Успешный доступ
    }

    /**
     * Тест получения всех TTK-записей.
     */
    public function test_can_get_all_ttks()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/ttks');

        $response->assertStatus(200); // Успешный доступ
    }

    /**
     * Тест получения чужой публичной TTK-записи.
     */
    public function test_can_access_public_ttk()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);
        $anotherUser = User::factory()->create();
        $publicTtk = Ttk::factory()->create([
            'user_id' => $anotherUser->id,
            'public' => 1, // Публичная запись
        ]);
        Log::info("public ttk" . json_encode($publicTtk));
        $response = $this->getJson("/api/ttks/{$publicTtk->id}");
        Log::info("response" . json_encode($response));
        $response->assertStatus(200); // Успешный доступ к публичной записи
    }

    /**
     * Тест получения чужой приватной TTK-записи.
     */
    public function test_cannot_access_private_ttk()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);
        $anotherUser = User::factory()->create();
        $privateTtk = Ttk::factory()->create([
            'user_id' => $anotherUser->id,
            'public' => 0, // Приватная запись
        ]);

        $response = $this->getJson("/api/ttks/{$privateTtk->id}");

        $response->assertStatus(403); // Доступ запрещен к приватной записи
    }

    /**
     * Тест создания TTK-записи.
     */
    public function test_can_create_ttk()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/ttks', [
            'name' => 'Селедка под шубой',
            'public' => '1',
            'isDraft' => '1',
            'category_id' => TtkCategory::factory()->create()->id,
        ]);

        $response->assertStatus(201); // Успешное создание
    }

    /**
     * Тест обновления своей TTK-записи.
     */
    public function test_can_update_own_ttk()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);
        $ttk = Ttk::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson("/api/ttks/{$ttk->id}", [
            'name' => 'Updated Title',
        ]);

        $response->assertStatus(200); // Успешное обновление
    }

    /**
     * Тест публикации своей TTK-записи.
     */
    public function test_can_publish_own_ttk()
    {        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);

        $ttk = Ttk::factory()->create([
            'user_id' => $user->id,
            'public' => 0, // Приватная запись
        ]);

        $response = $this->patchJson("/api/ttks/{$ttk->id}/publish", [
            'public' => 1,
        ]);

        $response->assertStatus(200); // Успешная публикация
        $this->assertDatabaseHas('ttks', [
            'id' => $ttk->id,
            'public' => 1,
        ]);
    }

    /**
     * Тест удаления своей TTK-записи.
     */
    public function test_can_delete_own_ttk()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);
        $ttk = Ttk::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->deleteJson("/api/ttks/{$ttk->id}");

        $response->assertStatus(200); // Успешное удаление
    }

    /**
     * Тест попытки обновления чужой TTK-записи.
     */
    public function test_cannot_update_other_users_ttk()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);
        $anotherUser = User::factory()->create();
        $ttk = Ttk::factory()->create([
            'user_id' => $anotherUser->id,
        ]);

        $response = $this->patchJson("/api/ttks/{$ttk->id}", [
            'title' => 'Updated Title',
        ]);

        $response->assertStatus(403); // Доступ запрещен
    }

    /**
     * Тест попытки удаления чужой TTK-записи.
     */
    public function test_cannot_delete_other_users_ttk()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);
        $anotherUser = User::factory()->create();
        $ttk = Ttk::factory()->create([
            'user_id' => $anotherUser->id,
        ]);

        $response = $this->deleteJson("/api/ttks/{$ttk->id}");

        $response->assertStatus(403); // Доступ запрещен
    }
}
