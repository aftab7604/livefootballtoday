<?php
namespace App\Http\Controllers\PublicArea;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Stripe\Stripe;
use Stripe\Charge;

class PlanController extends Controller
{
    // $stripe_mode (1 = live, 2 = test)
    public $stripe_mode = 1;
    
    public function all_plan()
    {
            // Fetch all records from the 'membership-plan' table
            $membershipPlans = DB::table('membership-plan')->get();
            $response['membershipPlans'] = $membershipPlans;
            return view('PublicArea.pages.plans.plan')->with($response);        
    }

    public function card_details()
    {
        if (session('userSession')) {
            $userId = session('userSession');
            $userId = $userId->id;
             $paymentDetail = DB::table('payment_detail')
                ->join('user_accounts', 'payment_detail.user_id', '=', 'user_accounts.id')
                ->where('user_accounts.id', $userId) 
                ->get();
            $response['paymentDetails'] = $paymentDetail;
            return view('PublicArea.pages.plans.profile')->with($response);
        } else {
            return redirect('user-account')->withErrors(['error' => 'No have account'])->withInput();
        }
    }

    public function cancelMembership()
{
    if (session('userSession')) {
        $userSessionId = session('userSession');
        $userId = $userSessionId->id;
       // $paymentDetail = DB::table('payment_detail')->where('user_id', $userId)->get();
        DB::table('payment_detail')->where('user_id', $userId)->delete();
        \Session::flush();
        \Auth::logout();
        return redirect('/plan')->with(['success' => 'Card details deleted successfully!']);
    } else {
        return redirect('/plan')->withErrors(['error' => 'Something went wrong'])->withInput();
    }
}

    
    public function purchase_plan($id){
        if (session('userSession') || session('msgSession')) {
        $membershipprice = DB::table('membership-plan')->where('id',$id)->first();
        $stripeConfig = DB::table('stripe_account')->where('id', $this->stripe_mode)->value('public_key');
        $plan_id = $id;
        return view("PublicArea.pages.plans.card-detail", compact('membershipprice','stripeConfig','plan_id'));
        } else {
            return redirect('user-account')->withErrors(['error' => 'To purchase plan, Please login first'])->withInput();
        }
    }
    
    public function check_if_user_has_plan($user_id){
        $paymentDetail = DB::table('payment_detail')
                ->join('user_accounts', 'payment_detail.user_id', '=', 'user_accounts.id')
                ->where(['payment_detail.user_id'=>$user_id,'payment_detail.status'=>1])
                ->select('payment_detail.*', 'payment_detail.created_at as payment_date')
                ->orderBy('payment_detail.id', 'desc')
                ->get();
                
        if ($paymentDetail->isNotEmpty()) { 
            $createdAt = Carbon::parse($paymentDetail[0]->payment_date)->timezone('UTC'); // Set the timezone
            $currentDate = Carbon::now()->timezone('UTC'); // Set the timezone
            $daysDifference = $currentDate->diffInDays($createdAt);
            $planPackage = $paymentDetail[0]->plan_package;
            $duration = ($planPackage === 'monthly') ? 30 : 365;
            if ($daysDifference > $duration) {
                $finalResult = [
                    "plan_exist"=>false,
                    'payment_detail'=>$paymentDetail
                ];
            } else {
                $finalResult = [
                    "plan_exist"=>true,
                    'payment_detail'=>$paymentDetail
                ];
            }
        }else{
            $finalResult = [
                "plan_exist"=>false,
                'payment_detail'=>$paymentDetail
            ];
        }
        
        return $finalResult;
    }

