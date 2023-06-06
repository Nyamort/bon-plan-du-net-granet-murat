<?php

namespace App\Components;

use App\Entity\CodePromo;
use App\Entity\Commentaire;
use App\Entity\Deal;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use App\Entity\Publication as PublicationEntity;

#[AsTwigComponent(name: 'comment')]
class Comment
{
    public Commentaire $commentaire;

}
