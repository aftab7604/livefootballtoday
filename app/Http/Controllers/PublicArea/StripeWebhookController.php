<?php

namespace App\Http\Controllers\PublicArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook\Signature;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Stripe\Stripe;
use Stripe\Charge;

class StripeWebhookController extends Controller
{
    // $stripe_mode (1 = live, 2 = test)
    public $stripe_mode = 1;
    
    public function updateWebhook(){
        $stripeSecret = DB::table('stripe_account')->where('id',$this->stripe_mode)->value('secret_key');
        $stripe = new \Stripe\StripeClient($stripeSecret);
        $customer = $stripe->customers->retrieve("cus_PrquHHK3vzHy12");
        dd($customer);
        // $list = $stripe->webhookEndpoints->all(['limit' => 100]);
        // dd($list);
        
        // $created = $stripe->webhookEndpoints->create([
        //   'enabled_events' => ['*'],
        //   'url' => 'https://livefootballtoday.co.uk/stripe/webhook',
        // ]);
        
        // dd($created);
        
        // $deleted = $stripe->webhookEndpoints->delete('we_1P2BRtEYgnuZUf8arbMdBgGb', []);
        // dd($deleted);
        

        // $updated = $stripe->webhookEndpoints->update($list->data[0]->id,
        //     [
        //         'url' => 'https://livefootballtoday.co.uk/stripe/webhook',
        //         'enabled_events' => ['*']
        //     ]
        // );
        
        // dd($updated);

    }
    public function handleWebhook(Request $request)
    {
        $stripeSecret = DB::table('stripe_account')->where('id',$this->stripe_mode)->value('secret_key');
        
        $response = $request->all();
  
        \Stripe\Stripe::setApiKey($stripeSecret);
        $endpoint_secret = 'whsec_eBTzRJSYlin0jjQvcxiWQ4wjuJgvNXWp'; //config('services.stripe.webhook_secret');
        
        $payload = @file_get_contents('php://input');
        $event = null;
        
        try {
            $event = \Stripe\Event::constructFrom(json_decode($payload, true));
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Webhook error while parsing basic request.', ['error' => $e->getMessage()]);
            http_response_code(400);
            exit();
        }
        
        if ($endpoint_secret) {
            $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
            try {
                $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
            } catch(\Stripe\Exception\SignatureVerificationException $e) {
                // Invalid signature
                Log::error('Webhook error while validating signature.', ['error' => $e->getMessage()]);
                http_response_code(400);
                exit();
            }
        }
        
        Log::info('Webhook Event', ['event' => $event->type]);
        Log::info('Webhook Data' , ['Data' => $event->data->object]);
        
        // Handle the event
        switch ($event->type) {
            case 'setup_intent.succeeded':
                $setupIntent = $event->data->object;
                $this->handleSetupIntentSucceeded($setupIntent);
                break;
            case 'charge.succeeded':
                $charge = $event->data->object; // contains a \Stripe\PaymentIntent
                $this->handleChargeSucceeded($charge);
                break;
            case 'invoice.payment_succeeded':
                $invoice = $event->data->object;
                $this->handleInvoicePaymentSucceeded($invoice);
                break;
            default:
                // Log::error('Received unknown event type', ['error' => 'Unknown Event']);
        }
        
        http_response_code(200);
    }
    
    public function handleInvoicePaymentSucceeded($invoice){
        $customerID = $invoice->customer;
        $stripemeta = DB::table("user_accounts")->where(['stripe_customer_id'=>$customerID])->value('stripe_meta');
        $metadata = json_decode($stripemeta,true);
        $user_id = $metadata['user_id'];
        $plan_id = $metadata['plan_id'];
        $interval = $metadata['interval'];
        $payment_type = $metadata['payment_type'];
        
        // $metadata = $setupIntent->metadata;
        // $user_id = data_get($metadata, 'user_id');
        // $plan_id = data_get($metadata, 'plan_id');
        // $interval = data_get($metadata, 'interval');
        // $payment_type = data_get($metadata, 'payment_type');
        
        if($payment_type == 'automatic'){
            DB::table('payment_detail')->insert([
                'user_id' => $user_id,
                'plan_id'=>$plan_id,
                'plan_package' => $interval,
                'payment_type' => $payment_type,
                'policy' => 1,
                'charge_success'=>json_encode($invoice),
            ]);   
        }
        
    }
    
    public function handleSetupIntentSucceeded($setupIntent){
        $customerID = $setupIntent->customer;
        $stripemeta = DB::table("user_accounts")->where(['stripe_customer_id'=>$customerID])->value('stripe_meta');
        $metadata = json_decode($stripemeta,true);
        $stripeConfig = DB::table('stripe_account')->where('id', $this->stripe_mode)->value('secret_key');
        $stripe = new \Stripe\StripeClient($stripeConfig);
        
        $payment_method = $setupIntent->payment_method;
        
        $user_id = $metadata['user_id'];
        $plan_id = $metadata['plan_id'];
        $interval = $metadata['interval'];
        $payment_type = $metadata['payment_type'];
        
        // $metadata = $setupIntent->metadata;
        // $user_id = data_get($metadata, 'user_id');
        // $plan_id = data_get($metadata, 'plan_id');
        // $interval = data_get($metadata, 'interval');
        // $payment_type = data_get($metadata, 'payment_type');
        
        if($this->stripe_mode == 1){
            if($interval == 'yearly'){
                $priceId = DB::table('membership-plan')->where('id', $plan_id)->value('stripe_yearly_price_id');
            }else{
                $priceId = DB::table('membership-plan')->where('id', $plan_id)->value('stripe_monthly_price_id');
            }
        }else{
            if($interval == 'yearly'){
                $priceId = DB::table('membership-plan')->where('id', $plan_id)->value('test_stripe_yearly_price_id');
            }else{
                $priceId = DB::table('membership-plan')->where('id', $plan_id)->value('test_stripe_monthly_price_id');
            }
        }
        
        
        $subscription = $stripe->subscriptions->create([
            'customer' => $setupIntent->customer,
            'default_payment_method' => $payment_method,
            'items' => [
                [
                    'price' => $priceId,
                    'quantity' => 1,
                ],
            ],
            'off_session' => true,
            'metadata'=>[
                "plan_id"=>$plan_id,
                "interval"=>$interval,
                "user_id"=>$user_id,
                "payment_type"=>$payment_type
            ]
        ]);
        
        DB::table("user_accounts")->where(['stripe_customer_id'=>$customerID])->update(['stripe_subscription_id'=>$subscription->id]);
    }
    
    public function handleChargeSucceeded($charge){
        $customerID = $charge->customer;
        $stripemeta = DB::table("user_accounts")->where(['stripe_customer_id'=>$customerID])->value('stripe_meta');
        $metadata = json_decode($stripemeta,true);
        
        $user_id = $metadata['user_id'];
        $plan_id = $metadata['plan_id'];
        $interval = $metadata['interval'];
        $payment_type = $metadata['payment_type'];
        // $metadata = $charge->metadata;

        // $plan_id = data_get($metadata, 'plan_id');
        // $user_id = data_get($metadata, 'user_id');
        // $interval = data_get($metadata, 'interval'); // monthly/yearly
        // $payment_type = data_get($metadata, 'payment_type'); // automatic/manual
        if($payment_type == 'manual'){
            DB::table('payment_detail')->insert([
                'user_id' => $user_id,
                'plan_id'=>$plan_id,
                'plan_package' => $interval,
                'payment_type' => $payment_type,
                'policy' => 1,
                'charge_success'=>json_encode($charge),
            ]);   
        }
    }
}
