<?php

namespace App\Controller;

use App\Entity\Evenements;
use App\Form\EvenementType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="app_evenement")
     */
    public function index(): Response
    {
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }
    /**
     * @Route("/", name="createEvent")
     */
    public function createEvent(ObjectManager $om, Request $request): Response
    {
        $evenement = new Evenements();
        $form=$this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setDate(new \DateTime());
            $om->persist($evenement);
            $om->flush();

            return $this->redirectToRoute("createEvenement");
        }
        return $this->render('evenement/createEvenement.html.twig', [
            'formulaire' => $form->createView(),

        ]);
    }
}