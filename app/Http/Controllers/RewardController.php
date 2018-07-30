<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RewardCustomer;
use App\Models\RewardActivity;
use App\Models\RewardSms;
use App\Models\Customer;
use App\Models\Reward;
use DB;

class RewardController extends Controller
{
    public $link = "https://f79e3def682b671af1591e83c38ce094:c46734f74bad05ed2a7d9a621ce9cf7b@beautyclickke.myshopify.com/admin/orders.json";
  
    public $api_base_link = "https://first.collectapps.io/api/v1";
    private $authetication = "Apikey 495993e27b695496030f6394c7200ae4";
    private $headers = array("Authorization: Apikey 495993e27b695496030f6394c7200ae4");
  
  
    public function get_data($url, $headers)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
  
  
    public function syncCustomers()
    {
    
    //https://first.collectapps.io/api/v1/customers?PageNumber=page_number&PageSize=page_size&CreatedAfter=created_after&CreatedBefore=created_before
    
      
       /* logic to get new customer */
      
        $last_reward_customer = RewardCustomer::orderBy("rewards_customer_id", "desc")->get()->take(1)->first();
    
        $created_after = $last_reward_customer->createdAt;
        $created_before = "";
    
        $link = "https://first.collectapps.io/api/v1/customers?PageNumber=1&PageSize=100&CreatedAfter=$created_after&CreatedBefore=$created_before";
    
        $response = $this->get_data($link, $this->headers);
    
        $decoded = json_decode($response);
        
        /*logic to get updated current customers */
    
        foreach ($decoded->Customers as $key => $customer) {
            $reward_customer = new RewardCustomer();
            $reward_customer->customerId = $customer->CustomerId;
            $reward_customer->accountId = $customer->AccountId;
            $reward_customer->createdAt = $customer->CreatedAt;
            $reward_customer->updatedAt = $customer->UpdatedAt;
            $reward_customer->totalSpent = $customer->TotalSpent;
            $reward_customer->totalOrders = $customer->TotalOrders;
            $reward_customer->avgSpentPerOrder = $customer->AvgSpentPerOrder;
            $reward_customer->lastVisited = $customer->LastVisited;
            $reward_customer->pointsBalance = $customer->PointsBalance;
            $reward_customer->tags = "";
            $reward_customer->emailAddress = $customer->EmailAddress;
            $reward_customer->firstName = $customer->FirstName;
            $reward_customer->lastName = $customer->LastName;
            $reward_customer->birthDate = $customer->BirthDate;
            $reward_customer->gender = $customer->Gender;
      
            $reward_customer->Save();
        }
    }
  
    public function syncActivitys()
    {
        $customer_data = RewardCustomer::where("pointsBalance", ">=", 0)->where("activity_synced", 0)->get()->take(80);
        
        //reset all customers if they are all synced
        if(!count($customer_data)){
          DB::table('rewards_customers')->update(['activity_synced' => 0]);
        }
        
        foreach ($customer_data as $key => $customer) {
          
            $link = "https://first.collectapps.io/api/v1/activities?CustomerId=$customer->customerId";
      
            $activity_data = $this->get_data($link, $this->headers);
            
            $decoded_results = json_decode($activity_data);
            
            foreach ($decoded_results->Activities as $key => $activity) {
                
                $activity_obj = RewardActivity::where("id",$activity->Id)->get()->first();
                
                if(!$activity_obj){
                 $activity_obj = new RewardActivity();
                }
                
                $activity_obj->id = $activity->Id;
                $activity_obj->accountId = $activity->AccountId;
                $activity_obj->customerId = $activity->CustomerId;
                $activity_obj->createdAt = $activity->CreatedAt;
                $activity_obj->actionedAt = $activity->ActionedAt;
                $activity_obj->type = $activity->Type;
                $activity_obj->description = $activity->Description;
                $activity_obj->orderId = $activity->OrderId;
                $activity_obj->orderSourceId = $activity->OrderSourceId;
                $activity_obj->apiOrderId = $activity->ApiOrderId;
                $activity_obj->rewardId = $activity->RewardId;
                $activity_obj->title = $activity->Title;
                $activity_obj->points = $activity->Points;
                $activity_obj->couponId = $activity->CouponId;
          
                $activity_obj->save();
        
            }
            
            //update customer as synced anyway
            $customer->activity_synced = 1;
            $customer->last_sync_time = date("Y-m-d h:m:s");
            $customer->save();
            
        }
    }
  
