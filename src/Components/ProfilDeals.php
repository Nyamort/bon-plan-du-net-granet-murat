<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'profilDeals')]
class ProfilDeals
{
    public array $deals;
}
