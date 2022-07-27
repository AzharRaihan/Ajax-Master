<?php

namespace App\Http\Controllers;

use App\Models\AjaxCrud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
            'photo' => 'required|mimes:png,jpeg,jpg',
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
            // Get Photo for store
            if($request->hasfile('photo'))
            {
                $file = $request->file('photo');
                $extension = $file->extension();
                $fileName = time() . '.' . $extension;
                $ajaxCrud->photo = $fileName;
            }
            $ajaxCrud->save();
            $file->move('uploads/photo/', $fileName);
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
            'photo' => 'mimes:png,jpeg,jpg',
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
                if ($request->hasfile('photo')) {
                    // Existing Image path
                    $photo_path = public_path('uploads/photo/' . $ajaxCrud->photo);
                    // Delete old thumbnail, If the thumbnail has
                    if (File::exists($photo_path)) {
                        File::delete($photo_path);
                    }
                    // New Gallery Avater store
                    $file = $request->file('photo');
                    $extension = $file->extension();
                    $fileName = time() . '.' . $extension;
                    $file->move('uploads/photo/', $fileName);
                } else {
                    // Old Image store
                    $fileName = $ajaxCrud->photo;
                }
                $ajaxCrud->photo = $fileName;
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
            $photo_path = public_path('uploads/photo/' . $deleteId->photo);
            // Delete old thumbnail, If the thumbnail has
            if (File::exists($photo_path)) {
                File::delete($photo_path);
            }
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