    public function computePointsBalance($points)
    {
        switch ($points) {
      
      case ($points > 0 && $points < 1000):
        $results = [
          "next_price" => "Kshs 1,000 Off",
          "points_balance_due" => number_format(1000 - $points)
        ];
        break;
      
      case ($points >= 1000 && $points < 2500):
        $results = [
          "next_price" => "Kshs 2,500 Off",
          "points_balance_due" => number_format(2500 - $points)
        ];
        break;
      
      case ($points >= 2500 && $points < 5000):
        $results = [
          "next_price" => "Kshs 5,000 Off",
          "points_balance_due" => number_format(5000 - $points)
        ];
        break;
      
      case ($points >= 5000 && $points < 10000):
        $results = [
          "next_price" => "Kshs 10,000 Off",
          "points_balance_due" => number_format(10000 - $points)
        ];
        break;
      
      default:
        $results = [
          "next_price" => "Kshs 1,000 Off",
          "points_balance_due" => number_format(1000 - $points)
        ];
        break;
    }
   
        return $results;
    }
  
    public function queuePointsBalanceSms()
    {
        $activities = RewardActivity::join("rewards_customers", "rewards_customers.customerId", "rewards_activitys.customerId")->where("points", ">=", 1)->where("sms_queued", 0)->get()->take(10);
     
        foreach ($activities as $key => $activity) {
            $this->createSms($activity->rewards_activity_id);
      
            $activity_obj = RewardActivity::where("rewards_activity_id", $activity->rewards_activity_id)->get()->first();
            $activity_obj->sms_queued = 1;
            $activity_obj->save();
        }
    }
  
  
    public function createSms($activity_id)
    {
        $activity_obj = RewardActivity::join("rewards_customers", "rewards_customers.customerId", "rewards_activitys.customerId")->where("rewards_activity_id", $activity_id)->get()->first();
    
        $shopify_customer_obj = Customer::where("email", trim($activity_obj->emailAddress))->get()->first();
    
        $customer_total_points = number_format(RewardActivity::where("customerId", $activity_obj->customerId)->sum("points"));
    
        $points_results = $this->computePointsBalance($activity_obj->points);
    
        $customer_points = number_format($activity_obj->points);
    
        if ($shopify_customer_obj && !empty($shopify_customer_obj->phone)) {
      
//      $message = "Hi $shopify_customer_obj->first_name, thank you for shoping at BeautyClick. You have $customer_points points. Shop more to earn {$points_results["points_balance_due"]} points for a guaranteed {$points_results["next_price"]}";

            $message = "Thank you for shoping at BeautyClick. You just earned $customer_points points. Your points balance is $customer_total_points." ;

            $sms_obj = new RewardSms;
            $sms_obj->text = $message;
            $sms_obj->phone = $shopify_customer_obj->phone;
            $sms_obj->save();
        }
    }
  
    public function getCustomers()
    {
        $data["customers"] = RewardCustomer::orderby("rewards_customer_id", "desc")->get()->take(3000);
      
        return view("reward/customer", $data);
    }
  
  
    public function getSms()
    {
        $data["sms"] = RewardSms::orderby("rewards_sms_id", "DESC")->get()->take(1000);
      
        return view("reward/sms", $data);
    }
  
    public function getActivitys()
    {
        $data["activities"] = RewardActivity::join("rewards_customers", "rewards_customers.customerId", "rewards_activitys.customerId")->orderby("rewards_activity_id", "desc")->take(2000)->get();
      
        return view("reward/activity", $data);
    }
}
