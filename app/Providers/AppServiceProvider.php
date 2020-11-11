<?php

namespace App\Providers;

use App\Models\Sluzbenik;
use http\Env\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        view()->composer(['template.menu', 'home', 'hr.organizacija.index'], function(View $view) {

            if(Session::has('ID')){
                $me = Sluzbenik::where('id', Crypt::decryptString(Session::get('ID')))->with('uloge')->first();
            } else {
                $me = [];
            }

            $view->with(compact('me'));

        });
    }
}
