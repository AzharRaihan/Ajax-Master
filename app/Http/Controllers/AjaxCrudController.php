<?php

namespace App\Http\Controllers;

use App\Models\AjaxCrud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AjaxCrudController extends Controller
{
    public function crudCreate()
    {
        return view('Ajax-Crud.index');
    }
    
    public function crudIndex()
    {
        $allData = AjaxCrud::latest()->get();
        return Response::json([
            'allData' => $allData,
        ]);
    }

    public function crudStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:ajax_cruds,email',
        ]);
        if($validator->fails())
        {
            return Response::json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $ajaxCrud = new AjaxCrud();
            $ajaxCrud->name = $request->name;
            $ajaxCrud->email = $request->email;
            $ajaxCrud->save();
            return Response::json([
                'status' => 200,
                'message' => 'Data Added Successfull',
            ]);
        }
    }


    public function crudEdit($id)
    {
        $editId = AjaxCrud::findOrFail($id);
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


    public function crudUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required',
        ]);
        if($validator->fails())
        {
            return Response::json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $ajaxCrud = AjaxCrud::findOrFail($id);
            if($ajaxCrud){
                $ajaxCrud->name = $request->name;
                $ajaxCrud->email = $request->email;
                $ajaxCrud->save();
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

    public function crudDelete($id)
    {
        $deleteId = AjaxCrud::findOrFail($id);
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
