<?php


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProfileRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function test_user_can_access_profile_index()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);
        // Аутентифицируем пользователя
        $response = $this->getJson('/api/profile');

        // Ожидаем, что ответ будет успешным (200 OK)
        $response->assertStatus(200);
    }

    #[Test]
    public function test_user_can_access_own_profile()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);

        $response = $this->actingAs($user)->get('/api/profile/my');

        $response->assertStatus(200);
        // Можно добавить проверку содержимого ответа
    }

    #[Test]
    public function test_user_can_view_other_user_profile()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);

        // Создаем другого пользователя
        $anotherUser = User::factory()->create();

        $response = $this->actingAs($user)->get("/api/profile/{$anotherUser->id}");

        $response->assertStatus(200);
        // Проверяем, что в ответе содержится информация о другом пользователе
        $response->assertJsonFragment([
            'id' => $anotherUser->id,
        ]);
    }

    #[Test]
    public function test_user_can_upload_avatar()
    {
        // Создаем пользователя с ролью "user"
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);

        Log::info('GD is available: ' . function_exists('gd_info'));
        // Мокаем загруженный файл
        $file = \Illuminate\Http\UploadedFile::fake()->image('image.png');

        $response = $this->actingAs($user)->post('/api/profile/upload-avatar', [
            'image' => $file,
        ]);

        $response->assertStatus(200);
        // Можно проверить JSON-ответ, если ожидается подтверждение загрузки
    }
}
