<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
      $error = $authenticationUtils->getLastAuthenticationError();

      $lastusername = $authenticationUtils->getLastUsername();

      return $this->render('security/login.html.twig', [
            'last_username' => $lastusername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }


    /**
    * @Route("/inscription", name="security_inscription")
    */
   public function inscription(Request $request, UserPasswordEncoderInterface $encoder)
   {
       //Créer un utilisateur vide
       $utilisateur = new User();

       //Création du formulaire permettant de saisir un utilisateur
       $form = $this -> createForm(UserType::class,$utilisateur);

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
         // Attribuer un rôle à l'utilisateur
          $utilisateur->setRoles(['ROLE_USER']);

          // Encoder le mot de passe de l'utilisateur
          $encodagePassword = $encoder->encodePassword($utilisateur,$utilisateur->getPassword());
          $utilisateur->setPassword($encodagePassword);


          $entityManager = $this->getDoctrine()->getManager();
          //Enregistrer l'utilisateur en base de données
          $entityManager->persist($utilisateur);
          $entityManager->flush();

          return $this->redirectToRoute('security_login');
      }

      //Affiche la page présentant le formulaire d'inscription
       return $this->render('security/inscription.html.twig', [
           'form' => $form->createView(),
       ]);
   }
}
?>
