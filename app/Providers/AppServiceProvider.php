<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Interfaces\{
    PatientRepositoryInterface,
    LaegemiddelRepositoryInterface,
    PNRepositoryInterface,
    DagligFastRepositoryInterface,
    DagligSkaevRepositoryInterface,
    OrdinationRepositoryInterface,
    DosisRepositoryInterface
};
use App\Repositories\{
    PatientRepository,
    LaegemiddelRepository,
    PNRepository,
    DagligFastRepository,
    DagligSkaevRepository,
    OrdinationRepository,
    DosisRepository
};

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
    $this->app->bind(PatientRepositoryInterface::class, PatientRepository::class);
    $this->app->bind(LaegemiddelRepositoryInterface::class, LaegemiddelRepository::class);
    $this->app->bind(PNRepositoryInterface::class, PNRepository::class);
    $this->app->bind(DagligFastRepositoryInterface::class, DagligFastRepository::class);
    $this->app->bind(DagligSkaevRepositoryInterface::class, DagligSkaevRepository::class);
    $this->app->bind(OrdinationRepositoryInterface::class, OrdinationRepository::class);
    $this->app->bind(DosisRepositoryInterface::class, DosisRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
