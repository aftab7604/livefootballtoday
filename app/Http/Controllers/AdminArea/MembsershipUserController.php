<?php

namespace App\Http\Controllers\AdminArea;

use Illuminate\Http\Request;
use services\Callers\CategoryCaller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class MembsershipUserController extends ParentController
{
    public function all()
{
    $users = DB::table('payment_detail')
            ->join('user_accounts', 'payment_detail.user_id', '=', 'user_accounts.id')
            ->whereDate('payment_detail.created_at', '<=', now()->toDateString())
            ->get();

    // Filter records based on plan_package
    $filteredUsers = [];
    foreach ($users as $user) {
        $planPackage = $user->plan_package;
        $createdAt = Carbon::parse($user->created_at);

        if ($planPackage === 'monthly' && now()->diffInDays($createdAt) <= 30) {
            $filteredUsers[] = $user;
        } elseif ($planPackage === 'yearly' && now()->diffInDays($createdAt) <= 365) {
            $filteredUsers[] = $user;
        }
        // Add more conditions as needed for other plan_package values
    }

    $response['users'] = $filteredUsers;
    return view('AdminArea.pages.membershipUsers.all')->with($response);
}

    

     public function add()
    {
        $users = DB::table('user_accounts')->get();
        return view('AdminArea.pages.membershipUsers.add', compact('users'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'user_id' => 'required',
            'plan_package' => 'required',
            'free_membership' => 'required',
        ]);
    
        // Remove confirm_password from the data array
        $data = $request->except('_token');
        $data['payment_type'] = 'manual';
        $data['created_at'] = date("Y-m-d H:i:s");

         $id = $request->input('user_id');
        // if ($id && $id != '') {
        //     DB::table('payment_detail')->where('user_id', $id)->update($data);
        // } 
        if ($id && $id != '') {
            DB::table('payment_detail')->where('user_id', $id)->delete();
        }
            DB::table('payment_detail')->insert($data);
        
    
        return redirect('admin/membership/add')->with('alert-success', 'Data Save Successfully');
    }

    public function delete($id)
    {
        // Delete the membership based on the $id
       // DB::table('user_accounts')->where('id', $id)->delete();
        DB::table('payment_detail')->where('user_id', $id)->delete();
        \Session::flush();
        \Auth::logout();
        return redirect('admin/membership/all')->with('alert-success', "Membership Deleted Successfully");
    }
}
