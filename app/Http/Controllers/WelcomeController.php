<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;

class WelcomeController extends Controller
{
    public function index(){
       $status = Status::orderBy('id','desc')->get();
       return view("public",array('status'=>$status));
    }
}
