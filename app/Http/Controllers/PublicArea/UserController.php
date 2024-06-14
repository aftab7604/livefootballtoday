<?php

namespace App\Http\Controllers\PublicArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Carbon;
use Session;

class UserController extends Controller
{
    public function user_profile(){
        if(Session::has('userSession')){
            $userId = session('userSession');
            $userId = $userId->id;
            $UserDetail = DB::table('user_accounts')
                ->leftJoin('payment_detail', 'user_accounts.id', '=', 'payment_detail.user_id')
                ->leftJoin('membership-plan', 'payment_detail.plan_id', '=', 'membership-plan.id')
                ->where('user_accounts.id', $userId) 
                ->get();
            $response['paymentDetails'] = $UserDetail;
            return view('PublicArea.pages.accounts.profile')->with($response);
            
            
        }else{
            return redirect('user-account')->withErrors(['error' => 'Invalid Authorization.'])->withInput();
        }
    }
    
    public function user_change_password(){
        if(Session::has('userSession')){
            $userId = session('userSession');
            $userId = $userId->id;
            return view("PublicArea.pages.accounts.change-password");
        }else{
            return redirect('user-account')->withErrors(['error' => 'Invalid Authorization.'])->withInput();
        }
    }
    
    public function user_update_password(Request $request){
        if(Session::has('userSession')){
            $userId = session('userSession');
            $userId = $userId->id;
            
            $controls = $request->all();
            $rules = [
                "old_password" => "required",
                "new_password" => "min:4|max:16|required_with:confirm_new_password|same:confirm_new_password|different:old_password",
                "confirm_new_password"=>"min:4|max:16",
            ];
    
            $validator = Validator::make($controls,$rules);
            if($validator->fails()){
                return redirect()->back()->withInput()->withErrors($validator);
                // $finalResult = [
                //     "code"=>202,
                //     'success' => false,
                //     'msg'=>'Invalid Request - Validation erros',
                //     'errors' => $validator->getMessageBag()->toArray()
                // ];
                // dd($finalResult);
            }else{
                $UserDetail = DB::table('user_accounts')->where('user_accounts.id', $userId)->get()->first();
                if(Hash::check($controls['old_password'], $UserDetail->password)) {
                    $new_password = Hash::make($controls['new_password']);
                    $updated = DB::table('user_accounts')->where('user_accounts.id', $userId)->update(["password" => $new_password]);
                    if($updated){
                        $request->session()->flash('success', 'Password changed');
                        return redirect("user-profile");
                    }else{
                        return redirect()->back()->withErrors(['error' => 'Something went wrong with updating password'])->withInput();
                    }
                }else{
                    return redirect()->back()->withErrors(['error' => 'Invalid Old Password given'])->withInput();
                }
            }
        }else{
            return redirect('user-account')->withErrors(['error' => 'Invalid Authorization.'])->withInput();
        }
        
    }
}
