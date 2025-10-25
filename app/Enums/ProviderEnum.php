<?php

namespace App\Enums;

enum ProviderEnum: string
{
    case QORE_ID = "QORE_ID";

    case DOJAH = "DOJAH";

    case MOCK = "MOCK";

    case INVALID = "INVALID";
}
