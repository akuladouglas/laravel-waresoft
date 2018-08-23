<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
  
  protected $table = 'riders';
  protected $primaryKey = 'rider_id';
  public $timestamps = false;
  
}
