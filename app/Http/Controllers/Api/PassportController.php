<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\User;
use App\Rule;
use App\Sro;
use App\Tariff;
use Carbon\Carbon;

class PassportController extends Controller
{
	public $successStatus = 200;



   /**
 
    * login api
 
    *
 
    * @return \Illuminate\Http\Response
 
    */

   public function login(){

   	if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){

   		$user = Auth::user();

   		$success['token'] =  $user->createToken('MyApp')->accessToken;

   		return response()->json(['success' => $success], $this->successStatus);

   	}

   	else{

   		return response()->json(['error'=>'Unauthorised'], 401);

   	}

   }



   /**
 
    * Register api
 
    *
 
    * @return \Illuminate\Http\Response
 
    */

   public function register(Request $request)

   {

   	$validator = Validator::make($request->all(), [

   		'name' => 'required',

   		'email' => 'required|email',

   		'password' => 'required',

   		'c_password' => 'required|same:password',

   	]);



   	if ($validator->fails()) {

   		return response()->json(['error'=>$validator->errors()], 401);            

   	}



   	$input = $request->all();

   	$input['password'] = bcrypt($input['password']);

   	$user = User::create($input);

   	$success['token'] =  $user->createToken('MyApp')->accessToken;

   	$success['name'] =  $user->name;



   	return response()->json(['success'=>$success], $this->successStatus);

   }



   /**
 
    * details api
 
    *
 
    * @return \Illuminate\Http\Response
 
    */

   public function getDetails(){
   	$user = Auth::user();
   	return response()->json(['success' => $user], $this->successStatus);
   }

   public function rules(Rule $rules){
   	$rules=Rule::paginate(10);
   	return response()->json(['data' => $rules], $this->successStatus);
   }

   public function tariffs(Tariff $tariffs){
   	$tariffs=Tariff::paginate(10);
   	return response()->json(['data' => $tariffs], $this->successStatus);
   }

   public function sros(Sro $sros, Request $request){
   	$sros=Sro::paginate(10);
   	return response()->json(['data' => $sros], $this->successStatus);
   }

   public function postsros(Sro $sros, Request $request){

   	$inputs=$request->all();
   	$sro = $sros->newQuery();

   	if ($request->has('date')){
   		$sro->where('date','like', '%' .$inputs['date']. '%')->get();
   	}
   	if ($request->has('description')){
   		$sro->where('description','like', '%' .$inputs['description'].'%')->get();
   	}
   	if ($request->has('sro_no')){
   		$sro->where('sro_no', 'like', '%' .$inputs['sro_no']. '%')->get();
   	}
   	$sros=$sro->paginate(10);
   	return response()->json(['data' => $sros], $this->successStatus);
   }

   public function srosByYear(Sro $sros, $year){
   	$sros=Sro::where('date','like', '%' .$year. '%')->paginate(10);
   	return response()->json(['data' => $sros], $this->successStatus);
   }

   public function srosYearlist(Sro $sros){
   	$sros=Sro::selectRaw('substr(date,1,4) as date')->pluck('date')->unique();
   	return response()->json(['data' => $sros], $this->successStatus);
   }

}
