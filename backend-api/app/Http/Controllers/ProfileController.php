<?php

namespace App\Http\Controllers;

use App\Models\Downloads;
use App\Models\Ttk;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => "users data",
            'data' => User::all()->get()
        ], 200);
    }

    public function my()
    {
        $userId = auth()->user()->id;
        $profile = User::get()->where('id', $userId)->first()->toArray();
        //my ttk
        $ttk = TTK::all()->where('user_id', $userId);
        //my ttks num
        $ttkNum = $ttk->count();
        //downloaded ttks
        $downloadsNum = Downloads::all()->where('user_id', $userId)->count();
        //drafts
        $draftNum = $ttk->where('is_draft', 1)->count();
        //my product list
        $productNum = UserProduct::all()->where('user_id', $userId)->count();
        //TODO views system
        $views = 0;
        //TODO rating system
        $ratingNum = 0;
        $nums = [
            "ttk_num" => $ttkNum,
            "downloads_num" => $downloadsNum,
            "draft_num" => $draftNum,
            "product_num" => $productNum,
            "rating" => $ratingNum,
            "views" => $views,
        ];
        return response()->json([
            'status' => true,
            'message' => "Profile data",
            'data' => array_merge($profile, $nums)
        ], 200);
    }

    public function uploadAvatar(Request $request)
    {
        // Валидация входящего файла
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',  // Ограничение на тип и размер файла
        ]);
        $user = Auth::user();

        // Получаем файл из запроса
        $file = $request->file('image');

        // Генерируем уникальное имя для файла
        $filename = $user->id . '.' . $file->getClientOriginalExtension();

        $file->storeAs('public/img/avatars/', $filename);

        // Обновляем путь к изображению в профиле пользователя
        $user->avatar = '/storage/img/avatars/' . $filename;
        $user->save();

        return response()->json([
            'message' => 'Фото профиля успешно загружено',
            'profile_picture_url' => asset('storage/img/avatars/' . $filename),
        ], 200);
    }

    public function show(User $user)
    {
        $profile = $user->get(['id', 'name', 'avatar', 'last_visit'])->toArray();
        $userId = $user->id;
        //my ttk
        $ttk = TTK::all()->where('user_id', $userId)->where('public', 1);
        //my ttks num
        $ttkNum = $ttk->count();
        //downloaded ttks
        $downloadsNum = Downloads::all()->where('user_id', $userId)->count();
        //drafts
        //TODO views system
        $views = 0;
        //TODO rating system
        $ratingNum = 0;
        $nums = [
            "ttk_num" => $ttkNum,
            "downloads_num" => $downloadsNum,
            "rating" => $ratingNum,
            "views" => $views,
        ];
        return response()->json([
            'status' => true,
            'message' => "Profile data",
            'data' => array_merge($profile, $nums)
        ], 200);
    }
}
