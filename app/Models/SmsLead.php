<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLead extends Model
{
  protected $table = 'smsleads';
  protected $primaryKey = 'smslead_id';
  public $timestamps = false;
  
}
