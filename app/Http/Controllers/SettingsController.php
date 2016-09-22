<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Theme;
use APP\Parameter;
use Datatables;
use Auth;
use Validator;
use App\AuditLog;
use Illuminate\Support\Facades\Input;
class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function themes()
    {
        return view('settings.themes');
    }
    public function raterProfile()
    {
        return view('settings.rater');
    } 
    public function raterProfilePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|max:255',
            'newpassword' => 'required|max:255',
            'confirm_newpassword' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect('profile/post')
                ->withErrors($validator)
                ->withInput();
        }

    }
    public function themesbyID($id)
    {
        $group=Theme::find($id);
        return json_encode($group);
    }

    public function parameters()
    {
        $themes=DB::table('themes')->get();
        return view('settings.parameters',compact('themes'));
    }

    public function getParameters()
    {
        $parameters = DB::table('parameters')
            ->join('themes','themes.id','=','parameters.themeID')
        ->select('parameters.*','themes.name as themename');
        $action='<div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">Action <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                             <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-edit" data-id=" {{ $id }}" class="edit">Edit</a></li>
                           </ul>
                        </div>';
        return Datatables::of($parameters)
            ->editColumn('id',"{{ \$id }}")
            ->addColumn('actions',$action)
            ->make(true);
    }
    public function getThemes()
    {
        $themes = Theme::all();
        $action='<div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">Action <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                             <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-edit" data-id=" {{ $id }}" class="edit">Edit</a></li>
                           </ul>
                        </div>';
        return Datatables::of($themes)
            ->editColumn('id',"{{ \$id }}")
            ->addColumn('actions',$action)
            ->make(true);
    }
    public function saveThemes(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:themes|max:255',
        ]);
        $film = new Theme();
        $film->name = $request->input('name');
        $film->description = $request->input('description');
        $film->createdby = Auth::User()->id;
        $film->save();

        $logs=new AuditLog();
        $logs->username =Auth::User()->username;
        $logs->activity ="Create Theme <code>:".$request->input('name')."</code>";
        $logs->status ="1";
        $logs->userID =Auth::User()->id;
        $logs->save();


        return response()->json([
            'success'=>false,
            'status'=>'00',
            'message' =>'<code>'. Input::get('name').'</code>'.' Created Successfully'
        ]);


    }
    public function updateThemes(Request $request,$id)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        $film =Theme::findOrFail($id);
        $film->name = $request->input('name');
        $film->description = $request->input('description');
        $film->createdby = Auth::User()->id;
        $film->save();

        $logs=new AuditLog();
        $logs->username =Auth::User()->username;
        $logs->activity ="Update Theme <code>:".$request->input('name')."</code>";
        $logs->status ="1";
        $logs->userID =Auth::User()->id;
        $logs->save();


        return response()->json([
            'success'=>false,
            'status'=>'00',
            'message' =>'<code>'. Input::get('name').'</code>'.' Updated Successfully'
        ]);


    }
}
