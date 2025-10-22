<?php

use App\Enums\ProviderEnum;
use App\Enums\ServiceEnum;

function getActiveProvider(ServiceEnum $service): ProviderEnum
{
    return ProviderEnum::QORE_ID;
}
