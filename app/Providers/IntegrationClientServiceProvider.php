<?php

namespace App\Providers;

use App\Integrations\Dojah\DojahClient;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class IntegrationClientServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(DojahClient::class, function () {
            return new DojahClient(
                appId: config('integration-providers.dojah.appId'),
                publicKey: config('integration-providers.dojah.publicKey'),
                privateKey: config('integration-providers.dojah.privateKey'),
                baseUrl: config('integration-providers.dojah.baseUrl'),
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
        ];
    }
}
