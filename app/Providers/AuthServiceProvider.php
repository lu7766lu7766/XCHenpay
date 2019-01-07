<?php

namespace App\Providers;

use App\Policies\CallNotifyPolicy;
use App\Policies\FeeManagementPolicy;
use App\Policies\FillOrderPolicy;
use App\Policies\LendManagePolicy;
use App\Policies\MerchantsPolicy;
use App\Policies\TrashedMerchantsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model'              => 'App\Policies\ModelPolicy',
        'LendManagePolicy'       => LendManagePolicy::class,
        FillOrderPolicy::class   => FillOrderPolicy::class,
        'FeeManagementPolicy'    => FeeManagementPolicy::class,
        'MerchantsPolicy'        => MerchantsPolicy::class,
        'TrashedMerchantsPolicy' => TrashedMerchantsPolicy::class,
        'CallNotifyPolicy'       => CallNotifyPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //
    }
}
