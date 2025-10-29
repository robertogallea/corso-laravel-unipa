<?php

namespace App\Providers;

use App\Events\ExpensiveProductCreated;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        Gate::before(function ($user, $ability) {
           if ($user->isAdmin()) {
               return true;
           }

           return null; // sospendo il giudizio e lo delego al Gate vero e proprio
        });

//        Gate::define('edit-product', function (?User $user, $product) {
//            return $product->price <= 500 ?
//                Response::allow() :
//                Response::denyAsNotFound();
//        });

        Gate::define('test', function (?User $user, $product) {
            return false;
        });

        // viene eseguito dopo il Gate vero e proprio
        Gate::after(function ($user, $ability) {
            return null;
        });

//        Ordine di valutazione
        // Gate::before()
        // Policy::before()
        // Gate | Policy (ability)
        // Policy::after()
        // Gate::after()

//        DB::listen(function ($query) {
//            dump($query->sql, $query->bindings);
//        });

        // lancia un'eccezione se viene rilevato un lazy loading
//        Model::preventLazyLoading(!$this->app->isProduction())

        // applica l'eager loading al livello globale
//        Model::automaticallyEagerLoadRelationships();

        Relation::morphMap([
            'user' => User::class,
            'product' => Product::class,
        ]);

        Collection::macro('timesIndex', function () {
            return $this->map(function (int $value, int $index) {
                return $value * $index;
            });
        });

//        Paginator::useBootstrapFive();  // three or four
//        Paginator::Tailwind(); //default

        // Listener registrato manualmente
//        \Event::listen(
//            NomeEvento::class,
//            NomeListener::class,
//        );

        // Listener anonimo
        \Event::listen(function (ExpensiveProductCreated $event) {
            logger()->info("Prodotto costoso " . $event->product->price);
        });
    }
}
