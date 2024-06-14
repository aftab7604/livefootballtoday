<?php

namespace App\Http\Controllers\AdminArea;

use Illuminate\Http\Request;
use services\Callers\CategoryCaller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserAccountController extends ParentController
{
    public function all()
    {
        $users = DB::table('user_accounts')->get();
        $response['users'] = $users;
        return view('AdminArea.pages.userAccounts.all')->with($response);
    }


    public function add()
    {
        return view('AdminArea.pages.userAccounts.add');
    }

    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:user_accounts,email',
            'password' => 'required|min:4|max:16',
            'confirm_password' => 'required|same:password',
        ]);
    
        // Remove confirm_password from the data array
        $data = $request->except('_token', 'confirm_password');
    
        // Hash the password before storing it
        $data['password'] = Hash::make($request->password);
    
        $id = $request->input('id');
    
        if ($id && $id != '') {
            // Update existing record
            DB::table('user_accounts')->where('id', $id)->update($data);
        } else {
            // Insert new record
            DB::table('user_accounts')->insert($data);
        }
    
        return redirect('admin/user-account/add')->with('alert-success', 'Data Save Successfully');
    }

    public function edit($id)
    {
        // Retrieve the membership based on the $id
        $response['users'] = DB::table('user_accounts')->find($id);
        return view('AdminArea.pages.userAccounts.add')->with($response);
    }

    public function delete($id)
    {
        // Delete the membership based on the $id
        DB::table('user_accounts')->where('id', $id)->delete();
        return redirect('admin/user-account/all')->with('alert-success', "Data Deleted Successfully");
    }

    public function forgot_password($id)
    {
        session(['forgotSessionId' => $id]);
        return view('AdminArea.pages.userAccounts.email');
    }

    public function email_check(Request $request)
    {
        $id = session('forgotSessionId'); 
        $email = $request->input('email');
        $user = DB::table('user_accounts')->where('id', $id)->where('email', $email)->first();
        if($user){
            return redirect('admin/user-account/reset-password')->with('alert-success', "Enter New Password");
        } else{
            return redirect('admin/user-account/forgot-password/'.$id)->with('alert-danger', "Please enter correct email.");
        }
    }

    public function reset_password()
    {
        return view('AdminArea.pages.userAccounts.reset-password');
    }

    public function success_reset_password(Request $request)
    {
        if ($request->input('password') !== $request->input('confirm_password')) {
            return redirect('/user-account')
                ->withErrors(['confirm_password' => 'The password and confirm password do not match.'])
                ->withInput();
        }
        
        $id = session('forgotSessionId');
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');
            $request->validate([
            'password' => 'required',
            'confirm_password' => 'required',
        ]);
    
        $hashedPassword = Hash::make($password);
        $affectedRows = DB::table('user_accounts')->where('id', $id)->update(['password' => $hashedPassword]);
        if ($affectedRows > 0) {
            return redirect('admin/user-account/add')->with('alert-success', 'Password reset successfully. Please log in with your new password.');
        } else {
            return redirect('admin/user-account/forgot-password/'.$id)->with('alert-danger', 'Failed to reset password. Please try again.');
        }
    }
    

}
