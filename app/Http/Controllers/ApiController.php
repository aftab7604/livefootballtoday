<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Api;
use Session;
class ApiController extends Controller
{
    public function save(Request $request){
		$token = $request->post('token');
		Session::put("fcm_token",$token);
        if(!empty($token)) {
			$data = ['token'=>$token];
            if(Api::create($data)){
				return response()->json(['success'=>true,'status'=>200,'message'=>'data saved successful'],200);
			}else{
				return response()->json(['success'=>false,'status'=>201,'message'=>'Error in saving data'],201);
			}
        } else {
            return response()->json(['success'=>false,'status'=>201,'message'=>'Invalid Argument'],201);
        }
	}
}
