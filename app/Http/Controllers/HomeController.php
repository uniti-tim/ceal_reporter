<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Sales_Rep;
use App\Customer;
use App\Quote;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function welcome(){
        Redirect::to('/login')->send();
    }

    public function index(){

        return view('home',[
          'page'=>'home',
          'sales_rep_count' => Sales_Rep::get()->count(),
          'customer_count' => Customer::get()->count(),
          'quote_count' => Quote::get()->count(),
        ]);
    }
}
