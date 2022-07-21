<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\RechercheVoitureType;
use App\Repository\ReservationRepository;
use App\Repository\VoitureRepository;
use App\Services\RechercheVoiture;
use App\Services\VoitureDispo;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(
        Request $request,
        VoitureRepository $voitureRepository,
        ReservationRepository $reservationRepository,
        VoitureDispo $voitureDispo
    ): Response {
        $rechercheVoiture = new RechercheVoiture();
        $form = $this->createForm(RecherchevoitureType::class, $rechercheVoiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //je récupère la date de départ et de retour passée dans le formulaire
            $date_depart = $form->get('date_depart')->getData();
            $date_retour = $form->get('date_retour')->getData();
            //je calcul le nombre de jour de la demande du formulaire
            $total_jour = $date_depart->diff($date_retour)->format("%a");
            //je recupère la liste voiture dispo par rapport a nos dates pasées dans le formulaire
            $tableau_voiture_dispo = $voitureDispo->getVoitureDispo($date_depart, $date_retour);


            //   je rend la vue des voitures dispo
        return $this->render('home/resa.html.twig', [

            "voitures" => $tableau_voiture_dispo,
            "total_jour" => $total_jour,
            "date_depart" => $date_depart,
            "date_retour" => $date_retour
            


        ]);
        }
        


        return $this->render('home/index.html.twig', [
            "voitures" => $voitureRepository->findAll(),
            "form" => $form->createView()

        ]);
    }
    


/**
     * @Route("/reserver/{id}/{prixtotal}/{depart}/{retour}", name="app_new_reservation", methods={"GET", "POST"})
     */
    public function new($id, $prixtotal, $depart, $retour, ReservationRepository $reservationRepository,VoitureRepository $voitureRepository)
    {
        $reservation = new Reservation();
        // je récup le user connecté
        $user = $this->getUser();
        $reservation->setUser($user);
        //je récup la date du jour
        $date_jour = new DateTime();
        $reservation->setDateResa($date_jour);
        // je récup la voiture selectionnée 
        $voiture = $voitureRepository->find($id);
        $reservation->setVoiture($voiture);
        //je rajoute le total a ma reservation
        $reservation->setPrixTotal($prixtotal);
        //je rajoute les dates depart et retour a ma reservation
        $date_depart = new DateTime($depart);
        $date_retour = new DateTime($retour);
        $reservation->setDateDepart($date_depart);
        $reservation->setDateRetour($date_retour);
        
        // pour envoyer dans la base de donnée
        $reservationRepository->add($reservation);
        return $this->redirectToRoute('app_home');

        dd($reservation);
      

      
        
    }






}




