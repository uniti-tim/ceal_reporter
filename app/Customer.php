<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $connection='pgsql_dpt';
  protected $table='customers';
}
