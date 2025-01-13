<?php

namespace App\Providers;


use App\Repositories\ApplicationContext;
use App\Repositories\ApplicationRepository;
use App\Repositories\ClientRepository;
use App\Repositories\EvenementRepository;
use App\Repositories\FactureRepository;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\IApplicationContext;
use App\Repositories\Interfaces\IClient;
use App\Repositories\Interfaces\IEvenement;
use App\Repositories\Interfaces\IFacture;
use App\Repositories\Interfaces\IPoney;
use App\Repositories\Interfaces\IStatus;
use App\Repositories\PoneyRepository;
use App\Repositories\Repository;
use App\Repositories\StatusRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Injection of dependency
        $this->app->bind(IApplicationContext::class, ApplicationContext::class);
        $this->app->bind(IPoney::class, PoneyRepository::class);
        $this->app->bind(IClient::class, ClientRepository::class);
        $this->app->bind(IEvenement::class,EvenementRepository::class);
        $this->app->bind(IFacture::class,FactureRepository::class);
        $this->app->bind(IStatus::class,StatusRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        Paginator::useBootstrap();
    }
}
