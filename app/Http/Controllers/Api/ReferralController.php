<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 use App\Models\Referral;
 use App\Models\User;

class ReferralController extends Controller
{
   public function referralSummary()
{


    $user = Auth::user();
   //$user=User::find(1);


    $referrals = Referral::where('referrer_id', $user->id)->get();


    $totalReferrals = $referrals->count();


    $totalCoins = $referrals->sum('coins_rewarded');

    return response()->json([
        'status' => true,
        'message' => 'Referral details fetched successfully',
      //  'data' => [
           // 'user' => $user->only(['id', 'name', 'email']),
            'total_referrals' => $totalReferrals ?: 0,
            'total_coins' => $totalCoins ?: 0,
           // 'referrals' => $referrals,
            'coin_quantity'=> 1,
            'coin_price'=> 1,

       // ]
    ]);
}
}
