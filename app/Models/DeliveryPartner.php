<?php

namespace App\Models;

/**
 * DeliveryPartner
 *
 * @author epic-code
 */
use Illuminate\Database\Eloquent\Model;

class DeliveryPartner extends Model
{ 
  protected $table = 'delivery_partners';
  protected $primaryKey = 'delivery_partner_id';
  public $timestamps = false;
  
  
}
