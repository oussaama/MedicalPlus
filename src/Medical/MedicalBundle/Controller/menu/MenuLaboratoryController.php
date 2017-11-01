<?php

namespace Medical\MedicalBundle\Controller\menu;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Medical\MedicalBundle\Form\LaboratoryFormType;

class MenuLaboratoryController extends Controller {

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

    public function indexLaboratoryAction() {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $article = $this->rechercheArticle();
        return $this->render('MedicalMedicalBundle:Laboratory:homeLaboratory.html.twig', array('articles' => $article, 'nb' => $nb, 'mb' => $mb));
    }

    private function verifAjout() {
        $em = $this->getDoctrine()->getManager();
        $m = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $query = $em->createQuery(
                        'SELECT(u.dateBilan)
                        FROM MedicalMedicalBundle:Bilan u
                        WHERE u.entrepriseBilan = :l 
                        ORDER BY u.dateBilan DESC')
                ->setParameter('l', $m)
                ->setMaxResults(1);

        return $query->getSingleResult();
    }

    public function balanceSheetAction() {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $em = $this->getDoctrine()->getManager();
        $d = $this->verifAjout()[1];
        $datetime1 = new \DateTime($d);
        $datetime2 = new \DateTime();
        $interval = (int) $datetime1->diff($datetime2)->format('%a');
        $interval2 = $datetime1->modify("+1 days")->diff($datetime2)->format('%h Hours %i Minute %s Seconds');
        $id = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $user = $em->getRepository("MedicalMedicalBundle:User")->findOneById($id);
        if ($user->getClass() == "premium") {
            $c = 5;
        } else if ($user->getClass() == "ultra") {
            $c = 10;
        } else {
            $c = 1;
        }
        $x = 0;
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
                $this->get('session')->getFlashBag()->add('echec', "il reste $interval2 pour ajouter nouvelle bilan médical ");
            } else {
                $interval2 = $datetime1->modify("+1 days")->diff($datetime2)->format('%h Hours %i Minute %s Seconds');
                $this->get('session')->getFlashBag()->add('echec', "it $interval2 remains to add new medical check-up ");
            }
        }
        $bilans = $em->getRepository('MedicalMedicalBundle:Bilan')->findAll();
        return $this->render('MedicalMedicalBundle:Laboratory:balanceSheet.html.twig', array('bilans' => $bilans, 'nb' => $nb, 'mb' => $mb,'x'=>$x));
    }

}
