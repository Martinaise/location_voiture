<?php

namespace App\Services;

use App\Repository\VoitureRepository;
use App\Repository\ReservationRepository;

class VoitureDispo
{
    private $voitureRepo;
    private $resaRepo;

    public function __construct(ReservationRepository $resarepo, VoitureRepository $voiturerepo)
    {
        $this->voitureRepo = $voiturerepo;
        $this->resaRepo = $resarepo;
    }
    // méthode pour recupérer une liste d'id de voiture reservées aux dates demandées
    public function getVoitureReserve($depart, $retour)
    {
        // je récup la liste des reservation 
        $list_voiture_resa = $this->resaRepo->findAllVoitures($depart, $retour);
        // je crée un tableau vide qui vas contenir une liste d'id des voiture reservées
        $tableau_id_voiture = [];
        foreach ($list_voiture_resa as $reservation) {
            // je récup l'id de la voiture qui ce trouve dans l'object reservation 
            $tableau_id_voiture[] = $reservation->getVoiture()->getId();
        }

        return $tableau_id_voiture;
    }

    // méthode pour récup les voiture disponible
    public function getVoitureDispo($depart, $retour)
    {
        // je récup la liste des voiture reservé 
        $tableau_id_voiture_reserve = $this->getVoitureReserve($depart, $retour);
        // récup toutes les voiture de l'agence 
        $list_voiture = $this->voitureRepo->findAll();
        // je crée un tableau vide qui vas contenir les voiture dispo
        $tableau_voiture_dispo = [];
        foreach ($list_voiture as $voiture) {
            // je test si l'Id la voiture ce trouve dans mon tableau des id voiture reserées
            if (!in_array($voiture->getId(), $tableau_id_voiture_reserve)) {
                // si il le trouve pas , il ajoute la voiture au tableau des voitures disponible
                $tableau_voiture_dispo[] = $voiture;
            }
        }

        return $tableau_voiture_dispo;
    }


    
}
