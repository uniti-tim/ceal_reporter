<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bandwidth extends Model
{
    protected $connection='pgsql_dpt';
    protected $table='bandwidths';
}
