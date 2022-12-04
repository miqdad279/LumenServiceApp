<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Buku;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        /**
         * Register policy
         */

         // Register Buku policy
         Gate::define('read-buku', function ($user) {
            return $user->role == 'editor' || $user->role == 'admin';
         });

         Gate::define('update-buku', function ($user, $buku) {
            if($user->role == 'admin'){
                return true;
            }elseif($user->role == 'editor'){
                return $buku->id == $user->id;
            }else{
                return false;
            }
         });

         Gate::define('read-detail-buku', function($user, $buku) {
            if($user->role = 'admin'){
               return true; 
           } else if ($user->role = 'editor'){
               return $buku->id == $user->id; 
           } else {
               return false; 
           }
       });

       Gate::define('create-buku', function($user, $buku) {
            if($user->role = 'admin'){
               return true; 
           } else if ($user->role = 'editor'){
               return $buku->id == $user->id; 
           } else {
               return false; 
           }
       });

       Gate::define('delete-buku', function($user, $buku) {
           if($user->role = 'admin'){
              return true; 
          } else if ($user->role = 'editor'){
              return $buku->id == $user->id; 
          } else {
              return false; 
          }
      });

         /** Register policy End */

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }
        });
    }
}
