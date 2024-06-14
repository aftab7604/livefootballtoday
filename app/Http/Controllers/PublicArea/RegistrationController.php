<?php
namespace App\Http\Controllers\PublicArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use DateTime;
use Session;
class RegistrationController extends Controller
{
    public function index()
    {
        return view('PublicArea.pages.accounts.account');
    }
    

    public function user_login(Request $request)
{
    // Login validation
    $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);

    $user = DB::table('user_accounts')->where('email', $request->input('email'))->first();

    if ($user && Hash::check($request->input('password'), $user->password)) {
        // Create an instance of GenericUser
        $genericUser = new GenericUser((array)$user);

        session(['userEmail' => $user->email]);
        session(['userSession' => $user]);
        if (session('userSession')) {
            $userId = session('userSession')->id;
        
            // Fetching the payment details
            $paymentDetail = DB::table('payment_detail')
                ->join('user_accounts', 'payment_detail.user_id', '=', 'user_accounts.id')
                ->where('user_accounts.id', $userId)
                ->select('payment_detail.*', 'payment_detail.created_at as payment_date')
                ->get();
                if ($paymentDetail->isNotEmpty()) { 
                    $createdAt = Carbon::parse($paymentDetail[0]->payment_date)->timezone('UTC'); // Set the timezone
                    $currentDate = Carbon::now()->timezone('UTC'); // Set the timezone
                    $daysDifference = $currentDate->diffInDays($createdAt);
                    $planPackage = $paymentDetail[0]->plan_package;
                    $duration = ($planPackage === 'monthly') ? 30 : 365;
                    if ($daysDifference > $duration) {
                        session()->forget('has_purchased_planed_user');
                    } else {
                        session(['has_purchased_planed_user' => true]);
                        session(['paymentDetailSession' => $paymentDetail]);
                    }
                }
        }
        // Login using the GenericUser instance
        \Auth::login($genericUser);

        \Log::info('User authenticated successfully after login.');
        if(count($paymentDetail)>0){
            return redirect('/')->withErrors(['error' => 'Login Successfuly!'])->withInput();
        } else{
            return redirect('/plan')->withErrors(['error' => 'Please purchase the membership for ads free, betting tips and to view our articles.'])->withInput();
        }
    } else {
        \Log::error('Authentication failed during login.');
        return redirect('user-account')->withErrors(['error' => 'Email or password not matched'])->withInput();
    }
}

    // registration code..
    public function user_registration(Request $request)
{
    if ($request->input('password') !== $request->input('confirm_password')) {
        return redirect('/user-account')
            ->withErrors(['confirm_password' => 'The password and confirm password do not match.'])
            ->withInput();
    }
    // validation
    $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|unique:user_accounts|email',
        'password' => 'required|min:4|max:16',
    ]);

    // user inserted
    $userId = DB::table('user_accounts')->insertGetId([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $user = DB::table('user_accounts')->where('id', $userId)->first();

    // session(['first_name' => $request->first_name]);
     session(['userSession' => $user]);
    $paymentDetail = DB::table('payment_detail')
    ->join('user_accounts', 'payment_detail.user_id', '=', 'user_accounts.id')
    ->where('user_accounts.id', $userId) 
    ->get();
    
    if ($user) {
        // Create an instance of GenericUser
        $genericUser = new GenericUser((array)$user);

        // Login using the GenericUser instance
        \Auth::login($genericUser);

        \Log::info('User authenticated successfully after registration.');
        session(['msgSession' => 'x1']);
        if(count($paymentDetail)>0){
            session(['userSession' => $user]);
            return redirect('/')->withErrors(['error' => 'Login Successfuly!'])->withInput();
        } else{
            return redirect('/plan')->withErrors(['error' => 'Please purchase the membership for ads free, betting tips and to view our articles.'])->withInput();
        }
        //return redirect('/user-account')->withErrors(['error' => 'Your account has been created successfully!'])->withInput();
    } else {
        \Log::error('Authentication failed after registration.');
        return redirect('user-account')->withErrors(['error' => 'Something error'])->withInput();
    }
}


    // logout
    public function user_logout()
    {
        \Session::flush();
        \Auth::logout();
        return redirect('/');
    }
    
    public function forgot_password(){
        return view('PublicArea.pages.accounts.forgot-password');
    }
    
    public function send_forgot_password_link(Request $request){
        $user = DB::table('user_accounts')->where('email',$request->email)->first();
        if(empty($user)){
            return redirect()->back()->withErrors(['email' => 'User does not exist']);   
        }
        
        $token = Str::random(60);
        
        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        
        //Get the token just created above
        $tokenData = DB::table('password_resets')->where(['email'=>$request->email,'token'=>$token])->orderBy("created_at","desc")->first();
     
        
        if ($this->sendResetEmail($request->email, $tokenData->token)) {
            return redirect()->back()->withErrors(['error' => 'A reset link has been sent to your email address.']);
        } else {
            return redirect()->back()->withErrors(['error' => 'A Network Error occurred. Please try again.']);
        }
    }
    
    private function sendResetEmail($email, $token){
    
        //Retrieve the user from the database
        $user = DB::table('user_accounts')->where('email', $email)->select('first_name', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link =  url('forgot-password/reset/token/' . $token);
        
        $data['link'] = $link;
        Mail::to($email)->send(new \App\Mail\sendResetPasswordLinkToUser($data));
        if(Mail::failures()){
            return false;
        }else{
            return true;
        }
    }
    public function forgot_password_reset_form($token){
        $data['reset_password_token'] = $token;
        
        return view('PublicArea.pages.accounts.forgot-password-reset',$data);
    }
    public function forgot_password_reset(Request $request){
        //Validate input
        $request->validate([
            'password' => 'required|min:6',
            'confirm_password' => 'required_with:password|same:password|min:6',
            'reset_password_token' => 'required' 
        ]);
        
        $time_ago = date( "Y-m-d H:i:s",strtotime("-20 minute"));
        $isTokenValid = DB::table('password_resets')->where("token",$request->reset_password_token)->where("created_at",">=",$time_ago)->orderBy("created_at","desc")->first();
        if($isTokenValid){
            DB::table('password_resets')->where('email', $isTokenValid->email)->delete();
            $newPassword = Hash::make($request->password);
            $updated = DB::table("user_accounts")->where("email",$isTokenValid->email)->update(["password"=>$newPassword]);
            if($updated){
                return redirect('/user-account')->withErrors(['error' => 'Your password has been reset'])->withInput();
            }else{
                return redirect('/forgot-password')->withErrors(['error' => 'Something went wrong with reseting password'])->withInput();
            }
        }else{
            return redirect('forgot-password')->withErrors(['error' => 'Invalid or Expired Link'])->withInput();
        }
    }
    
    
}
