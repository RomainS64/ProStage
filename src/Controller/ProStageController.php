<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="prostage")
     */
    public function index(): Response
    {
      $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
      $stages = $repositoryStage->findall();

      return $this->render('pro_stage/index.html.twig',['stages' => $stages]);
    }
    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function entreprises()
    {
      $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

      $entreprises = $repositoryEntreprise->findall();

		  return $this->render('pro_stage/entreprises.html.twig', ['entreprises' => $entreprises]);
    }
    /**
     * @Route("/formations", name="formations")
     */
    public function formations()
    {
      $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

    $formations = $repositoryFormation->findall();

		return $this->render('pro_stage/formations.html.twig', ['formations' => $formations]);
    }
    /**
     * @Route("/formation/{id}/stages", name="prostages_formations_stage")
     */
    public function getByFormation(Formation $stages) // La vue affichera la liste des stages proposés pour une formation
    {
        // Envoyer les ressources récupérées à la vue chargée de les afficher
        return $this->render('pro_stage/index.html.twig', [ 'stages' => $stages->getStages() ]);
    }
    /**
     * @Route("/entreprise/{id}/stages", name="prostages_entreprises_stage")
     */
    public function getByEntreprise(Entreprise $stages) // La vue affichera la liste des stages proposés par une entreprise
    {
        // Envoyer les ressources récupérées à la vue chargée de les afficher
        return $this->render('pro_stage/index.html.twig', [ 'stages' => $stages->getStages() ]);
    }
    /**
     * @Route("/stages/{id}", name="stage")
     */
    public function stages($id)
    {

      return $this->render('pro_stage/stages.html.twig', [
          'controller_name' => 'ProStageController',
          'id' => $id
      ]);
    }
}
