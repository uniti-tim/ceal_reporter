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
      $quotes = Quote::get();
      $results =[
        'labels' => ['Complete','In Progress'],
        'data' => [],
        'backgroundColor' => ['#00a65a','#f39c12'],
      ];
      $complete = 0;
      $in_progress = 0;

      foreach($quotes as $quote){
        if(!empty($quote->sales_force_parent_opportunity_id)){
          $complete++;
        }else{
          $in_progress++;
        }
      }
      $results['data'] = [$complete,$in_progress];

      return json_encode($results);
    }

    public static function volumeChart(){
      $quotes = Quote::orderBy('created_at','ASC')->get();
      $results =[
        'label' => 'Quotes Created',
        'data' => [],
        'borderColor'=> "rgb(75, 192, 192)",
        'fill'=> false,
      ];
      $dates = [];
      $data = [];

      //collect and get all unique days of quotes created
      foreach($quotes as $quote){
        array_push($dates, date('m/d/Y',strtotime($quote->created_at)) );
      }
      $results['data'] = array_count_values($dates);

      return json_encode($results);
    }
}
