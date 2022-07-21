<?php
namespace App\Services;

use DateTime;
use phpDocumentor\Reflection\Types\Integer;

class RechercheVoiture
{
    /**
     * Undocumented variable
     *
     * @var DateTime
     */
    private $date_depart;

    /**
     * Undocumented variable
     *
     * @var DateTime
     */
    private $date_retour;


   // pour afficher les getters et les etters on fait click droits inserrer getters et settes apres avoir télechargé l'extenssion


    /**
     * Get undocumented variable
     *
     * @return  DateTime
     */ 
    public function getDateDepart()
    {
        return $this->date_depart;
    }

    /**
     * Set undocumented variable
     *
     * @param  DateTime  $date_depart  Undocumented variable
     *
     * @return  self
     */ 
    public function setDateDepart(DateTime $date_depart)
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  DateTime
     */ 
    public function getDateRetour()
    {
        return $this->date_retour;
    }

    /**
     * Set undocumented variable
     *
     * @param  DateTime  $date_retour  Undocumented variable
     *
     * @return  self
     */ 
    public function setDateRetour(DateTime $date_retour)
    {
        $this->date_retour = $date_retour;

        return $this;
    }


    
}