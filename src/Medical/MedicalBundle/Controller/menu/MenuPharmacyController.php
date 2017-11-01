<?php

namespace Medical\MedicalBundle\Controller\menu;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Medical\MedicalBundle\Form\PharmacyFormType;

class MenuPharmacyController extends Controller {

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

    private function rechercheNotif() {
        $em = $this->getDoctrine()->getManager();
        $patient = $this->container->get('security.token_storage')->getToken()->getUser()->getEmail();
        $query = $em->createQuery(
                        'SELECT COUNT(p)
                        FROM MedicalMedicalBundle:Notification p
                        WHERE p.etatNot = :l AND p.destinateur= :email')
                ->setParameter('l', 'non lu')
                ->setParameter('email', $patient);

        $nb = $query->getSingleResult();
        foreach ($nb as $n) {
            $nb = $n;
        }
        return $nb;
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

        $nb = $query->getSingleResult();
        foreach ($nb as $n) {
            $nb = $n;
        }
        return $nb;
    }

    private function verifAjout() {
        $em = $this->getDoctrine()->getManager();
        $m = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $query = $em->createQuery(
                        'SELECT(u.dateMed)
                        FROM MedicalMedicalBundle:Medicament u
                        WHERE u.entrepriseMed = :l 
                        ORDER BY u.dateMed DESC')
                ->setParameter('l', $m)
                ->setMaxResults(1);

        return $query->getResult();
    }

    public function indexPharmacyAction() {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $article = $this->rechercheArticle();
        return $this->render('MedicalMedicalBundle:Pharmacy:homePharmacy.html.twig', array('articles' => $article, 'nb' => $nb, 'mb' => $mb));
    }

    public function medicamentAction() {
        $em = $this->getDoctrine()->getManager();
        $id = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $user = $em->getRepository("MedicalMedicalBundle:User")->findOneById($id);
        if ($user->getClass() == "premium") {
            $c = 10;
        } else if ($user->getClass() == "ultra") {
            $c = 50;
        } else {
            $c = 5;
        }
        $x = 0;
        $d = $this->verifAjout();
        if (!$d) {
            $x = 1;
            $user->setNbprod($c);
        } else if ($d) {
            $datetime1 = new \DateTime($this->verifAjout()[0]['1']);
            $datetime2 = new \DateTime();
            $interval = (int) $datetime1->diff($datetime2)->format('%a');
            $interval2 = $datetime1->modify("+1 days")->diff($datetime2)->format('%h Hours %i Minute %s Seconds');

            if ($user->getNbprod() > 0) {
                $x = 1;
            } else if ($interval >= 1 && $user->getNbprod() >= 0) {
                $x = 1;
                $user->setNbprod($c);
                $em->persist($user);
                $em->flush();
            } else {
                if ($this->getRequest()->getLocale() == "fr") {
                    $interval2 = $datetime1->modify("+1 days")->diff($datetime2)->format('%h Heures %i Minute %s Seconds');
                    $this->get('session')->getFlashBag()->add('echec', "il reste $interval2 pour ajouter nouveaux produits ");
                } else {
                    $interval2 = $datetime1->modify("+1 days")->diff($datetime2)->format('%h Hours %i Minute %s Seconds');
                    $this->get('session')->getFlashBag()->add('echec', "it $interval2 remains to add new products ");
                }
            }
        }
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $medicaments = $em->getRepository('MedicalMedicalBundle:Medicament')->findAll();
        return $this->render('MedicalMedicalBundle:Pharmacy:medicament.html.twig', array('medicaments' => $medicaments, 'nb' => $nb, 'mb' => $mb, 'x' => $x));
    }

}
