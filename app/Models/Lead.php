<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
  protected $table = 'leads';
  protected $primaryKey = 'lead_id';
  public $timestamps = false;
  
}
