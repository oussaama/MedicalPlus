<?php

namespace Medical\MedicalBundle\Controller\menu;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Medical\MedicalBundle\Form\PatientFormType;
use Medical\MedicalBundle\Form\PharmacyFormType;
use Medical\MedicalBundle\Form\BeautyFormType;
use Medical\MedicalBundle\Form\LaboratoryFormType;
use Medical\MedicalBundle\Form\CabineFormType;

class MenuPatientController extends Controller {

    private function rechercheSpeciality() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        'SELECT u.speciality
                        FROM MedicalMedicalBundle:User u
                        WHERE u.role= :r
                        Group by u.speciality')
                ->setParameter('r', 2);

        return $query->getResult();
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

    private function rechercheMessagePanal() {
        $em = $this->getDoctrine()->getManager();
        $admin = $this->container->get('security.token_storage')->getToken()->getUser()->getEmail();
        $query = $em->createQuery(
                        'SELECT u.picture,c.firstnameCont,c.lastnameCont,c.dateCont,c.subjectCont,c.etatCont,c.id,c.emailCont
                        FROM MedicalMedicalBundle:User u,MedicalMedicalBundle:Contact c
                        WHERE u.email = c.emailCont And c.emailCont != :admin
                        ORDER BY c.dateCont DESC')
                ->setParameter('admin', $admin)
                ->setMaxResults(3);

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
        return $nb;
    }

    private function rechercheState($role) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "SELECT u.state ,Count(u.state) AS nb
                         FROM MedicalMedicalBundle:User u 
                         WHERE u.role= :role
                         GROUP BY u.state")
                ->setParameter('role', $role);

        return $query->getResult();
    }

    private function recherche($role, $request) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "SELECT u
                         FROM MedicalMedicalBundle:User u 
                         WHERE u.role= :role AND u.username like :r OR u.city like :r OR u.email like :r 
                               OR u.class like :r OR u.tel =:r OR u.entrepriseName like :r
                         GROUP BY u.state")
                ->setParameter('role', $role)
                ->setParameter('r', $request);

