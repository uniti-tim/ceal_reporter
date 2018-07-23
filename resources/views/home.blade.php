@extends('adminlte::page')

@section('title', 'CEAL Reporter')

@section('content_header')
    <h1>DPT Overview</h1>
@stop

@section('content')
      <div class="row">
        <div class="col-xs-4">

          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Sales Reps</span>
              <span class="info-box-number">{{$sales_rep_count}}</span>
            </div>
          </div>

        </div>

        <div class="col-xs-4">

          <div class="info-box bg-blue">
            <span class="info-box-icon"><i class="fa fa-address-book"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Customers</span>
              <span class="info-box-number">{{$customer_count}}</span>
            </div>
          </div>

        </div>

        <div class="col-xs-4">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-usd"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Quotes</span>
              <span class="info-box-number">{{$quote_count}}</span>
            </div>
          </div>

        </div>
      </div>


      <div class="row">
       <div class="col-md-4">
           <div class="panel panel-default">
               <div class="panel-heading"><b>Quote Progress</b></div>
               <div class="panel-body">
                    <div id='quotes_pie_loader' class="text-center" style='width:100%'>
                      <i class="fa fa-spinner fa-spin fa-5x" style="color:#d1d1d1"></i>
                    </div>
                   <canvas id="quotes_pie" class="hidden" height="280" width="600"></canvas>
               </div>
           </div>
       </div>

       <div class="col-md-8">
           <div class="panel panel-default">
               <div class="panel-heading"><b>Quote Volume</b></div>
               <div class="panel-body">
                    <div id='quotes_volume_loader' class="text-center" style='width:100%'>
                      <i class="fa fa-spinner fa-spin fa-5x" style="color:#d1d1d1"></i>
                    </div>
                   <canvas id="quotes_volume" class="hidden" height="280" width="600"></canvas>
               </div>
           </div>
       </div>
     </div>

     <div class="row">
      <div class="col-md-6">
          <div class="panel panel-default">
              <div class="panel-heading"><b>Monthly Recurring Revenue - Quoted</b></div>
              <div class="panel-body">
                   <div id='quotes_mrc_loader' class="text-center" style='width:100%'>
                     <i class="fa fa-spinner fa-spin fa-5x" style="color:#d1d1d1"></i>
                   </div>
                  <canvas id="quotes_mrc" class="hidden" height="280" width="600"></canvas>
              </div>
          </div>
      </div>
    </div>
@stop
