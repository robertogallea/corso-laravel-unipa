<?php

namespace App\Providers;

use App\Events\ExpensiveProductCreated;
use App\Http\Controllers\Api\V1\UserController;
use App\Models\Product;
use App\Models\User;
use App\Services\AnotherService;
use App\Services\CachedGithubUserService;
use App\Services\GithubUserService;
use App\Services\RandomService;
use App\Services\TestService;
use App\Services\UserServiceInterface;
use Illuminate\Auth\Access\Response;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Foundation\Application;
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

        $this->app->singleton(RandomService::class, function () {
            return new RandomService();
        });

        $this->app->singleton(AnotherService::class, function ($app) {
            return new AnotherService($app->make(TestService::class));
        });

        // singletonIf registra un singleton se non è già stato registrato
//        $this->app->singletonIf(AnotherService::class, function ($app) {
//            return new AnotherService($app->make(TestService::class));
//        });

        $this->app->bind(
            UserServiceInterface::class,
            CachedGithubUserService::class
        );

//        $this->app->instance(
//            CachedGithubUserService::class,
//            new CachedGithubUserService(app(GithubUserService::class), 10)
//        );

        $this->app->when(CachedGithubUserService::class)
            ->needs('$ttl')
            ->giveConfig('custom.cache-ttl');


        // contextual binding
//        $this->app->when(UserController::class)
//            ->needs(UserServiceInterface::class)
//            ->give(GithubUserService::class);



//        $this->app->bind(
//            UserServiceInterface::class,
//            function (Application $app) {
//                if ($app->runningUnitTests()) {
//                    return new DummyUserService();
//                }
//
//                return $app->make(GithubUserService::class);
//            }
//        );


        \RateLimiter::for('api-job', function (object $job) {
//            return $job->user->plan->isPremium() ?
//                Limit::none() :
//                Limit::perMinute(30)->by($job->user->id);

            return Limit::perMinute(30);
        });
    }

}
