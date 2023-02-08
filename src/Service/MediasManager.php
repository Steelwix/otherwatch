<?php

namespace App\Service;

use App\Entity\Abilities;
use App\Entity\HeroeBackground;
use App\Entity\Heroes;
use App\Entity\Illustrations;
use App\Entity\Medias;
use App\Entity\ProfilesPictures;
use App\Entity\SpellsIcons;
use App\Entity\Users;

class MediasManager

{
    public function newIllustration($illustration, Heroes $heroes)
    {


        $medias = $illustration;
        $mediasname = md5(uniqid()) . '.' . $medias->guessExtension();
        $medias->move(
            '../public/uploads/medias',
            $mediasname

        );
        $mds = new Medias();
        $mds->setName($mediasname);
        $heroes->addMedia($mds);
        $illu = new Illustrations();
        $illu->setMedias($mds);
        $heroes->setIllustrations($illu);
    }
    public function newBackground($background, Heroes $heroes)
    {
        $medias = $background;
        $mediasname = md5(uniqid()) . '.' . $medias->guessExtension();
        $medias->move(
            '../public/uploads/medias',
            $mediasname

        );
        $mds = new Medias();
        $mds->setName($mediasname);
        $heroes->addMedia($mds);
        $illu = new HeroeBackground();
        $illu->setMedia($mds);
        $heroes->setHeroeBackground($illu);
    }
    public function newProfilePicture($profilePicture, Users $user)
    {
        $medias = $profilePicture;
        $mediasname = md5(uniqid()) . '.' . $medias->guessExtension();
        $medias->move(
            '../public/uploads/profilePicture',
            $mediasname

        );
        $mds = new ProfilesPictures();
        $mds->setName($mediasname);
        $mds->setUsers($user);
        $user->setProfilesPictures($mds);
    }
    public function newSpellIcon($spellIcon, Abilities $ability)
    {
        $medias = $spellIcon;
        $mediasname = md5(uniqid()) . '.' . $medias->guessExtension();
        $medias->move(
            '../public/uploads/spellsicons',
            $mediasname

        );
        $mds = new SpellsIcons();
        $mds->setName($mediasname);
        $mds->setAbility($ability);
        $ability->setSpellsIcons($mds);
    }
}
