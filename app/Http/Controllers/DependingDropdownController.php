<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DependingDropdownController extends Controller
{
    public function dependingDropdown()
    {
        return view('Country-State.dropdown');
    }
    public function dCountry()
    {
        $country = Country::latest()->get();
        return Response::json([
            'status' => 200,
            'country' => $country,
        ]);
    }
    public function dState($id)
    {
        $state = State::where('country_id', $id)->get();
        if($state){
            return Response::json([
                'status' => 200,
                'state' => $state,
            ]);
        }else{
            return Response::json([
                'status' => 404,
                'message' => 'State Not Available',
            ]);
        }
        
    }
}