    public function purchase_planrec(Request $req, $id){
        $user_id = session('userSession')->id;
        $owner_name = session('userSession')->first_name;
        $owner_email = session('userSession')->email;
        $already_stripe_subscription = DB::table("user_accounts")->where(['id'=>$user_id])->value('stripe_subscription_id');
        if(is_null($already_stripe_subscription)){
            $exist = $this->check_if_user_has_plan($user_id);
            if ($exist['plan_exist']) {
                return redirect('/plan')->with(['failure' => 'You have already purchased a plan.']);
            }else{
                $controls = $req->all();
                // dd($controls);
                $membersashipprice = DB::table('membership-plan')->select('*')->where('id',$id)->first();
                
                $stripeSecret = DB::table('stripe_account')->where('id', $this->stripe_mode)->value('secret_key');
                $stripePublic = DB::table('stripe_account')->where('id', $this->stripe_mode)->value('public_key');
                
                $req->validate([
                    // 'card_name' => 'required|string',
                    'plan_packge' => 'required|in:monthly,yearly',
                    'plan_type' => 'required|in:automatic,manual',
                    'policy' => 'required|accepted',
                    'stripeToken' => 'required',
                ]);
                
                $plan_packge = $req->input('plan_packge');
                
                if($plan_packge == 'monthly'){
                    $membershippricedd = $controls['plan_type'] == 'automatic' ? $membershipprice->stripe_monthly_price_id : $membershipprice->monthly_price;
                } elseif($plan_packge == 'yearly'){
                    $membershippricedd = $controls['plan_type'] == 'automatic' ? $membershipprice->stripe_yearly_price_id : $membershipprice->yearly_price;
                }else{
                    return redirect('/plan')->with(['failure' => 'Something error!']);
                }
                $token = $req->input('stripeToken');
                $policy = $req->input('policy') ?? 0;
                
                
                if($controls['plan_type'] == 'manual'){
                    $customer = $this->saveCustomer($owner_email, $token, $owner_name);
                    $stripe_meta = [
                        'user_id' => $user_id,
                        'plan_id' => $id,
                        'interval' => $plan_packge,
                        'payment_type' => $controls['plan_type'],
                    ];
                    $customerID = $customer->id;
                    DB::table("user_accounts")->where(['stripe_customer_id'=>$customerID])->update(['stripe_meta'=>json_encode($stripe_meta)]);
                    $stripe = new \Stripe\StripeClient($stripeSecret);    
                    $intent = $stripe->paymentIntents->create([
                        'amount' => ($membershippricedd * 100),
                        'currency' => 'gbp',
                        'payment_method_types' => ['card'],
                        'customer'=>$customer->id,
                        'source'=>$customer->default_source,
                        'capture_method'=>'automatic',
                        'confirm'=>'true',
                        'metadata' => $stripe_meta,
                    ]);
                }else{
                    $customer = $this->saveCustomer($owner_email, $token, $owner_name);
                    $stripe_meta = [
                        'user_id' => $user_id,
                        'plan_id' => $id,
                        'interval' => $plan_packge,
                        'payment_type' => $controls['plan_type'],
                    ];
                    $customerID = $customer->id;
                    DB::table("user_accounts")->where(['stripe_customer_id'=>$customerID])->update(['stripe_meta'=>json_encode($stripe_meta)]);
                    $stripe = new \Stripe\StripeClient($stripeSecret);    
                    $intent = $stripe->setupIntents->create([
                        'customer' => $customer->id,
                        'payment_method_types' => ['card'],
                        'payment_method' => $customer->default_source,
                        'confirm'=>true,
                        'metadata' => $stripe_meta,
                    ]);
                }
                
                if($intent && $intent->status == 'succeeded'){
                    
                    flush(); // execute the stuff you did until now
                    sleep(5); // wait 5 sec
                    
                    $exist = $this->check_if_user_has_plan($user_id);
                    
                    if($exist['plan_exist']){
                        session(['has_purchased_planed_user' => true]);
                        session(['paymentDetailSession' => $exist['payment_detail']]);
                        return redirect('/plan')->with(['success' => 'Plan Purcahsed Successfully!']);   
                    }else{
                        session()->forget('has_purchased_planed_user');
                        return redirect('/plan')->with(['failure' => 'Something went wrong!']);
                    }
                }else{
                    return redirect('/plan')->with(['failure' => 'Something went wrong.']); 
                }
            }   
        }else{
            return redirect('/plan')->with(['failure' => 'You already have active subscription']); 
        }
    }
    
