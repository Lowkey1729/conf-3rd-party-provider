<?php

use App\Enums\ProviderEnum;
use App\Enums\ServiceEnum;
use App\Exceptions\ProviderException;
use App\Models\Provider;
use Illuminate\Support\Facades\Cache;

function getActiveProvider(ServiceEnum $service): ProviderEnum
{
    $key = "default_provider:{$service->name}";
    if (Cache::has($key)) {
        return Cache::get($key);
    }

    $provider = Provider::query()->where('service', $service->name)->first();
    if (! $provider) {
        throw new ProviderException("The specified service provider could not be found or is not configured.");
    }

    $providerEnum = ProviderEnum::from($provider->name);
    Cache::put($key, $providerEnum);

    return $providerEnum;
}

function makeProviderActive(ServiceEnum $service, ProviderEnum $provider): void
{
    Provider::query()->updateOrCreate([
        'service' => $service->name,
    ],[
        'name' => $provider->name,
    ]);
}
