<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    public function countryCreate()
    {
        return view('Country-State.country');
    }
    
    public function countryIndex()
    {
        $allData = Country::latest()->get();
        return Response::json([
            'allData' => $allData,
        ]);
    }

    public function countryStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_name' => 'required|max:255',
        ]);
        if($validator->fails())
        {
            return Response::json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $country = new Country();
            $country->country_name = $request->country_name;
            $country->save();
            return Response::json([
                'status' => 200,
                'message' => 'Data Added Successfull',
            ]);
        }
    }

    public function countryEdit($id)
    {
        $editId = Country::findOrFail($id);
        if($editId){
            return Response::json([
                'status' => 200,
                'editId' => $editId,
            ]);
        }else{
            return Response::json([
                'status'=>404,
                'message'=>'Data Not Found'
            ]);
        }
    }

    public function countryUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'country_name' => 'required|max:255',
        ]);
        if($validator->fails())
        {
            return Response::json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $country = Country::findOrFail($id);
            if($country){
                $country->country_name = $request->country_name;
                $country->save();
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

    public function countryDelete($id)
    {
        $deleteId = Country::findOrFail($id);
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
