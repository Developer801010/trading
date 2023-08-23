<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $totalUsers = 0;
        //curretnly subscribed users
        $subscribedUsers = 0;
        //unsubscribed users
        $unsubscribedUsers = 0;



        return view('admin.home', compact(
            'totalUsers',
            'subscribedUsers',
            'unsubscribedUsers',
        ));
    }
}
