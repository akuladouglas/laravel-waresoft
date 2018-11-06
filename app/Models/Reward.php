<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
  
  protected $table = 'rewards';
  protected $primaryKey = 'reward_id';
  public $timestamps = false;
  
  
  public static function getClaimableReward($points) {
    
    switch ($points) {
      
      case ($points >= 1000 && $points < 2500):
        $results = Reward::where("points_required", 1000)->get()->first();
        break;
      case ($points >= 2500 && $points < 5000):
        $results = Reward::where("points_required", 2500)->get()->first();
        break;
      case ($points >= 5000 && $points < 10000):
        $results = Reward::where("points_required", 1000)->get()->first();
        break;
      case ($points >= 10000):
        $results = Reward::where("points_required", 10000)->get()->first();
        break;
      default:
        break;
      
    }
    
    return $results;
    
  }
  
}
