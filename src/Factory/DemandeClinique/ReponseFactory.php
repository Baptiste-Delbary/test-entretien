<?php

namespace App\Factory\DemandeClinique;

use App\Entity\DemandeClinique\Depot;
use App\Entity\DemandeClinique\Reponse;

class ReponseFactory
{
    /**
     * Crée une réponse
     * @param Depot $depot
     * @param string $titre
     * @param string $description
     * @param int $type
     * @return Reponse
     */
    public function creer(Depot $depot, string $titre, string $description, int $type): Reponse
    {
        return (new Reponse())
            ->setTitre($titre)
            ->setDescription($description)
            ->setDateCreation(new \DateTime())
            ->setDepot($depot)
            ->setType($type)
        ;
    }

    /**
     * Edit une réponse
     * @param Reponse $reponse
     * @param string $titre
     * @param string $description
     * @param int $type
     * @param bool $validate
     * @param string $reason
     * @return Reponse
     */
    public function edit(Reponse $reponse, string $titre, string $description, int $type, bool $validate, string $reason): Reponse
    {
        return $reponse
            ->setTitre($titre)
            ->setDescription($description)
            ->setType($type)
            ->setValidate($validate)
            ->setReason($reason)
        ;
    }
}