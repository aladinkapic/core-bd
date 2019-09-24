<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use Illuminate\Http\Request;
use App\Models\Sifrarnik;

class TemeController extends Controller
{
    public function index()    {
        $teme = Tema::all();
        foreach ($teme as $tema){
            $tema->oblast = ( $tema->oblast = Sifrarnik::dajInstancu('oblasti',  $tema->oblast));
        }

        return view('/osposobljavanje_i_usavrsavanje/teme/home', compact('teme'));
    }
    public function create()
    {
        $oblasti = Sifrarnik::dajSifrarnik('oblasti');
        return view('osposobljavanje_i_usavrsavanje/teme/add', compact('oblasti'));
    }
    public function storeTeme(Request $request){

        $pravila = [
            'naziv' => 'required|max:100',
            'oblast' => 'required',
            'napomena' => 'max:1000',
        ];

        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);

        try{
            $tema = Tema::create($request->except(['_method']));
        }catch(\Exception $e){
            return $e->getMessage();
        }

        return redirect('/osposobljavanje_i_usavrsavanje/teme/home')->with('success', __('Uspješno ste unijeli temu za obuku!'));
    }

    public function show($id)
    {
        $tema = Tema::findOrFail($id);
        $tema->oblast = ( $tema->oblast = Sifrarnik::dajInstancu('oblasti',  $tema->oblast));

        return view('/osposobljavanje_i_usavrsavanje/teme/view', compact('tema'));
    }

    public function edit($id)
    {
        $tema = Tema::findOrFail($id);
        $oblasti = Sifrarnik::dajSifrarnik('oblasti');

        return view('/osposobljavanje_i_usavrsavanje/teme/add', compact('tema','oblasti'));
    }
    public function update(Request $request, $id)
    {

        $pravila = [
            'naziv' => 'required|max:100',
            'oblast' => 'required|max:250',
            'napomena' => 'required|max:1000',
        ];

        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);

        $u = Tema::findOrFail($id);

        $u->update($request->all());
        $tema = Tema::findOrFail($id);

        return redirect()
            ->back()
            ->with('success', 'Uspješno ste izmjenili temu za obuku!');

    }

    public function destroy($id)
    {
        $tema = Tema::findOrFail($id);
        $tema -> delete();

        return redirect('/osposobljavanje_i_usavrsavanje/teme/home')->with('success', __('Uspješno ste izbrisali temu za obuku!'));

    }

}
