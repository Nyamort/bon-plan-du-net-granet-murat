<?php

namespace App\Components;

use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'profilAlert')]
class ProfilAlert
{
    public Collection $alerts;
}
