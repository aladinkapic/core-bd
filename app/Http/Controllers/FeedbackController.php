<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Models\Sluzbenik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class FeedbackController extends Controller
{
    //

    public function index(Request $request){

        $feedbacks = Feedback::all();

        return view('feedback.index')->with(compact('feedbacks'));

    }

    public function create(Request $request){

        $me = Sluzbenik::where('id', Crypt::decryptString(Session::get('ID')))->with('uloge')->first();

        $feedback = new Feedback();

        $feedback->sluzbenik = $me->id;
        $feedback->komentar = $request->get('komentar');
        $feedback->save();

        return redirect(route('feedback.index'));

    }

    public function delete(Request $request){

        $id = $request->get('id');

        $feed = Feedback::find($id);
        $feed->delete();

        return back();
    }

}
