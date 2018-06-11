<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
  protected $connection='pgsql_dpt';
  protected $table='documents';
}
