<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="app_utilisateur")
     */
    public function index(ObjectManager $om, Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $om->persist($user);
            $om->flush();
            return $this->redirectToRoute('showall');
        }
        return $this->render('utilisateur/index.html.twig', [
                'formulaire' => $form->createView()
            ]);
    }
}