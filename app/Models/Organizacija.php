<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Organ;
use Illuminate\Support\Facades\DB;

class Organizacija extends Model{

    public $table = 'organizacija';
    protected $guarded = ['id'];

    public function organ(){
        return $organ = $this->hasOne(Organ::class, 'id', 'oju_id');
    }

    public static function copy($id, $new_id){

        $nova_org = Organizacija::find($new_id);




        $org_jedinice = OrganizacionaJedinica::where('org_id', '=', $id)->orderBy('broj')->get();

        /*
         * Kopiranje organizacionih jedinica
         */

        $org_jedinice_ids = [];

        foreach($org_jedinice as $key => $object){

            $org_jedinice_ids[] = $object->id;

            $copy = $object->replicate();
            $copy->before_id = $object->id;
            $copy->org_id = $nova_org->id;

            if($copy->parent_id != null){

                try{
                    $parent_new = OrganizacionaJedinica::select('id')->where('before_id', '=', $copy->parent_id)->firstOrFail();
                    $copy->parent_id = $parent_new->id;
                }catch (\Exception $e){}

            }
            $copy->save();
        }


        /*
         * Kopiranje radnih mjesta
         */

        $radna_mjesta = RadnoMjesto::whereIn('id_oj', $org_jedinice_ids)->get();



        foreach($radna_mjesta as $k => $mjesto){

            $copy_mjesto = $mjesto->replicate();
            $copy_mjesto->id_oj = OrganizacionaJedinica::where('before_id', '=', $mjesto->id_oj)->orderBy('id', 'DESC')->first()->id;
            $copy_mjesto->before_id = $mjesto->id;
            $copy_mjesto->save();

            $sluzbenik = Sluzbenik::where('radno_mjesto', '=', $mjesto->id)->get();

            foreach($sluzbenik as $object){
                $object->radno_mjesto_temp = $copy_mjesto->id;
                $object->save();
            }


            /*
             * Kopiranje uslova za radno mjesto
             */

            $uslovi = DB::table('radno_mjesto_uslovi')->where('id_rm', '=', $mjesto->id)->get();

            foreach($uslovi as $uslov){
                $uslov_raw = json_decode(json_encode($uslov), true);
                unset($uslov_raw['id']);
                DB::table('radno_mjesto_uslovi')->insert($uslov_raw);
            }

        }

        return true;

    }

    public static function brisanje($org_id){

        Organizacija::where('id', '=', $org_id)->delete();

         OrganizacionaJedinica::where('org_id', '=', $org_id)->delete();

         RadnoMjesto::join('org_jedinica', 'radna_mjesta.id_oj', '=', 'org_jedinica.id')
            ->where('org_jedinica.org_id', '=', $org_id)
            ->delete();


    }

    public function organizacioneJedinice(){
        return $this->hasMany('App\Models\OrganizacionaJedinica', 'org_id');
    }

    public function aktivan(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'active')->where('type', 'aktivan');
    }
}
