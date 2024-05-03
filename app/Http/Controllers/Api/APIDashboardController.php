<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Cashier\Subscription;

class APIDashboardController extends Controller
{
    public function home()
    {
         //total registered users
         $totalUsers = User::count() - 1; 
         //curretnly subscribed users
         $subscribedUsers = Subscription::whereNull('ends_at')->get()->count();
         //unsubscribed users
         $unsubscribedUsers = Subscription::whereNotNull('ends_at')->where('ends_at', '<', now())->get()->count();
         //unsubscription pending users
         $pendingUnsubscribedUsers = $totalUsers - $subscribedUsers - $unsubscribedUsers;

         $data = [
            'totalUsers' => $totalUsers,
            'subscribedUsers' => $subscribedUsers,
            'unsubscribedUsers' => $unsubscribedUsers,
            'pendingUnsubscribedUsers' => $pendingUnsubscribedUsers
         ];

         return response()->json([
            'status' => true,
            'message' => 'Get Message Data Successfully',
            'data' => $data,
        ], 200);  
    }
}
