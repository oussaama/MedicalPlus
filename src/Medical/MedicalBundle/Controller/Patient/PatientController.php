<?php

namespace Medical\MedicalBundle\Controller\Patient;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Medical\MedicalBundle\Entity\RendezVous;
use Medical\MedicalBundle\Entity\Panier;
use Medical\MedicalBundle\Form\AppointmentFormType;
use Medical\MedicalBundle\Entity\Commentaire;
use Medical\MedicalBundle\Entity\Facture;
use Symfony\Component\HttpFoundation\Response;

class PatientController extends Controller {

    public function indexAction() {
        return $this->render('MedicalMedicalBundle:Default:index.html.twig');
    }

    private function rechercheMessagePanal() {
        $em = $this->getDoctrine()->getManager();
        $admin = $this->container->get('security.token_storage')->getToken()->getUser()->getEmail();
        $query = $em->createQuery(
                        'SELECT u.picture,c.firstnameCont,c.lastnameCont,c.dateCont,c.subjectCont,c.etatCont,c.id,c.emailCont
                        FROM MedicalMedicalBundle:User u,MedicalMedicalBundle:Contact c
                        WHERE u.email = c.emailCont And c.emailRecu = :admin
                        ORDER BY c.dateCont DESC')
                ->setParameter('admin', $admin)
                ->setMaxResults(3);

        return $query->getResult();
    }

    private function rechercheNotifPanal() {
        $em = $this->getDoctrine()->getManager();
        $admin = $this->container->get('security.token_storage')->getToken()->getUser()->getEmail();
        $query = $em->createQuery(
                        'SELECT u.picture,n.dateNot,n.expediteur,n.sujetNot
                        FROM MedicalMedicalBundle:User u,MedicalMedicalBundle:Notification n
                        WHERE u.email = n.expediteur And n.destinateur = :admin
                        ORDER BY n.dateNot DESC')
                ->setParameter('admin', $admin)
                ->setMaxResults(3);

        return $query->getResult();
    }

    private function rechercheCategorie($id) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "SELECT m.categorieMed ,m.entrepriseMed,Count(m.categorieMed) AS nb
                         FROM MedicalMedicalBundle:Medicament m 
                         WHERE m.entrepriseMed= :id
                         GROUP BY m.categorieMed")
                ->setParameter('id', $id);

        return $query->getResult();
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
        return (int) $nb;
    }

    private function recherchePanier() {
        $em = $this->getDoctrine()->getManager();
        $patient = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $query = $em->createQuery(
                        'SELECT m.photoMed,m.nomMed,m.prixMed,m.stockMed,p.produitP,p.patientP,p.stockP
                        FROM MedicalMedicalBundle:Panier p,MedicalMedicalBundle:Medicament m
                        WHERE p.produitP=m.id AND p.patientP= :patient')
                ->setParameter('patient', $patient);
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
        return (int) $nb;
    }

    public function descriptionPhAction($id) {
        $em = $this->getDoctrine()->getManager();
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $pharmacy = $em->getRepository('MedicalMedicalBundle:User')->find($id);
        $medicaments = $em->getRepository('MedicalMedicalBundle:Medicament')->findByEntrepriseMed($id);
        $categories = $this->rechercheCategorie($id);
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $panier = $this->recherchePanier();
        $panierEnt = $this->recherchePanierEnt($id);
        $medicament = $this->get('knp_paginator')->paginate($medicaments, $this->get('request')->query->get('page', 1), 9);
        return $this->render('MedicalMedicalBundle:Patient:service/descriptionPharmacy.html.twig', array('pharmacy' => $pharmacy, 'medicaments' => $medicament, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'categories' => $categories, 'messages' => $messages, 'notifs' => $notif, 'id' => $id, 'panierEnt' => $panierEnt));
    }

    public function descriptionDoctorAction($id) {
        $em = $this->getDoctrine()->getManager();
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $panier = $this->recherchePanier();
        $doctor = $em->getRepository('MedicalMedicalBundle:User')->findOneById($id);
        $query = $em->createQuery(
                        'SELECT u.picture,u.username,c.commentaire,c.dateCom
                 FROM MedicalMedicalBundle:User u ,MedicalMedicalBundle:Commentaire c
                 WHERE u.id=c.utilisateurCom And c.typeCom = :type')
                ->setParameter('type', 'docteur');
        $commentaires = $query->getResult();
        return $this->render('MedicalMedicalBundle:Patient:service/descriptionDoctor.html.twig', array('doctor' => $doctor, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif, 'commentaires' => $commentaires));
    }

    public function descriptionBeautyAction($id) {
        $em = $this->getDoctrine()->getManager();
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $panier = $this->recherchePanier();
        $beauty = $em->getRepository('MedicalMedicalBundle:User')->findOneById($id);
        $soin = $em->getRepository('MedicalMedicalBundle:Soin')->findByEntrepriseSoin($id);
        $soins = $this->get('knp_paginator')->paginate($soin, $this->get('request')->query->get('page', 1), 9);
        return $this->render('MedicalMedicalBundle:Patient:service/descriptionBeauty.html.twig', array('beauty' => $beauty, 'soins' => $soins, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif));
    }

    public function descriptionLaboratoryAction($id) {
        $em = $this->getDoctrine()->getManager();
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $panier = $this->recherchePanier();
        $laboratory = $em->getRepository('MedicalMedicalBundle:User')->findById($id);
        $bilans = $em->getRepository('MedicalMedicalBundle:Bilan')->findByEntrepriseBilan($id);
        return $this->render('MedicalMedicalBundle:Patient:service/descriptionLaboratory.html.twig', array('laboratory' => $laboratory, 'bilans' => $bilans, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif));
    }

    public function FormAppointmentAction(Request $request, $id) {
        $rendez = new RendezVous();
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $em = $this->getDoctrine()->getManager();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $patient = $this->container->get('security.token_storage')->getToken()->getUser();
        $rendez->setCinRv($patient->getCin());
        $rendez->setFirstnameRv($patient->getFirstname());
        $rendez->setLastnameRv($patient->getLastname());
        $rendez->setTelRv($patient->getTel());
        $rendez->setEmailRv($patient->getEmail());
        $doctor = $em->getRepository('MedicalMedicalBundle:User')->findOneById($id)->getId();
        $rendezVous = $em->getRepository("MedicalMedicalBundle:RendezVous")->findBy(array('dateRv' => $request->get('query'), 'idDocteur' => $id));
        $editForm = $this->createForm('Medical\MedicalBundle\Form\AppointmentFormType', $rendez);
        $panier = $this->recherchePanier();
        return $this->render('MedicalMedicalBundle:Patient:formAppointment.html.twig', array('form' => $editForm->createView(), 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'doctor' => $doctor, 'messages' => $messages, 'notifs' => $notif, 'rendezVous' => $rendezVous));
    }

    public function commentaireDoctorAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $patient = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $commentaire = new Commentaire();
        $commentaire->setArticleCom(0);
        $commentaire->setUtilisateurCom($patient);
        $commentaire->setCommentaire($request->get('comment'));
        $commentaire->setTypeCom('docteur');
        $commentaire->setDateCom(new \DateTime());
        $em->persist($commentaire);
        $em->flush();
        $this->get('session')->getFlashBag()->add('suComm', 'flush.comm.as');
        return $this->redirectToRoute('Patient_Do_description', array('id' => $id));
    }

    private function convDate($d) {
        $x = explode("/", $d);
        $f = "";
        foreach ($x as $v) {
            if ($v < 10) {
                $v = '0' . $v;
            }
            $f.=$v;
        }
        return $f;
    }

    public function bookAppointmentAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $book = new RendezVous();
        $date = Date('dmY');
        $rv = $this->convDate($request->get('date'));
        $editForm = $this->createForm(new AppointmentFormType(), $book);
        $patient = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $editForm->handleRequest($request);
        $d = Date("Y-m-d");
        $dn = Date("dmY");
        $h = (int) Date("H");
        $reserver = $em->getRepository("MedicalMedicalBundle:RendezVous")->findBy(array('reserved' => $d, 'idPatient' => $patient, 'idDocteur' => $id));
        $test = $em->getRepository("MedicalMedicalBundle:RendezVous")->findBy(array('heureRv' => $book->getHeureRv(),
            'minuteRv' => $book->getMinuteRv(),
            'dateRv' => $request->get('date'), 'idDocteur' => $id));
        if ($editForm->isValid()) {
            if ($editForm->isSubmitted() && $editForm->isValid() && $rv >= $date && !$test && !$reserver) {
                if ($this->convDate($request->get('date')) >= $dn || $book->getHeureRv() - $h >= 3) {
                    $em = $this->getDoctrine()->getManager();
                    $book->setIdDocteur($id);
                    $book->setIdPatient($patient);
                    $book->setDateRv($request->get('date'));
                    $book->setEtatRv('reserved');
                    $book->setReserved($d);
                    $em->persist($book);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('flush.appo.as'));
                } else {
                    $this->get('session')->getFlashBag()->add('echec', $this->get('translator')->trans('flush.appo.adp'));
                }
            } else if ($test) {
                $this->get('session')->getFlashBag()->add('echec', $this->get('translator')->trans('flush.appo.af'));
            } else if ($reserver) {
                $this->get('session')->getFlashBag()->add('echec', $this->get('translator')->trans('flush.appo.pv'));
            } else {
                $this->get('session')->getFlashBag()->add('echec', $this->get('translator')->trans('flush.appo.av'));
            }
            return $this->redirectToRoute('Patient_Do_description', array('id' => $id));
        }
        return $this->redirectToRoute('Patient_Do_description', array('id' => $id));
    }

