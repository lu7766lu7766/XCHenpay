<?php

namespace App\Providers;

use App\Policies\BankCardAccountManagePolicy;
use App\Policies\BankCardListPolicy;
use App\Policies\BindBankCardPolicy;
use App\Policies\CompanyAccountPolicy;
use App\Policies\FeeListPolicy;
use App\Policies\FeeManagementPolicy;
use App\Policies\FillOrderPolicy;
use App\Policies\HeaderInfoPolicy;
use App\Policies\InformationListsPolicy;
use App\Policies\InformationManagePolicy;
use App\Policies\LendListPolicy;
use App\Policies\LendManagePolicy;
use App\Policies\ListenOrderPolicy;
use App\Policies\MerchantsPolicy;
use App\Policies\NotifyOrderFailPolicy;
use App\Policies\OrderNotifyPolicy;
use App\Policies\PaymentManagePolicy;
use App\Policies\PersonalAccountPolicy;
use App\Policies\ReportSearchPolicy;
use App\Policies\ReportStatisticalPolicy;
use App\Policies\TrashedMerchantsPolicy;
use App\Policies\UserManagePolicy;
use App\Policies\UserPaymentAccountPolicy;
use App\Policies\WhiteListPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model'                   => 'App\Policies\ModelPolicy',
        'LendManagePolicy'            => LendManagePolicy::class,
        FillOrderPolicy::class        => FillOrderPolicy::class,
        'FeeManagementPolicy'         => FeeManagementPolicy::class,
        'MerchantsPolicy'             => MerchantsPolicy::class,
        'TrashedMerchantsPolicy'      => TrashedMerchantsPolicy::class,
        'FeeListPolicy'               => FeeListPolicy::class,
        'OrderNotifyPolicy'           => OrderNotifyPolicy::class,
        'NotifyOrderFailPolicy'       => NotifyOrderFailPolicy::class,
        'BindBankCardPolicy'          => BindBankCardPolicy::class,
        'BankCardListPolicy'          => BankCardListPolicy::class,
        'HeaderInfoPolicy'            => HeaderInfoPolicy::class,
        'CompanyAccountPolicy'        => CompanyAccountPolicy::class,
        'InformationListsPolicy'      => InformationListsPolicy::class,
        'InformationManagePolicy'     => InformationManagePolicy::class,
        'PersonalAccountPolicy'       => PersonalAccountPolicy::class,
        'BankCardAccountManagePolicy' => BankCardAccountManagePolicy::class,
        'PaymentManagePolicy'         => PaymentManagePolicy::class,
        'ListenerOrderPolicy'         => ListenOrderPolicy::class,
        WhiteListPolicy::class        => WhiteListPolicy::class,
        UserManagePolicy::class       => UserManagePolicy::class,
        'LendListPolicy'              => LendListPolicy::class,
        'ReportSearchPolicy'          => ReportSearchPolicy::class,
        'ReportStatisticalPolicy'     => ReportStatisticalPolicy::class,
        'UserPaymentAccountPolicy'    => UserPaymentAccountPolicy::class
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
