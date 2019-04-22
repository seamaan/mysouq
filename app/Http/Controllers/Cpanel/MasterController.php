<?php

namespace App\Http\Controllers\Cpanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MasterController extends Controller
{
    //
    public function index(){
        return view('cpanel.layouts.master');
    }
    public function login(){

    }
}
