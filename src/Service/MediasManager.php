<?php

namespace App\Service;

use App\Entity\HeroeBackground;
use App\Entity\Heroes;
use App\Entity\Illustrations;
use App\Entity\Medias;

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
}
