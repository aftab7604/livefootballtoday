<?php

namespace App\Http\Controllers\AdminArea;

use Illuminate\Http\Request;
use services\Callers\CategoryCaller;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Exception\InvalidRequestException;

class StripeController extends ParentController
{
        public function all()
    {
        // Fetch all records from the 'membership-plan' table
        $stripeAccounts = DB::table('stripe_account')->get();
        $response['stripeAccounts'] = $stripeAccounts;
        return view('AdminArea.pages.stripes.all')->with($response);
    }

    public function add()
    {
        $response['getStripe'] = DB::table('stripe_account')->find(1);
        return view('AdminArea.pages.stripes.add')->with($response);
    }

    public function store(Request $request)
{
     // Validation if needed
     $request->validate([
        'secret_key' => 'required',
        'public_key' => 'required',
    ]);

    $data = $request->except('_token');
    // $id = $request->input('id') ?? '';

    try {
        // Set Stripe API keys for validation
        Stripe::setApiKey($data['secret_key']);

        // Use Stripe SDK to check if the keys are valid
        $account = \Stripe\Account::retrieve();
        $response['getStripe'] = DB::table('stripe_account')->find(1);
        if (isset($response['getStripe']->id) && $response['getStripe']->id != '') { 
            $id = $response['getStripe']->id;
            DB::table('stripe_account')->where('id', $id)->update($data);
        } else {
            DB::table('stripe_account')->insert($data);
        }

        return redirect('admin/add-stripe')->with('alert-success', "Stripe Save Successfully");
    } catch (AuthenticationException $e) {
        // Handle the specific AuthenticationException and provide a user-friendly error message
        return redirect('admin/add-stripe')->with('alert-danger', "Invalid Stripe API Key: " . $e->getMessage());
    } catch (\Exception $e) {
        // Handle other exceptions
        return redirect('admin/add-stripe')->with('alert-danger', "Error: " . $e->getMessage());
    }
}

    public function edit($id)
    {
        // Retrieve the membership based on the $id
        $response['getStripe'] = DB::table('stripe_account')->find($id);
        return view('AdminArea.pages.stripes.add')->with($response);
    }

}
