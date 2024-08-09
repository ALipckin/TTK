<?php

namespace App\Http\Controllers;

use App\Http\Filters\ProductFilter;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Models\Ttk;
use App\Models\User;
use App\Models\UsersHasProduct;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
   public function index(){
       $profile = User::get()->where('id', auth()->user()->id)->first();
       //my ttk
       $ttk = TTK::all()->where('user_id', auth()->user()->id);
       //my ttks num
       $ttkNum = $ttk->count();
       //downloaded ttks

       //drafts
       $draftNum = $ttk->where('is_draft', 1)->count();

       //my product list
       $productNum = UsersHasProduct::all()->where('user_id', auth()->user()->id)->count();

       $nums = [
           "ttk_num" => $ttkNum,
           "downloads_num" => 0,
           "draft_num" => $draftNum,
           "product_num" => $productNum
       ];
       return response()->json([
           'status' => true,
           'message' => "Profile data",
           'data' => $profile
       ], 200);
   }
}
