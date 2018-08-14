<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Quote extends Model
{
  protected $connection='pgsql_dpt';
  protected $table='documents';
  protected $dateFormat = 'Y-m-d H:i:s.u';

  public static function getQuotesDispositions(){
    $quotes = Quote::get();
    $results =[
      'labels' => ['Complete','In Progress'],
      'data' => [],
      'backgroundColor' => ['#00a65a','#f39c12'],
    ];
    $complete = 0;
    $in_progress = 0;

    foreach($quotes as $quote){
      if(!empty($quote->status)){
        $complete++;
      }else{
        $in_progress++;
      }
    }
    $results['data'] = [$complete,$in_progress];

    return json_encode($results);
  }

  public static function getQuoteVolume(){
    $quotes = Quote::orderBy('created_at','ASC')->get();
    $results =[
      ['label' => 'Quotes Created',
      'data' => [],
      'borderColor'=> "rgb(75, 192, 192)",
      'fill'=> false,
      ],
      ['label' => 'Quotes Completed',
      'data' => [],
      'backgroundColor' => "rgb(243, 156, 18)",
      'borderColor' => "rgb(194, 125, 14)",
      'borderWidth' => '2',
      'fill'=> false,]
    ];
    $dates_all = [];
    $dates_completed = [];

    $data_all = [];
    $data_completed = [];

    //collect and get all unique days of quotes created
    foreach($quotes as $quote){
      array_push($dates_all, date('m/d/Y',strtotime($quote->created_at)) );

      //if quote complete...
      if($quote->status){
        array_push($dates_completed, date('m/d/Y',strtotime($quote->updated_at)) );
      }
    }



    $results[0]['data'] = array_count_values($dates_all);
      $data_completed = array_count_values($dates_completed);
      uksort( $data_completed, 'self::sortByDate');
    $results[1]['data'] = $data_completed;

    return json_encode($results);
  }

  public static function getAllQuoteMRC(){
    $quotes = Quote::orderBy('created_at','ASC')->get();
    $results =[
      'labels' => [],
      'data' => [],
      'backgroundColor'=> ["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],
      'borderColor' => ["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"],
      'fill'=> true,
    ];
    $dates = [];
    $data = [];

    //collect and get all unique days of quotes created
    foreach($quotes as $quote){
      $date = date('m/01/Y',strtotime($quote->created_at));

      if($quote->status){
        $mrr = 0;
        $quote_data = json_decode($quote->data);
        $products = $quote_data->products;
        $bandwidths = $quote_data->bandwidths;

        if( count($products) > 0){
          $mrr += Quote::getBasicTotal($products, 'products');
        }

        if( count($bandwidths) > 0){
          $mrr += Quote::getBasicTotal($bandwidths, 'bandwidths');
        }

        $totalMRR = number_format( $mrr ,2);
      }else{
        $totalMRR = 0;
      }

      // if date exists by key in array already then add commision to existing value
      if( array_key_exists( $date, $data)  ){
        $data[$date] += floatval(preg_replace('/[^\d.]/', '', $totalMRR));
      }else{
        array_push($results['labels'], date("F Y", strtotime($date)) );
        $data[$date] = floatval(preg_replace('/[^\d.]/', '', $totalMRR));
      }

    }

    $results['data'] = $data;
    return json_encode($results);
  }

  public static function getThisMonthQuoteMRC(){
    $quotes = Quote::where('created_at','>',Carbon::now()->startofMonth())
              ->orderBy('created_at','ASC')
              ->get();
    $dates = [];
    $data = [];

    //collect and get all unique days of quotes created
    foreach($quotes as $quote){
      $date = date('m/01/Y',strtotime($quote->created_at));

      if($quote->status){
        $mrr = 0;
        $quote_data = json_decode($quote->data);
        $products = $quote_data->products;
        $bandwidths = $quote_data->bandwidths;

        if( count($products) > 0){
          $mrr += Quote::getBasicTotal($products, 'products');
        }

        if( count($bandwidths) > 0){
          $mrr += Quote::getBasicTotal($bandwidths, 'bandwidths');
        }

        $totalMRR = number_format( $mrr ,2);
      }else{
        $totalMRR = 0;
      }

      // if date exists by key in array already then add commision to existing value
      if( array_key_exists( $date, $data)  ){
        $data[$date] += floatval(preg_replace('/[^\d.]/', '', $totalMRR));
      }else{
        $data[$date] = floatval(preg_replace('/[^\d.]/', '', $totalMRR));
      }

    }

    return $data[array_keys($data)[0]];
  }



  private static function getBasicTotal($item_list, $type){
    $total = 0;
    foreach( $item_list as $item){
      if($type === 'products'){
          $total += $item->sales_price * $item->quantity;
      }elseif ($type === 'bandwidths') {
          $total += $item->sales_price;
      }
    }
    return $total;
  }

  private static function sortByDate($a, $b){
    return strtotime($a) - strtotime($b);
  }


}
