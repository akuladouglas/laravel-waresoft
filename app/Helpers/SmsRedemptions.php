<?php
namespace App\Helpers;

/**
 * SmsRedemptions
 * @author epic-code
*/

class SmsRedemptions {
  
  public $sms;
  public $phone_number;
  private $headers = array("Authorization: Apikey 495993e27b695496030f6394c7200ae4");

 /* Nine Action Points
   1. Get the sms logged in the portal. - Done
   2. Get the phone number and the points to redeem from the sms.
   3. Validate if user has points or not by checking in customer log.
   4. Reply to user if she has no enough points with the points he/ she can redeem.
   5. If enough points invoke marsello api and redeem points.
   6. Get the discount code provided by marsello and send sms to customer with the voucher code.
   7. Send sms to customer with remaining points and marketing text to continue shopping to get more points.
   8. Prepare a cron job to run scheduled tasks every month to remind customers to redeem their points
   9. Reporting for customers who are able to redeem their points on cyfe dashboard and customers who have points that can be redeemed
   * 
   */
  
  function __construct() {
     
  }
  
  public static function redeemPoints($from, $text){
    
    $pointsToRedeem = $this->getPointsToRedeem($text);
    $customerObj = RewardCustomer::join("customers","reward_customers.emailAddress", "=", "customers.email")
                                      ->where("customers.phone", $from)
                                      ->get()
                                      ->first();
    
    $customerPoints = $customerObj->pointsBalance;
    
    if($pointsToRedeem > $customerPoints){
      $smsText = "Sorry, the points you wish to redeem are less than your total points";
      
    } else {
       $redeemPoints = $this->redeemLoyaltyPoints($from);
       $discountCoupon = $this->getDiscountCode($customerObj->accountId);
       
       $smsText = "Thank you for redeeming your discount. Your coupon is $discountCoupon";
       
    }
    
  }

  public  function getPointsToRedeem($text) {
    
    $explodedText = explode(" ", $text);
    
    $points = $explodedText[1];
    return $points;
  }
  
  
  public function getPhoneNumber() {
    
    
  }
  
  public function getLoyaltyPoints() {
    
    
  }
  
  
  public function redeemLoyaltyPoints($customerId = "5b3f8ae18e2bf3162006e77e", $rewardId = "5b29c5798e2bf30fe0e11ed0") {
   
   $url = "https://app.marsello.com/api/v1/rewards/claim";
   
   $couponCode = rand(100, 999). rand(200, 9999);
   
   $data = "customerId=$customerId&rewardId=$rewardId&couponCode=$couponCode";
   
   $success = $this->postData($url, $data);
   
   return $success;
   
  }
  
  
  public function postData($url, $post_data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $result = curl_exec($ch);

        return $result;
  }
  
  public function get_data($url)
  {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
  }
  
  
  public function getDiscountCode($customer_id)
  {
        $url = "https://app.marsello.com/api/v1/customers/availablerewards/$customer_id";
      
        $response = $this->get_data($url, $this->headers);
      
        $decoded = json_decode($response);
      
        $results_customer_id = $decoded->Customer->CustomerId;
        $reward_coupons_array = $decoded->Rewards;
      
        foreach ($reward_coupons_array as $key => $reward_coupons) {
            $coupon = RewardCoupon::where("coupon_id", $reward_coupons->Id)->get()->first();
        
            if (!$coupon) {
                $coupon = new RewardCoupon();
            }
        
            $coupon->customer_id = $results_customer_id;
            $coupon->coupon_id = $reward_coupons->Id;
            $coupon->account_id = $reward_coupons->AccountId;
            $coupon->created_at = Carbon::parse($reward_coupons->CreatedAt)->format("Y-m-d H:m:s");
            $coupon->title = $reward_coupons->Title;
            $coupon->terms = $reward_coupons->Terms;
            $coupon->points_required = $reward_coupons->PointsRequired;
            $coupon->discount_amount = $reward_coupons->DiscountAmount;
            $coupon->save();
        }
      
        return true;
    }
  
}