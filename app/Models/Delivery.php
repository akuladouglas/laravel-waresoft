<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
  protected $table = 'deliveries';
  protected $primaryKey = 'delivery_id';
  public $timestamps = false;  
  
  
}
