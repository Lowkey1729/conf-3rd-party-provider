<?php

namespace App\Providers;

use App\Integrations\Dojah\DojahClient;
use App\Integrations\QoreId\QoreIdClient;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class IntegrationClientServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(DojahClient::class, function () {
            return new DojahClient(
                appId: config('integrations.dojah.appId'),
                publicKey: config('integrations.dojah.publicKey'),
                privateKey: config('integrations.dojah.privateKey'),
                baseUrl: config('integrations.dojah.baseUrl'),
            );
        });

        $this->app->singleton(QoreIdClient::class, function () {
            return new QoreIdClient(
                baseUrl: config('integrations.qoreId.baseUrl'),
                clientId: config('integrations.qoreId.clientId'),
                secretKey: config('integrations.qoreId.secretKey'),
            );
        });
    }

    /**
     * @return array<int, mixed>
     */
    public function provides(): array
    {
        return [
            DojahClient::class,
            QoreIdClient::class,
        ];
    }
}
