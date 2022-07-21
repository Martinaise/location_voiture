<?php

namespace App\Controller\Admin;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('admin/voiture')]
class VoitureController extends AbstractController
{
    #[Route('/', name: 'app_voiture_index', methods: ['GET'])]
    public function index(VoitureRepository $voitureRepository): Response
    {
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_voiture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VoitureRepository $voitureRepository): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ici le code que je dois rajouter à la main avant d'envoyer à la BDD
            // je recupere la date du jour
            $date_jour = new DateTime();
            //je set l'objet voiture avec la date du jour
            $voiture->setDateEnregistrement($date_jour);

            // debut code pour ajouter une photo
            $photo = $form->get('photo')->getData();
            if (!is_null($photo)) {
                //je crée un nouveau nom unique pour l'image
                $photo_new_name = uniqid() . '.' . $photo->guessExtension();
                
                //j'envoie la photo à notre dossier public/photos
                $photo->move(
                    //premier param : ou il va la stocker
                    $this->getParameter('upload_dir'),
                    // le nouveau nom de la photo
                    $photo_new_name
                );
                //j'envoie à la BDD le même nom que le serveur
                $voiture->setPhoto($photo_new_name);
            }else {
                $voiture->setPhoto('photodefault.png');
            }
            // fin de code pour photo



            //-------------------------------
            $voitureRepository->add($voiture, true);
           

            return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voiture/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_voiture_show', methods: ['GET'])]
    public function show(Voiture $voiture): Response
    {
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_voiture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Voiture $voiture, VoitureRepository $voitureRepository): Response
    {
        //recuperer l'ancien nom de la photo
        $old_name = $voiture->getPhoto();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // debut code pour ajouter une photo
            $photo = $form->get('photo')->getData();
            if (!is_null($photo)) {
                //je crée un nouveau nom unique pour l'image
                $photo_new_name = uniqid() . '.' . $photo->guessExtension();
                
                //j'envoie la photo à notre dossier public/photos
                $photo->move(
                    //premier param : ou il va la stocker
                    $this->getParameter('upload_dir'),
                    // le nouveau nom de la photo
                    $photo_new_name
                );
                //j'envoie à la BDD le même nom que le serveur
                $voiture->setPhoto($photo_new_name);
            }else {
                // si ya pas eu de changement de photo, on recupere l'ancien nom
                $voiture->setPhoto($old_name);
            }
            // fin du code pour photo

            $voitureRepository->add($voiture, true);

            return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_voiture_delete', methods: ['POST'])]
    public function delete(Request $request, Voiture $voiture, VoitureRepository $voitureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voiture->getId(), $request->request->get('_token'))) {
            $voitureRepository->remove($voiture, true);
        }

        return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
    }
}



