<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rule;
use App\Sro;
use App\Tariff;

class DashboardController extends Controller
{	
	public $successStatus = 200;
	public function rules(Rule $rules){
		$rules=Rule::get();
		return response()->json(['data' => $rules], $this->successStatus);
	}

	public function tariffs(Tariff $tariffs){
		$tariffs=Tariff::get();
		return response()->json(['data' => $tariffs], $this->successStatus);
	}

	public function sros(Sro $sros, Request $request){
		$sros=Sro::get();
		return response()->json(['data' => $sros], $this->successStatus);
	}

}
