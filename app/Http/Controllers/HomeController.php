<?php

namespace App\Http\Controllers;

use App\Models\Log;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Imports\ContactImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function upload(Request $request){
        $campos = json_decode($request->campos,true);
        
        $validator = validator( $campos+$request->all(),[
            "name"=>"required",
            "date"=>"required",
            "phone"=>"required",
            "address"=>"required",
            "credit_card"=>"required",
            "franchise"=>"required",
            "email"=>"required",
            "csv_file"=>"required"
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $user = Auth::user();
        Excel::import(new ContactImport($request->campos,$user), $request->file('csv_file'), \Maatwebsite\Excel\Excel::CSV);
    }

    public function contacts(){
        $user = Auth::user();
        $contacts = Contact::where(["user_id"=>$user->id])->get();
        return response()->json($contacts);
    }
    public function fallidos(){
        $user = Auth::user();
        $fallidos = Log::where(["user_id"=>$user->id])->get();
        return response()->json($fallidos);
    }
}
