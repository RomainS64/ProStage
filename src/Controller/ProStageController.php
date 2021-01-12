<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="prostage")
     */
    public function index(): Response
    {
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
        ]);
    }
    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function entreprises()
    {
      return $this->render('pro_stage/entreprises.html.twig', [
          'controller_name' => 'ProStageController',
      ]);
    }
    /**
     * @Route("/formations", name="formations")
     */
    public function formations()
    {

      return $this->render('pro_stage/formations.html.twig', [
          'controller_name' => 'ProStageController',

      ]);
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
