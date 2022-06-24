<?php

namespace App\Http\Controllers;

use App\Models\InfoCollect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class InfoCollectController extends Controller
{
    public function index()
    {
        $infoCollects = InfoCollect::latest()->get();
        return Response::json([
            'infocollects' => $infoCollects,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:info_collects,email',
        ]);
        if($validator->fails())
        {
            return Response::json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $infoCollect = new InfoCollect();
            $infoCollect->name = $request->name;
            $infoCollect->email = $request->email;
            $infoCollect->save();
            return Response::json([
                'status' => 200,
                'message' => 'Data added successfull',
            ]);
        }
    }


    public function edit($id)
    {
        $editId = InfoCollect::findOrFail($id);
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


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
        ]);
        if($validator->fails())
        {
            return Response::json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $infoCollect = InfoCollect::findOrFail($id);
            if($infoCollect){
                $infoCollect->name = $request->name;
                $infoCollect->email = $request->email;
                $infoCollect->save();
                return Response::json([
                    'status' => 200,
                    'message' => 'Data successfully Updated',
                ]);
            }else{
                return Response::json([
                    'status'=>404,
                    'message'=>'Data Not Found'
                ]);
            }
        }
    }

    public function delete($id)
    {
        $deleteId = InfoCollect::findOrFail($id);
        if($deleteId){
            $deleteId->delete();
            return Response::json([
                'status' => 200,
                'message' => 'Data successfully Deleted',
            ]);
        }else{
            return Response::json([
                'status'=>404,
                'message'=>'Data Not Found'
            ]);
        }
    }
}