    public function addMedicamentCardAction($id) {
        $em = $this->getDoctrine()->getManager();
        $panier = new Panier();
        $medicament = $em->getRepository("MedicalMedicalBundle:Medicament")->findOneById($id);
        $patient = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $query = $em->createQuery('SELECT m.stockMed,m.entrepriseMed,m.stockMed FROM MedicalMedicalBundle:Medicament m WHERE m.id = :l')->setParameter('l', $id);
        $panierP = $em->getRepository("MedicalMedicalBundle:Panier")->findByProduitP($id);
        $b = $query->getSingleResult();
        $entreprise = $b['entrepriseMed'];
        $stock = $b['stockMed'];
        foreach ($panierP as $p) {
            $x = $p->getStockP() + 1;
        }
        if ($b['stockMed'] > 0) {
            if ($panierP) {
                foreach ($panierP as $p) {
                    $p->setStockP($x);
                    $p->setDateP(new \DateTime());
                }

                $medicament->setStockMed($stock - 1);
                $em->flush();
            } else {
                $panier->setPatientP($patient);
                $panier->setProduitP($id);
                $panier->setStockP('1');
                $panier->setEntrepriseP($entreprise);
                $panier->setDateP(new \DateTime());
                $medicament->setStockMed($stock - 1);
                $em->persist($panier);
                $em->flush();
            }
        }

        return $this->redirectToRoute('Patient_ph_Description', array('id' => $entreprise));
    }

