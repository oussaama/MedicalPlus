<?php

namespace Medical\MedicalBundle\Controller\menu;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuCabineController extends Controller {

    private function rechercheArticle() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        'SELECT u.email,u.username,a.id,a.titre,a.photoArt,a.dateArt,a.contenuArt,c.nomCat
                        FROM MedicalMedicalBundle:User u,MedicalMedicalBundle:Article a,MedicalMedicalBundle:Categorie c 
                        WHERE u.id=a.auteurId AND a.etatArt= :e AND a.categorieArt=c.id
                        ORDER BY a.dateArt DESC')
                ->setParameter('e', 'approve')
                ->setMaxResults(3);
        $panier = $query->getResult();
        return $panier;
    }

    private function rechercheBook() {
        $em = $this->getDoctrine()->getManager();
        $docteurId = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $rendez = $em->createQuery(
                        'SELECT COUNT(p)
                            FROM MedicalMedicalBundle:RendezVous p
                            WHERE p.etatRv = :l AND p.idDocteur= :id')
                ->setParameter('l', 'reserved')
                ->setParameter('id', $docteurId);

        $mb = $rendez->getSingleResult();
        foreach ($mb as $a) {
            $mb = $a;
        }
        return $mb;
    }

    private function rechercheNotif() {
        $em = $this->getDoctrine()->getManager();
        $patient = $this->container->get('security.token_storage')->getToken()->getUser()->getEmail();
        $query = $em->createQuery(
                        'SELECT COUNT(p)
                        FROM MedicalMedicalBundle:Notification p
                        WHERE p.etatNot = :l AND p.destinateur= :email')
                ->setParameter('l', 'non lu')
                ->setParameter('email', $patient);

        $nb = $query->getResult();
        foreach ($nb as $n) {
            $nb = $n;
        }
        return $nb[1];
    }

    private function rechercheMessage() {
        $em = $this->getDoctrine()->getManager();
        $patient = $this->container->get('security.token_storage')->getToken()->getUser()->getEmail();
        $query = $em->createQuery(
                        'SELECT COUNT(p)
                        FROM MedicalMedicalBundle:Contact p
                        WHERE p.etatCont = :l AND p.emailRecu= :email')
                ->setParameter('l', 'non lu')
                ->setParameter('email', $patient);

        $nb = $query->getResult();
        foreach ($nb as $n) {
            $nb = $n;
        }
        return $nb[1];
    }

    public function indexCabineAction() {
        $book = $this->rechercheBook();
        $nb = $this->rechercheNotif();
        $mb= (int)$this->rechercheMessage();
        $article = $this->rechercheArticle();
        return $this->render('MedicalMedicalBundle:Cabine:homeCabine.html.twig', array('articles' => $article, 'nb' => $nb, 'mb' => $mb, 'book' => $book));
    }

    public function appointmentCabineAction() {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $book = $this->rechercheBook();
        $em = $this->getDoctrine()->getManager();
        $id = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $rendezVous = $em->getRepository("MedicalMedicalBundle:RendezVous")->findByIdDocteur($id);
        $etat = $em->getRepository("MedicalMedicalBundle:RendezVous")->findByEtatRv("reserved");
        foreach ($etat as $r) {
            $r->setEtatRv('waiting');
        }
        $em->flush();
        return $this->render('MedicalMedicalBundle:Cabine:appointmentCabine.html.twig', array('rendezVous' => $rendezVous, 'nb' => $nb, 'mb' => $mb, 'book' => $book));
    }

}
