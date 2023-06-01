<?php

namespace App\Components;

use App\Entity\CodePromo;
use App\Entity\Deal;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use App\Entity\Publication as PublicationEntity;

#[AsTwigComponent(name: 'publication')]
class Publication
{
    public PublicationEntity $publication;
    public bool $isDeal;
    public bool $isCodePromo;

    public function mount(PublicationEntity $publication): void
    {
        $this->publication = $publication;
        $this->isDeal = $publication->getDeal() instanceof Deal;
        $this->isCodePromo = $publication->getCodePromo() instanceof CodePromo;
    }

}