    public function stripe_paypal_setup_ajax(Request $request){
        $stripeSecret = DB::table('stripe_account')->where('id', $this->stripe_mode)->value('secret_key');
        $stripePublic = DB::table('stripe_account')->where('id', $this->stripe_mode)->value('public_key');
        
        if (session('userSession')) {
            $plan_id = $request->plan_id;
            
            $interval = $request->interval; // monthly, yearly
            $payment_type = $request->payment_type; //automatic, manual
            
            
            $user_id = session('userSession')->id;
            
            $already_stripe_subscription = DB::table("user_accounts")->where(['id'=>$user_id])->value("stripe_subscription_id");
            if(is_null($already_stripe_subscription)){
            
                $exist = $this->check_if_user_has_plan($user_id);
            
            
                if ($exist['plan_exist']) {
                    return [
                        'success'=>false,
                        'code'=>201,
                        'error' => 'You have already purchased a plan.',
                        'msg'=>null,
                        'data'=>null,
                    ];
                }else{
                    $owner_name = session('userSession')->first_name;
                    $owner_email = session('userSession')->email;
                    $customer = $this->saveCustomer($owner_email, $token = null, $owner_name);
                    
                    $stripe = new \Stripe\StripeClient($stripeSecret);
                    
                    if($payment_type == 'automatic'){
                        $stripe_meta = [
                            'user_id' => $user_id,
                            'plan_id' => $plan_id,
                            'interval' => $interval,
                            'payment_type' => $payment_type,
                        ];
                        $customerID = $customer->id;
                        DB::table("user_accounts")->where(['stripe_customer_id'=>$customerID])->update(['stripe_meta'=>json_encode($stripe_meta)]);
                        $intent = $stripe->setupIntents->create([
                            'customer' => $customer->id,
                            'payment_method_types' => ['paypal'],
                            'payment_method_data' => ['type' => 'paypal'],
                            'metadata' => $stripe_meta,
                        ]);
                    }elseif($payment_type == 'manual'){
                        if($interval == 'yearly'){
                            $plan_price = DB::table('membership-plan')->where('id', $plan_id)->value('yearly_price');    
                        }else{
                            $plan_price = DB::table('membership-plan')->where('id', $plan_id)->value('monthly_price');    
                        }
                        
                        $stripe_meta = [
                                'user_id' => $user_id,
                                'plan_id' => $plan_id,
                                'interval' => $interval,
                                'payment_type' => $payment_type,
                        ];
                        $customerID = $customer->id;
                        DB::table("user_accounts")->where(['stripe_customer_id'=>$customerID])->update(['stripe_meta'=>json_encode($stripe_meta)]);
                        
                        $intent = $stripe->paymentIntents->create([
                            'customer' => $customer->id,
                            'amount' => ($plan_price * 100),
                            'currency' => 'gbp',
                            'payment_method_types' => ['paypal'],
                            'metadata' => $stripe_meta,
                            
                        ]);
                    }else{
                        return [
                            'success'=>false,
                            'code'=>201,
                            'error' => 'Invalid Payment Type',
                            'msg'=>null,
                            'data'=>null,
                        ];
                    }
                    
                    
                    $finalResult = [
                        'success'=>true,
                        'code'=>200,
                        'error' => null,
                        'msg'=>'Intent',
                        'data'=>[
                            'payment_type'=>$payment_type,
                            'stripe_public'=>$stripePublic,
                            'intent'=>$intent
                        ],
                    ];
                }
            }else{
                $finalResult = [
                    'success'=>false,
                    'code'=>201,
                    'error' => 'You already have a subscription',
                    'msg'=>null,
                    'data'=>null,
                ];
            }
        } else {
            $finalResult = [
                'success'=>false,
                'code'=>201,
                'error' => 'To purchase plan, Please login first',
                'msg'=>null,
                'data'=>null,
            ];
        }
        
        return $finalResult;
        
    }
    
    public function stripe_paypal_response(Request $request){
        $user_id = session('userSession')->id;
        $owner_name = session('userSession')->first_name;
        $owner_email = session('userSession')->email;
        
        flush(); // execute the stuff you did until now
        sleep(5); // wait 5 sec
        
        $exist = $this->check_if_user_has_plan($user_id);
        // dd($exist);
        
        if($exist['plan_exist']){
            session(['has_purchased_planed_user' => true]);
            session(['paymentDetailSession' => $exist['payment_detail']]);
            return redirect('/plan')->with(['success' => 'Plan Purcahsed Successfully!']);   
        }else{
            session()->forget('has_purchased_planed_user');
            return redirect('/plan')->with(['failure' => 'Something went wrong!']);
        }
        
    }

    public function saveCustomer($email, $token = null, $name = '')
    {
        $stripeConfig = DB::table('stripe_account')->where('id', $this->stripe_mode)->value('secret_key');
        Stripe::setApiKey($stripeConfig);
        $stripeCust = \Stripe\Customer::search([
            "query" => 'email:\'' . $email . '\'',
            "limit" => 1,
        ]);

        if (isset($stripeCust->data[0]) && !empty($stripeCust->data[0])) {
            $customer = $stripeCust->data[0];
            if(!is_null($token) && !empty($token)){
                $customer_ID = $stripeCust->data[0]->id;
                $customer = \Stripe\Customer::update($customer_ID,
                  ['source' => $token]
                );    
            }
            
            
        } else {
            $customerArr = [
                "email" => $email,
                "name" => $name,
                "description" => 'Football plan purchased',
            ];
            
            if(!is_null($token) && !empty($token)){
                $customerArr['source'] = $toekn;
            }
            
            $customer = \Stripe\Customer::create($customerArr);
            
        }
        
        DB::table("user_accounts")->where(['email'=>$email])->update(['stripe_customer_id'=>$customer->id]);
        return $customer;

    }

