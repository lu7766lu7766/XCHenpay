<?php

namespace App\Providers;

use App\Policies\FeeListPolicy;
use App\Policies\FeeManagementPolicy;
use App\Policies\FillOrderPolicy;
use App\Policies\LendManagePolicy;
use App\Policies\MerchantsPolicy;
use App\Policies\OrderNotifyPolicy;
use App\Policies\NotifyOrderFailPolicy;
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
        'FeeListPolicy'          => FeeListPolicy::class,
        'OrderNotifyPolicy'      => OrderNotifyPolicy::class,
        'NotifyOrderFailPolicy'  => NotifyOrderFailPolicy::class,
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
