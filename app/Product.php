<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $connection='pgsql_dpt';
  protected $table='products';
}