        return $query->getResult();
    }

    private function recherchePanier() {
        $em = $this->getDoctrine()->getManager();
        $patient = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $query = $em->createQuery(
                        'SELECT m.photoMed,m.nomMed,m.prixMed,m.stockMed,m.entrepriseMed,p.produitP,p.patientP,p.stockP,p.id
                        FROM MedicalMedicalBundle:Panier p,MedicalMedicalBundle:Medicament m
                        WHERE p.produitP=m.id AND p.patientP= :patient')
                ->setParameter('patient', $patient);
        $panier = $query->getResult();
        return $panier;
    }

    private function recherchePanierEnt($id) {
        $em = $this->getDoctrine()->getManager();
        $patient = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $query = $em->createQuery(
                        'SELECT m.photoMed,m.nomMed,m.prixMed,m.stockMed,m.entrepriseMed,p.produitP,p.patientP,p.stockP,p.id
                        FROM MedicalMedicalBundle:Panier p,MedicalMedicalBundle:Medicament m
                        WHERE p.produitP=m.id AND p.patientP= :patient AND m.entrepriseMed= :entreprise')
                ->setParameter('patient', $patient)
                ->setParameter('entreprise', $id);

        $panier = $query->getResult();
        return $panier;
    }

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

    public function indexPatientAction() {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $articles = $this->rechercheArticle();
        $notif = $this->rechercheNotifPanal();
        $panier = $this->recherchePanier();
        $messages = $this->rechercheMessagePanal();
        return $this->render('MedicalMedicalBundle:Patient:homePatient.html.twig', array('nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'articles' => $articles, 'messages' => $messages, 'notifs' => $notif));
    }

    public function appointmentPatientAction() {
        $em = $this->getDoctrine()->getManager();
        $nb = $this->rechercheNotif();
        $notif = $this->rechercheNotifPanal();
        $mb = $this->rechercheMessage();
        $panier = $this->recherchePanier();
        $messages = $this->rechercheMessagePanal();
        $specialistes = $this->rechercheSpeciality();
        $doctors = $em->getRepository('MedicalMedicalBundle:User')->findByRole(2);
        return $this->render('MedicalMedicalBundle:Patient:appointmentPatient.html.twig', array('doctors' => $doctors, 'specialistes' => $specialistes, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif));
    }

    public function servicePatientAction() {
        $panier = $this->recherchePanier();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $notif = $this->rechercheNotifPanal();
        $messages = $this->rechercheMessagePanal();
        return $this->render('MedicalMedicalBundle:Patient:servicePatient.html.twig', array('nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif));
    }

    public function ServiceBeautyAction() {
        $em = $this->getDoctrine()->getManager();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $panier = $this->recherchePanier();
        $states = $this->rechercheState(4);
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $beauty = $em->getRepository("MedicalMedicalBundle:User")->findByRole(4);
        $beautys = $this->get('knp_paginator')->paginate($beauty, $this->get('request')->query->get('page', 1), 9);
        return $this->render('MedicalMedicalBundle:Patient:service/serviceBeauty.html.twig', array('utilisateurs' => $beautys, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'states' => $states, 'messages' => $messages, 'notifs' => $notif));
    }

    public function ServiceClinicalAction() {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $panier = $this->recherchePanier();
        $notif = $this->rechercheNotifPanal();
        $messages = $this->rechercheMessagePanal();
        return $this->render('MedicalMedicalBundle:Patient:service/serviceClinical.html.twig', array('mb' => $mb, 'nb' => $nb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif));
    }

    public function ServiceHospitalAction() {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $panier = $this->recherchePanier();
        $notif = $this->rechercheNotifPanal();
        $messages = $this->rechercheMessagePanal();
        return $this->render('MedicalMedicalBundle:Patient:service/serviceHospital.html.twig', array('mb' => $mb, 'nb' => $nb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif));
    }

    public function ServicePharmacyAction() {
        $em = $this->getDoctrine()->getManager();
        $panier = $this->recherchePanier();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $states = $this->rechercheState(3);
        $notif = $this->rechercheNotifPanal();
        $messages = $this->rechercheMessagePanal();
        $pharmacy = $em->getRepository("MedicalMedicalBundle:User")->findByRole(3);
        $pharmacys = $this->get('knp_paginator')->paginate($pharmacy, $this->get('request')->query->get('page', 1), 9);
        return $this->render('MedicalMedicalBundle:Patient:service/servicePharmacy.html.twig', array('utilisateurs' => $pharmacys, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'states' => $states, 'messages' => $messages, 'notifs' => $notif));
    }

    public function ServiceLaboratoryAction() {
        $em = $this->getDoctrine()->getManager();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $messages = $this->rechercheMessagePanal();
        $states = $this->rechercheState(5);
        $panier = $this->recherchePanier();
        $notif = $this->rechercheNotifPanal();
        $laboratory = $em->getRepository("MedicalMedicalBundle:User")->findByRole(5);
        $laboratorys = $this->get('knp_paginator')->paginate($laboratory, $this->get('request')->query->get('page', 1), 9);
        return $this->render('MedicalMedicalBundle:Patient:service/serviceLaboratory.html.twig', array('utilisateurs' => $laboratorys, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'states' => $states, 'messages' => $messages, 'notifs' => $notif));
    }

    public function profilAction() {
        $em = $this->getDoctrine()->getManager();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $panier = $this->recherchePanier();
        $notif = $this->rechercheNotifPanal();
        $messages = $this->rechercheMessagePanal();
        $book = $this->rechercheBook();
        $id = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $role = $this->container->get('security.context')->getToken()->getUser()->getRole();
        $entity = $em->getRepository('MedicalMedicalBundle:User')->find(array('id' => $id));
        if ($role == 1) {
            $form = $this->createForm(new PatientFormType(), $entity);
        } else if ($role == 3) {
            $form = $this->createForm(new PharmacyFormType(), $entity);
        } else if ($role == 2) {
            $form = $this->createForm(new CabineFormType(), $entity);
        } else if ($role == 4) {
            $form = $this->createForm(new BeautyFormType(), $entity);
        } else if ($role == 5) {
            $form = $this->createForm(new LaboratoryFormType(), $entity);
        }
        return $this->render('::Layout/profil.html.twig', array('book'=>$book,'mb' => $mb, 'nb' => $nb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif,'id'=>$id,'form'=>$form));
    }

    private function recherchePromo() {
        $d = date("Y-m-d");
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "SELECT u.entrepriseName,p.id,p.nomPr,p.categoriePr,p.prixPr,p.photoPr,p.descreptionPr,p.datefinPr,p.datedebPr
                         FROM MedicalMedicalBundle:User u, MedicalMedicalBundle:Promo p 
                         WHERE u.id= p.entreprisePr And p.datefinPr >= :d
                         ORDER BY p.datefinPr DESC")
                ->setParameter('d', $d);

        return $query->getResult();
    }

    public function promoPatientAction() {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $messages = $this->rechercheMessagePanal();
        $panier = $this->recherchePanier();
        $notif = $this->rechercheNotifPanal();
        $promo = $this->recherchePromo();
        $promos = $this->get('knp_paginator')->paginate($promo, $this->get('request')->query->get('page', 1), 9);
        return $this->render('MedicalMedicalBundle:Patient:promo.html.twig', array('nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif, 'promos' => $promos));
    }

    public function basketPatientAction($id) {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $panier = $this->recherchePanier();
        $panierEnt = $this->recherchePanierEnt($id);
        $notif = $this->rechercheNotifPanal();
        $messages = $this->rechercheMessagePanal();
        return $this->render('MedicalMedicalBundle:Patient:basketPatient.html.twig', array('nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif, 'panierEnt' => $panierEnt, 'id' => $id));
    }

    public function removeBasketAction($id) {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("MedicalMedicalBundle:Panier")->findOneById($id);
        $idd = $produit->getEntrepriseP();
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute('Patient_Basket', array('id' => $idd));
    }

    public function statePatientAction($state, $role) {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $panier = $this->recherchePanier();
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $em = $this->getDoctrine()->getManager();
        $states = $this->rechercheState($role);
        $utilisateur = $em->getRepository("MedicalMedicalBundle:User")->findBy(array('role' => $role, 'state' => $state));
        $utilisateurs = $this->get('knp_paginator')->paginate($utilisateur, $this->get('request')->query->get('page', 1), 9);
        if ($role == 3) {
            $view = 'MedicalMedicalBundle:Patient:service/servicePharmacy.html.twig';
        } else if ($role == 4) {
            $view = 'MedicalMedicalBundle:Patient:service/serviceBeauty.html.twig';
        } else if ($role == 5) {
            $view = 'MedicalMedicalBundle:Patient:service/serviceLaboratory.html.twig';
        }
        return $this->render($view, array('utilisateurs' => $utilisateurs, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'states' => $states, 'messages' => $messages, 'notifs' => $notif));
    }

    public function searchPatientAction(Request $request, $role) {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $notif = $this->rechercheNotifPanal();
        $messages = $this->rechercheMessagePanal();
        $panier = $this->recherchePanier();
        $states = $this->rechercheState($role);
        $utilisateur = $this->recherche($role, $request->get('s'));
        $utilisateurs = $this->get('knp_paginator')->paginate($utilisateur, $this->get('request')->query->get('page', 1), 9);
        if ($role == 3) {
            $view = 'MedicalMedicalBundle:Patient:service/servicePharmacy.html.twig';
        } else if ($role == 4) {
            $view = 'MedicalMedicalBundle:Patient:service/serviceBeauty.html.twig';
        } else if ($role == 5) {
            $view = 'MedicalMedicalBundle:Patient:service/serviceLaboratory.html.twig';
        }
        return $this->render($view, array('utilisateurs' => $utilisateurs, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'states' => $states, 'messages' => $messages, 'notifs' => $notif));
    }

}
