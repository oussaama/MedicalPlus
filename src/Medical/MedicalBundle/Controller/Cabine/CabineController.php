<?php

namespace Medical\MedicalBundle\Controller\Cabine;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Medical\MedicalBundle\Entity\Notification;
use Medical\MedicalBundle\Form\AppointmentFormTypeEdit;

class CabineController extends Controller {

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
        return $nb;
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

    public function indexAction() {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        return $this->render('MedicalMedicalBundle:Default:index.html.twig', array('nb' => $nb, 'mb' => $mb));
    }

    public function classCabineAction() {
        $em = $this->getDoctrine()->getManager();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $book = $this->rechercheBook();
         $id = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $x = 0;
        $date = $em->getRepository("MedicalMedicalBundle:Facture")->findOneBy(array('entrepriseFact'=>$id,'typeFact'=>0));

        $user = $em->getRepository("MedicalMedicalBundle:User")->findOneById($id);
        if ($date) {
            $datetime1 = new \DateTime($date->getDateFact()->format('Y-m-d H:i:s'));
            $datetime2 = new \DateTime();
            if ($date->getClassFact() == "premium") {
                $m = (int) $datetime1->diff($datetime2)->format('%m');
                        var_dump($datetime1);die;
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
        return $this->render('MedicalMedicalBundle:Cabine:classCabine.html.twig', array('nb' => $nb, 'mb' => $mb, 'book' => $book,'x'=>$x));
    }

    public function acceptBookAction($id) {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $book = $this->rechercheBook();
        $docteur = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $name = $this->get('security.token_storage')->getToken()->getUser()->getFirstname() . " " . $this->get('security.token_storage')->getToken()->getUser()->getLastname();
        $docteurMail = $this->get('security.token_storage')->getToken()->getUser()->getEmail();
        $em = $this->getDoctrine()->getManager();
        $rendez = $em->getRepository("MedicalMedicalBundle:RendezVous")->find($id);
        $rendez->setEtatRv('accepted');
        $em->persist($rendez);
        $em->flush();

        $message = \Swift_Message::newInstance()
                ->setSubject('Hello Email')
                ->setFrom(array('oussemaakrouti@gmail.com' => 'Ahmad Shadeed'))
                ->setTo('akroutiioussama@gmail.com')
                ->setCharset('utf-8')
                ->setBody($this->renderView('MedicalMedicalBundle:Default:mail.html.twig', array('name' => 'sssss')), 'text/html');
        $this->get('mailer')->send($message);
        $notif = new Notification();
        $notif->setExpediteur($docteurMail);
        $notif->setDestinateur($rendez->getEmailRv());
        $notif->setEtatNot("non lu");
        $notif->setSujetNot($this->get('translator')->trans('appointment.noti.sap'));
        $notif->setContenuNot($this->get('translator')->trans('appointment.noti.sp') .
                 " ".$rendez->getDateRv() . " " . $rendez->getHeureRv() . "h" . $rendez->getMinuteRv() . "0 "
                . $this->get('translator')->trans('appointment.noti.sp1') . " " . $name);
        $em->persist($notif);
        $em->flush();
        $rendezVous = $em->getRepository("MedicalMedicalBundle:RendezVous")->findByIdDocteur($docteur);
        return $this->render('MedicalMedicalBundle:Cabine:appointmentCabine.html.twig', array('rendezVous' => $rendezVous, 'nb' => $nb, 'mb' => $mb, 'book' => $book));
    }

    public function modifBookAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $rendez = $em->getRepository("MedicalMedicalBundle:RendezVous")->findOneById($id);
        $editForm = $this->createForm(new AppointmentFormTypeEdit, $rendez);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();

            return $this->redirectToRoute('modif_book', array('id' => $rendez->getId()));
        }

        return $this->render('MedicalMedicalBundle:Cabine:EditAppointment.html.twig', array(
                    'id' => $id,
                    'edit_form' => $editForm->createView()));
    }

    public function deleteBookAction($id) {
        $name = $this->get('security.token_storage')->getToken()->getUser()->getFirstname() . " " . $this->get('security.token_storage')->getToken()->getUser()->getLastname();
        $docteurMail = $this->get('security.token_storage')->getToken()->getUser()->getEmail();
        $em = $this->getDoctrine()->getEntityManager();
        $rendez = $em->getRepository("MedicalMedicalBundle:RendezVous")->findOneById($id);
        $notif = new Notification();
        $notif->setExpediteur($docteurMail);
        $notif->setDestinateur($rendez->getEmailRv());
        $notif->setEtatNot("non lu");
        $notif->setSujetNot($this->get('translator')->trans('appointment.noti.fap'));
        $notif->setContenuNot($this->get('translator')->trans('appointment.noti.fp') .
                " ".$rendez->getDateRv(). " " . $rendez->getHeureRv() . "h" . $rendez->getMinuteRv() . "0 "
                . $this->get('translator')->trans('appointment.noti.sp1') . " " . $name);
        $em->persist($notif);
        $em->remove($rendez);
        $em->flush();
        
        return $this->redirectToRoute('Cabine_depointment');
    }

}
