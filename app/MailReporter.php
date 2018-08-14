<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Mail;

use App\Customer;
use App\Quote;
use App\Sales_Rep;

class MailReporter extends Model
{
    public static function makeMonthlyReport() {
      $date = Carbon::now()->startofMonth();

      $data_overall = [
        "Active Sales Reps" => Sales_Rep::get()->count(),
        "Accounts" => Customer::get()->count(),
        "Quotes (All)" => Quote::get()->count(),
        "Completed Quotes" => Quote::where('status',true)->get()->count(),
      ];

      $data_monthly = [
        "Accounts Created This Month" => Customer::where('created_at','>',$date)->get()->count(),
        "Quotes Created This Month" => Quote::where('created_at','>',$date)->get()->count(),
        "Completed Quotes This Month" => Quote::where('status',true)->where('created_at','>',$date)->get()->count(),
        "MRR of Quoted" => Quote::getThisMonthQuoteMRC(),
      ];
      self::sendMonthlyReport($data_overall, $data_monthly);
    }

    private static function sendMonthlyReport($data_overall, $data_monthly) {
      $addresses = [
        'timothy.carambat@uniti.com',
      ];

      Mail::send('emails.sendMonthlyReport',
      ['data_overall' => $data_overall, 'data_monthly' => $data_monthly],
      function ($message) use ($addresses)
        {
            $message->subject("CEAL Reporter Summary - ".Carbon::now()->format('F Y'));
            $message->from('cealreporter@uniti.com', 'CEAL Reporter');
            $message->to($addresses);
        });
    }
}
