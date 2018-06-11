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
@stop
