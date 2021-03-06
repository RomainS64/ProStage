<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Form\EntrepriseType;

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
     * @Route("/entreprise", name="entreprises")
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
     * @Route("/formation/{nom}/stages", name="prostages_formations_stage")
     */
    public function getByFormation($nom) // La vue affichera la liste des stages proposés pour une formation
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
        $stages = $repositoryStage->findStageParFormation($nom);
        return $this->render('pro_stage/index.html.twig', [ 'stages' => $stages , 'nom' => $nom]);

    }
    /**
     * @Route("/entreprise/{nom}/stages", name="prostages_entreprises_stage")
     */
    public function getByEntreprise($nom) // La vue affichera la liste des stages proposés par une entreprise
    {
      $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
      $stages = $repositoryStage->findStageParEntreprise($nom);
      return $this->render('pro_stage/index.html.twig', [ 'stages' => $stages, 'nom' => $nom ]);
          }
    /**
     * @Route("/stages/{id}", name="stage")
     */
    public function stages(Stage $stage): Response
    {
      return $this->render('pro_stage/stages.html.twig', ['stage' => $stage]);
    }

    /**
     * @Route("/creer-entreprise", name="nouvelle_entreprise")
     */
    public function nouvelleEntreprise(Request $request)
    {
        $entreprise = new Entreprise();

        $form = $this -> CreateForm(EntrepriseType::class,$entreprise);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entreprise);
            $entityManager->flush();

            return $this->redirectToRoute('http://127.0.0.1:8000/');
       }

        return $this->render('pro_stage/creationEntreprise.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modifier-entreprise/{nom}", name="modifier_entreprise")
     */
    public function edit(Request $request, Entreprise $entreprise)
    {
        $form = $this -> CreateForm(EntrepriseType::class, $entreprise);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entreprise);
            $entityManager->flush();

            return $this->redirectToRoute('http://127.0.0.1:8000/Entreprises');
       }

        return $this->render('pro_stage/modifierEntreprise.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
   * @Route("/creer-stage", name="prostages_nouveau_stage")
   */
   public function newStage(Request $request)
     {
         $stage = new Stage();

         $form = $this -> createFormBuilder($stage)
                         -> add('intitule')
                         -> add('description')
                         -> add('dateDebut')
                         -> add('duree')
                         -> add('competencesRequises')
                         -> add('experienceRequise')
                         -> add('entreprise',EntrepriseType::class)
                         ->add('formation',EntityType::class,
                         ['class'=>Formation::class,
                         'choice_label'=>'intitule',
                         'multiple'=>true,
                         'expanded'=>true])
                         ->getForm();

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($stage);
             $entityManager->flush();

             return $this->redirectToRoute('accueil');
        }

         return $this->render('pro_stage/creationStage.html.twig', [
             'form' => $form->createView(),
         ]);
     }
}
