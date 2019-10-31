<?php

namespace App\Http\Controllers;

use App\Models\OrganizacionaJedinica;
use App\Models\RadnoMjesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

class OrganizacionaJedinicaController extends Controller
{
    //

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
           'naziv' => 'required|max:255',
           'opis' => 'required',
           'tip' => 'required',
        ]);

        if($validator->fails()){
            return redirect(route('organizacija.edit', ['id' => $request->get('org_id')]))->withErrors($validator);
        }

        $jedinica = new OrganizacionaJedinica();

        $jedinica->broj = $request->get('broj');
        $jedinica->naziv = $request->get('naziv');
        $jedinica->opis = $request->get('opis');
        $jedinica->tip = $request->get('tip');
        $jedinica->parent_id = $request->get('parent');
        $jedinica->org_id = $request->get('org_id');

        $jedinica->save();

        $request->session()->flash('status', 'Task was successful!');

        return redirect(route('organizacija.edit', ['id' => $request->get('org_id')]));

    }

    public function edit(Request $request){
        $validator = Validator::make($request->all(), [
            'naziv' => 'required|max:255',
            'opis' => 'required',
            'tip' => 'required',
        ]);

        if($validator->fails()){
            return redirect(route('organizaciona.jedinica.edit', ['id' => $request->get('id')]))->withErrors($validator);
        }

        try{
            $jedinica = OrganizacionaJedinica::where('id', $request->id)->firstOrFail()->update([
                'broj'       => $request->broj,
                'naziv'      => $request->naziv,
                'opis'       => $request->opis,
                'tip'        => $request->tip,
                'parent_id'  => $request->parent
            ]);

            $jedinica = OrganizacionaJedinica::where('id', $request->id)->firstOrFail();
        }catch (\Exception $e){
            dd($e);
        }
        //$jedinica = OrganizacionaJedinica::findOrFail($request->get('id'));



//        dd($jedinica);
//
//        $jedinica->broj = $request->get('broj');
//        $jedinica->naziv = $request->get('naziv');
//        $jedinica->opis = $request->get('opis');
//        $jedinica->tip = $request->get('tip');
//        $jedinica->parent_id = $request->get('parent');
//
//        $jedinica->update();

        $request->session()->flash('message', 'Izmjene su uspješno spašene!');

        return redirect(route('organizacija.edit', ['id' => $jedinica->org_id]));
    }

    public function delete(Request $request){
        $org_jed = OrganizacionaJedinica::find($request->get('id'));

        RadnoMjesto::where('id_oj', '=', $org_jed->id)->delete();

        $org_jed->delete();

        $request->session()->flash('message', 'Uspješno obrisano!');

        return redirect(route('organizacija.edit', ['id' => $request->get('org')]));
    }

    public function getOrgBroj(Request $request){

        $id = $request->get('id');

        $novi_broj = OrganizacionaJedinica::select('broj')
            ->where('id', '=', $id)
            ->first();

        return $novi_broj->broj . ".1";
    }
}
