<?php

namespace App\Components;

use App\Entity\User;
use Symfony\Component\Form\FormView;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'profilSetting')]
class ProfilSetting
{
    public FormView $form;
    public User $user;
}
