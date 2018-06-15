<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Session;
use Redirect;

use App\Quote;

class QuotesController extends Controller
{
    public static function progressPieChart(){
      return Quote::getQuotesDispositions();
    }

    public static function volumeChart(){
      return Quote::getQuoteVolume();
    }

    public static function mrcChart(){
      return Quote::getAllQuoteMRC();
    }
}
