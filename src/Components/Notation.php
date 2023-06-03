<?php

namespace App\Components;

use App\Entity\Publication;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'notation')]
class Notation
{
    public Publication $publication;
}
