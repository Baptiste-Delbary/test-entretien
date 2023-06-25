<?php

namespace App\Api\v1\Controller\DemandeClinique;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\DemandeClinique\Reponse;
use App\Manager\DemandeClinique\ReponseManager;


/**
 * @Route("/demande-clinique")
 */
class ReponsesController extends AbstractController
{
    /** @var ReponseManager */
    private $reponseManager;

    public function __construct(ReponseManager $reponseManager)
    {
        $this->reponseManager = $reponseManager;
    }

    /**
     * @Route("/reponses/{id}", name="api_v1_depots_edit_reponse", methods={"PUT"})
     * @param Request $request
     * @param Reponse $reponse
     * @return JsonResponse
     */
    public function edit(Request $request, Reponse $reponse): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $this->reponseManager->edit($reponse, $data['titre'], $data['description'], (int) $data['type'], filter_var($data['validate'], FILTER_VALIDATE_BOOLEAN), $data['reason']);

        return $this->json([], Response::HTTP_OK);
    }
}