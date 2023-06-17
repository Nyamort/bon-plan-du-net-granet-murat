<?php

namespace App\Components;

use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'profilAlertPublication')]
class ProfilAlertPublication
{
    public Collection $publications;
}
