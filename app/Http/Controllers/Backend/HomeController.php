<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;

class HomeController extends Controller
{
    //
    public  function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //total registered users
        $totalUsers = User::count() - 1; 
        //curretnly subscribed users
        $subscribedUsers = Subscription::whereNotNull('ends_at')->where('ends_at', '<', now())->get()->count();
        //unsubscribed users
        $unsubscribedUsers = Subscription::whereNull('ends_at')->get()->count();
        //unsubscription pending users
        $pendingUnsubscribedUsers = $totalUsers - $subscribedUsers - $unsubscribedUsers;


        return view('admin.home', compact(
            'totalUsers',
            'subscribedUsers',
            'unsubscribedUsers',
            'pendingUnsubscribedUsers'
        ));
    }
}
