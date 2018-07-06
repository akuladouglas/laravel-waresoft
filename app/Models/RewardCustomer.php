<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardCustomer extends Model
{
  
  protected $table = 'rewards_customers';
  protected $primaryKey = 'rewards_customer_id';
  public $timestamps = false;
  
}
