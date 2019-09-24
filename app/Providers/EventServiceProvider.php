<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen(['eloquent.deleting: *', 'eloquent.saving: *'], function($function, $model) {

            if(Session::has('ID')){
                $tableName = json_encode($model[0]->getTable());
                $oldData = json_encode($model[0]->getOriginal());
                $newData = json_encode($model[0]->getAttributes());

                app('App\Http\Controllers\ActivityLogController')->store(Crypt::decryptString(Session::get('ID')),$function,$tableName,$oldData,$newData);
            }
        });
    }
}
