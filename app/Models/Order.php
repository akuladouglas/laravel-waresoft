<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  
  protected $table = 'orders';
  public $timestamps = false;
  
  /**
   * @var date The report start date
   * 
   */
  public $start_date;
  /**
   * @var date The report end date
   */
  public $end_date;  
  
  /**
   * @return array The fullfillment rate i.e. orders paid / orders delivered
   */
  
  public function getFullfillmentRate() {
//      $orders = self::where("")->get();
    return true;
  }
  
  
}