    public function stripeCharge($payData)
    {
        extract($payData);
        $amount = isset($payData['amount']) ? ($amount * 100) : 1000;
        $currency = isset($payData['currency']) ? $currency : 'gbp';
        $description = isset($payData['description']) ? $description : '';
        $stripeConfig = DB::table('stripe_account')->where('id', $this->stripe_mode)->value('secret_key');
        try {
            Stripe::setApiKey($stripeConfig);
            $charge = Charge::create([
                'amount' => $amount,
                'currency' => $currency,
                'customer' => $stripe_customer_id,
                'description' => $description,
            ]);
            return 1;
            //return '<div class="alert alert-success">Success! Amount Charged Successfully...</div>';

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function stripe_subscription_cancel_ajax(Request $request){
        if (session('userSession')) {
            $stripeConfig = DB::table('stripe_account')->where('id', $this->stripe_mode)->value('secret_key');
             
            $userSessionId = session('userSession');
            $userId = $userSessionId->id;
            $user = DB::table('user_accounts')->where('id', $userId)->first();
            if($user->stripe_subscription_id){
                $subscriptionId = $user->stripe_subscription_id;
                $stripe = new \Stripe\StripeClient($stripeConfig);
                $cancelSubscription = $stripe->subscriptions->cancel($subscriptionId, []);
                if($cancelSubscription && $cancelSubscription->status == "canceled"){
                    $updated = DB::table('user_accounts')->where("id",$userId)->update([
                        "stripe_subscription_id"=>null
                    ]);
                    
                    if($updated){
                        $finalResult = [
                            'success'=>true,
                            'code'=>200,
                            'error' => null,
                            'msg'=>'Subscription has been cancel',
                            'data'=>$cancelSubscription,
                        ];     
                    }else{
                        $finalResult = [
                            'success'=>false,
                            'code'=>201,
                            'error' => "Something went wrong with updating record",
                            'msg'=>null,
                            'data'=>null,
                        ];     
                    }
                }else{
                    $finalResult = [
                        'success'=>false,
                        'code'=>201,
                        'error' => "Something went wrong with canceling subscription",
                        'msg'=>null,
                        'data'=>null,
                    ]; 
                }
            }else{
                $finalResult = [
                    'success'=>false,
                    'code'=>201,
                    'error' => "You don't have any subscription",
                    'msg'=>null,
                    'data'=>null,
                ];    
            }
        } else {
            $finalResult = [
                'success'=>false,
                'code'=>201,
                'error' => 'Invalid Access',
                'msg'=>null,
                'data'=>null,
            ];
        }
        
        return $finalResult;
    }
    
    public function cancelMembershipAjax()
    {
        if (session('userSession')) {
            $stripeConfig = DB::table('stripe_account')->where('id', $this->stripe_mode)->value('secret_key');
        
            
            $userSessionId = session('userSession');
            $userId = $userSessionId->id;
            $user = DB::table('user_accounts')->where('id', $userId)->first();
            if($user->stripe_subscription_id){
                
                $subscriptionId = $user->stripe_subscription_id;
                $stripe = new \Stripe\StripeClient($stripeConfig);
                $cancelSubscription = $stripe->subscriptions->cancel($subscriptionId, []);
                if($cancelSubscription && $cancelSubscription->status == "canceled"){
                    $updated = DB::table('user_accounts')->where("id",$userId)->update([
                        "stripe_subscription_id"=>null
                    ]);
                    
                    if(!$updated){
                        return [
                            'success'=>false,
                            'code'=>201,
                            'error' => "Something went wrong with updating record",
                            'msg'=>null,
                            'data'=>null,
                        ];     
                    }
                    
                }else{
                    return [
                        'success'=>false,
                        'code'=>201,
                        'error' => "Something went wrong with canceling subscription",
                        'msg'=>null,
                        'data'=>null,
                    ]; 
                }
            }
            
            DB::table('payment_detail')->where('user_id', $userId)->delete();
            \Session::flush();
            \Auth::logout();
            
            $finalResult = [
                'success'=>true,
                'code'=>200,
                'error' => null,
                'msg'=>'Membership Cancelled',
                'data'=>null,
            ];
        } else {
            $finalResult = [
                'success'=>false,
                'code'=>201,
                'error' => 'Invalid Access',
                'msg'=>null,
                'data'=>null,
            ];
        }
        
        return $finalResult;
    }
}
