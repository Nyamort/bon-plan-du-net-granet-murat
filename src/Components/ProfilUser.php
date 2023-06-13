<?php

namespace App\Components;

use App\Entity\User;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'profilUser')]
class ProfilUser
{
    public User $user;
    public array $stats;

}
