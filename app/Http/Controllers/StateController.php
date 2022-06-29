<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    public function stateCreate()
    {
        return view('Country-State.state');
    }
    
    public function stateIndex()
    {
        $allData = State::with('country')->latest()->get();
        return Response::json([
            'allData' => $allData,
        ]);
    }


    public function countryGet()
    {
        $country = Country::latest()->get();
        return Response::json([
            'country' => $country,
        ]);
    }

    public function stateStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'statename' => 'required|max:255',
            'countryname' => 'required',
        ]);
        if($validator->fails())
        {
            return Response::json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $state = new State();
            $state->country_id = $request->countryname;
            $state->state_name = $request->statename;
            $state->save();
            return Response::json([
                'status' => 200,
                'message' => 'Data Added Successfull',
            ]);
        }
    }

    public function stateEdit($id)
    {
        $country = Country::latest()->get();
        $editId = State::findOrFail($id);
        if($editId){
            return Response::json([
                'status' => 200,
                'editId' => $editId,
                'country' => $country,
            ]);
        }else{
            return Response::json([
                'status'=>404,
                'message'=>'Data Not Found'
            ]);
        }
    }

    public function stateUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'state_name' => 'required|max:255',
            'upcountryname' => 'required|max:255',
        ]);
        if($validator->fails())
        {
            return Response::json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $state = State::findOrFail($id);
            if($state){
                $state->state_name = $request->state_name;            
                $state->country_id = $request->upcountryname;
                $state->save();
                return Response::json([
                    'status' => 200,
                    'message' => 'Data Successfully Updated',
                ]);
            }else{
                return Response::json([
                    'status'=>404,
                    'message'=>'Data Not Found'
                ]);
            }
        }
    }

    public function stateDelete($id)
    {
        $deleteId = State::findOrFail($id);
        if($deleteId){
            $deleteId->delete();
            return Response::json([
                'status' => 200,
                'message' => 'Data Successfully Deleted',
            ]);
        }else{
            return Response::json([
                'status'=>404,
                'message'=>'Data Not Found'
            ]);
        }
    }
}
