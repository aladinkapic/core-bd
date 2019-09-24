<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Models\DisciplinskaOdgovornost;
use Carbon\Carbon;

class ObavijestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = App\myNotifications::where('notifiable_type', '=', 'App\Models\Sluzbenik')->with('sluzbenik')->orderBy('read_at', 'asc')->paginate(10);


        foreach ($notifications as $notification) {
            $notification->what = json_decode($notification->data, true)['what'];
            if ($notification->what === 'penzionisanje') {
                $notification->what = 'Penzionisanje';
            } else if ($notification->what === 'zasnivanjeRO') {
                $notification->what = 'Zasnivanje radnog odnosa';
            } else if ($notification->what === 'disciplinska') {
                $notification->what = 'Disciplinska odgovornost';
            } else if ($notification->what === 'starosna_dob') {
                $notification->what = 'Starosna dob';
            }


            $notification->property_id = json_decode($notification->data, true)['property_id'];
            $notification->message = json_decode($notification->data, true)['poruka'];
            $notification->sluzbenik = $notification->sluzbenik->id . ' ' . $notification->sluzbenik->ime . ' ' . $notification->sluzbenik->prezime;
            if ($notification->read_at == null) {
                $notification->class = "class=table-info";
            } else {
                $notification->class = null;
            }
            unset($notification->data);

        }


        return view('obavijesti/home', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajaxRead(Request $request)
    {
        $notification = App\myNotifications::where('id', '=', $request->id)->get();
        $string = Carbon::now()->roundMillisecond()->format('Y-m-d H:i:s.u');
        $string = substr($string, 0, -3);
        App\myNotifications::where('id', '=', $request->id)->update(['read_at'=>$string]);
        //dd($notification, $string);
    }

}
