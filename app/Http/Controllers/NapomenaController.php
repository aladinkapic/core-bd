<?php

namespace App\Http\Controllers;

use App\Models\Napomena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class NapomenaController extends Controller
{
    public function submit(Request $request){
        $pravila = [
            'napomena' => 'required|max:999',

        ];

        try{
            $poruke = HelpController::getValidationMessages();

            $napomena = new Napomena();
            $request->request->add(['user_id' => Crypt::decryptString(Session::get('ID'))]);
            $napomena->napomena = $request->napomena_;
            $napomena->user_id = $request->user_id;
            $napomena->save();
        }catch (\Exception $e){
            dd($e);
        }
    }

    public function index(){
        return Napomena::where('user_id', Crypt::decryptString(Session::get('ID')))->get()->toJson();
    }

    public function delete($id){
        $napomena = Napomena::findOrFail($id);
        $napomena -> delete();
    }

    public function no(){
        $count = Napomena::all();
        return $count->count();
    }
}
