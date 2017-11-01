<?php

namespace Medical\MedicalBundle\Controller\Pharmacy;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Medical\MedicalBundle\Form\MedicamentFormType;
use Medical\MedicalBundle\Entity\Medicament;

class PharmacyController extends Controller {

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

    public function deleteAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $idu = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $medicament = $em->getRepository("MedicalMedicalBundle:Medicament")->findOneById($id);
        $em->remove($medicament);
        $user = $em->getRepository("MedicalMedicalBundle:User")->findOneById($idu);
        if ($user->getClass() == Null && $user->getNbprod() < 5) {
            $user->setNbprod($user->getNbprod() + 1);
            $em->persist($user);
        } else if ($user->getClass() == "premium" && $user->getNbprod() < 10) {
            $user->setNbprod($user->getNbprod() + 1);
            $em->persist($user);
        } else if ($user->getClass() == "ultra" && $user->getNbprod() < 50) {
            $user->setNbprod($user->getNbprod() + 1);
            $em->persist($user);
        }
        $em->flush();
        return $this->redirectToRoute('Pharmacy_medicament');
    }

    public function classPharmacyAction() {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $em = $this->getDoctrine()->getEntityManager();
        $id = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $x = 0;
        $date = $em->getRepository("MedicalMedicalBundle:Facture")->findOneBy(array('entrepriseFact'=>$id,'typeFact'=>0));
        $user = $em->getRepository("MedicalMedicalBundle:User")->findOneById($id);
        if ($date) {
            $datetime1 = new \DateTime($date->getDateFact()->format('Y-m-d H:i:s'));
            $datetime2 = new \DateTime();
            if ($date->getClassFact() == "premium") {
                $m = (int) $datetime1->diff($datetime2)->format('%m');
                if ($m >= 1) {
                    $x = 1;
                    $user->setClass(Null);
                    $user->setNombre(0);
                    $user->setNbpromo(0);
                    $user->setNbprod(0);
                    $em->persist($user);
                } else {
                    if ($this->getRequest()->getLocale() == "fr") {
                        $interval2 = $datetime1->modify("+1 months")->diff($datetime2)->format('%a Jours %h Heures %i Minutes');
                        $this->get('session')->getFlashBag()->add('echec', "il reste $interval2 pour mettre a jour votre Class ");
                    } else {
                        $interval2 = $datetime1->modify("+1 months")->diff($datetime2)->format('%a Days %h Heures %i Minutes');
                        $this->get('session')->getFlashBag()->add('echec', "it $interval2 remains to upgrade our Class ");
                    }
                }
            } else if ($date->getClassFact() == "ultra") {
                $m = (int) $datetime1->diff($datetime2)->format('%y');
                if ($m >= 1) {
                    $x = 1;
                    $user->setClass(Null);
                    $user->setNombre(0);
                    $user->setNbpromo(0);
                    $user->setNbprod(0);
                    $em->persist($user);
                } else {
                    if ($this->getRequest()->getLocale() == "fr") {
                        $interval2 = $datetime1->modify("+1 years")->diff($datetime2)->format('%m Mois %d Jours %h Heures %i Minutes');
                        $this->get('session')->getFlashBag()->add('echec', "il reste $interval2 pour mettre a jour votre Class ");
                    } else {
                        $interval2 = $datetime1->modify("+1 years")->diff($datetime2)->format('%m Mois %d Days %h Heures %i Minutes');
                        $this->get('session')->getFlashBag()->add('echec', "it $interval2 remains to upgrade our Class ");
                    }
                }
            }
        } else {
            $x = 1;
        }
        $em->flush();
        return $this->render('MedicalMedicalBundle:Pharmacy:classPharmacy.html.twig', array('nb' => $nb, 'mb' => $mb, 'x' => $x));
    }

}
