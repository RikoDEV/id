<?php

namespace RikoDEV\Id;

use SocialiteProviders\Manager\SocialiteWasCalled;

class RikoExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled): void
    {
        $socialiteWasCalled->extendSocialite('rikoid', Provider::class);
    }
}
