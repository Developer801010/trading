<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {

        return view('front.account');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
