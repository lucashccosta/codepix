<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function store()
    {
        dd(Auth::user());
    }
}
