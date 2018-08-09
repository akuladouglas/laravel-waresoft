<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

/**
 * Description of RewardCoupon
 *
 * @author epic-code
 */
use Illuminate\Database\Eloquent\Model;

class RewardCoupon extends Model {
  
  protected $table = "reward_coupon";
  protected $primaryKey = 'reward_coupon_id';
  public $timestamps = false;
  
}
