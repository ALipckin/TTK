<?php

namespace App\Http\Controllers;

use App\Models\Downloads;
use App\Models\Ttk;
use App\Models\User;
use App\Models\UsersHasProduct;

class ProfileController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $profile = User::get()->where('id', $userId)->first()->toArray();
        //my ttk
        $ttk = TTK::all()->where('user_id',);
        //my ttks num
        $ttkNum = $ttk->count();
        //downloaded ttks
        $downloadsNum = Downloads::all()->where('user_id', $userId)->count();
        //drafts
        $draftNum = $ttk->where('is_draft', 1)->count();

        //my product list
        $productNum = UsersHasProduct::all()->where('user_id', $userId)->count();

        $nums = [
            "ttk_num" => $ttkNum,
            "downloads_num" => $downloadsNum,
            "draft_num" => $draftNum,
            "product_num" => $productNum
        ];
        return response()->json([
            'status' => true,
            'message' => "Profile data",
            'data' => array_merge($profile, $nums)
        ], 200);
    }
}
