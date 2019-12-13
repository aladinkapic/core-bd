<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uprava;
use App\Models\Sifrarnik;

class UpravaController extends Controller{
    public function __construct(){
        $this->middleware('role:organ_ju');
    }


    public function index()    {
        $uprave = Uprava::with('tip_javne_uprave');
        $uprave = FilterController::filter($uprave);

        $filteri = [
            'naziv' => 'Naziv',
            'tip_javne_uprave.name' => 'Tip',
            'ulica' => 'Ulica',
            'broj' => 'Broj',
            'telefon' => 'Telefon',
            'fax' => 'Fax',
            'web' => 'Web',
        ];

        return view('/hr/organ_javne_uprave/home', compact('uprave', 'filteri'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipovi = Sifrarnik::dajSifrarnik('tip_javne_uprave');
        return view('hr/organ_javne_uprave/add', compact('tipovi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeUprava(Request $request){

        $pravila = [
            'naziv' => 'required|max:255',
            'tip' => 'required|max:50',
            'ulica' => 'required|max:20',

        ];

        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);

        try{
            $uprava = Uprava::create($request->except(['_method']));
        }catch(\Exception $e){
            return $e->getMessage();
        }

        return redirect('/hr/organ_javne_uprave/home')->with('success', __('Uspješno ste dodali upravu!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipovi = Sifrarnik::dajSifrarnik('tip_javne_uprave');
        $uprava = Uprava::findOrFail($id);
        return view('/hr/organ_javne_uprave/view', compact('uprava', 'tipovi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $uprava = Uprava::findOrFail($id);
        $tipovi = Sifrarnik::dajSifrarnik('tip_javne_uprave');

        return view('/hr/organ_javne_uprave/add', compact('uprava','tipovi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $pravila = [
            'naziv' => 'required|max:255',
            'tip' => 'required|max:50',
            'ulica' => 'max:20',

        ];

        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);

        $u = Uprava::findOrFail($id);

        $u->update($request->all());
        $uprava = Uprava::findOrFail($id);
        $tipovi = Sifrarnik::dajSifrarnik('tip_javne_uprave');

        return redirect()
            ->back()
            ->with('success', 'Uspješno ste izmjenili upravu!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $uprava = Uprava::findOrFail($id);
        $uprava -> delete();

        return redirect('/hr/organ_javne_uprave/home')->with('success', __('Uspješno ste izbrisali upravu!'));

    }
}