    public function categorieMedicamentAction($id, $cat) {
        $em = $this->getDoctrine()->getManager();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $panier = $this->recherchePanier();
        $categories = $this->rechercheCategorie($id);
        $panierEnt = $this->recherchePanierEnt($id);
        $medicament = $em->getRepository('MedicalMedicalBundle:Medicament')->findBy(array('entrepriseMed' => $id, 'categorieMed' => $cat));
        $medicaments = $this->get('knp_paginator')->paginate($medicament, $this->get('request')->query->get('page', 1), 9);
        $pharmacy = $em->getRepository('MedicalMedicalBundle:User')->find($id);
        return $this->render('MedicalMedicalBundle:Patient:service/descriptionPharmacy.html.twig', array('categories' => $categories, 'medicaments' => $medicaments, 'pharmacy' => $pharmacy, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif, 'id' => $id, 'panierEnt' => $panierEnt));
    }

    private function recherchePanierEnt($id) {
        $em = $this->getDoctrine()->getManager();
        $patient = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $query = $em->createQuery(
                        'SELECT m.nomMed,m.photoMed
                        FROM MedicalMedicalBundle:Medicament m,MedicalMedicalBundle:Panier p
                        WHERE p.patientP = :idp AND m.entrepriseMed=:id And m.id = p.produitP
                        ORDER BY p.dateP DESC')
                ->setParameter('id', $id)
                ->setParameter('idp', $patient);
        return $query->getResult();
    }

    public function paymentAction($id, $price) {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $panier = $this->recherchePanier();
        return $this->render('MedicalMedicalBundle:Patient:payment.html.twig', array('id' => $id, 'nb' => $nb, 'mb' => $mb, 'messages' => $messages, 'notifs' => $notif, 'panier' => $panier, 'price' => $price));
    }

    public function factureAction(Request $request, $id, $price) {
        $em = $this->getDoctrine()->getManager();
        $facture = new Facture();
        $facture->setEntrepriseFact($em->getRepository("MedicalMedicalBundle:User")->findOneById($id)->getEntrepriseName());
        $facture->setPrixFact($price);
        $facture->setNomFact($request->get('nom'));
        $facture->setPrenomFact($request->get('prenom'));
        $facture->setEmailFact($request->get('mail'));
        $facture->setTelFact($request->get('phone'));
        $facture->setAdressFact($request->get('ad'));
        $facture->setStateFact($request->get('st'));
        $facture->setCityFact($request->get('ville'));
        $facture->setCodeFact($request->get('code'));
        $facture->setTelFact(1);
        $facture->setEntrepriseFact($id);
        $facture->setDateFact(new \DateTime());
        $patient = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $commande = $em->getRepository("MedicalMedicalBundle:Panier")->findBy(array('patientP' => $patient, 'entrepriseP' => $id));
        $c = array();
        for ($i = 0; $i < count($commande); $i++) {
            $c[$i][0] = $commande[$i]->getProduitP();
            $c[$i][1] = $commande[$i]->getStockP();
        }
        $facture->setCommandeFact($c);
        $em->persist($facture);
        foreach ($commande as $p) {
            $em->remove($p);
            $em->flush();
        }
        $em->flush();
        if ($this->getRequest()->getLocale() == "fr") {
            $this->get('session')->getFlashBag()->add('success', 'Votre demmande est accepter');
        } else {
            $this->get('session')->getFlashBag()->add('success', 'Our Request is accepted');
        }

        return $this->redirectToRoute('Patient_payment', array('id' => $id, 'price' => $price));
    }

}
