<?php

namespace Medical\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Medical\MedicalBundle\Entity\Contact;

/**
 * Contact controller.
 *
 */
class ContactController extends Controller {

    /**
     * Lists all Contact entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $contacts = $em->getRepository('MedicalMedicalBundle:Contact')->findAll();

        return $this->render('contact/index.html.twig', array(
                    'contacts' => $contacts,
        ));
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

    /**
     * Creates a new Contact entity.
     *
     */
    public function newAction(Request $request) {
        $em = $this->getDoctrine()->getManager(); 
        $book = $this->rechercheBook();
        $messages = $this->rechercheMessagePanal();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $panier = $this->recherchePanier();
        $notif = $this->rechercheNotifPanal();
        $contact = new Contact();
        $form = $this->createForm('Medical\MedicalBundle\Form\ContactType', $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setEtatCont('non lu');
            $contact->setEmailRecu('admin@gmail.com');
            $em->persist($contact);
            $em->flush();
        }

        return $this->render('contact/new.html.twig', array(
                    'contact' => $contact,
                    'form' => $form->createView(),
                    'nb' => $nb,
                    'mb' => $mb,
                    'panier' => $panier,
                    'messages' => $messages,
                    'notifs' => $notif,
                    'book' => $book
        ));
    }

    /**
     * Finds and displays a Contact entity.
     *
     */
    public function showAction(Contact $contact) {
        $deleteForm = $this->createDeleteForm($contact);

        return $this->render('contact/show.html.twig', array(
                    'contact' => $contact,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Contact entity.
     *
     */
    public function editAction(Request $request, Contact $contact) {
        $deleteForm = $this->createDeleteForm($contact);
        $editForm = $this->createForm('Medical\MedicalBundle\Form\ContactType', $contact);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('contact_edit', array('id' => $contact->getId()));
        }

        return $this->render('contact/edit.html.twig', array(
                    'contact' => $contact,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Contact entity.
     *
     */
    public function deleteAction(Request $request, Contact $contact) {
        $form = $this->createDeleteForm($contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contact);
            $em->flush();
        }

        return $this->redirectToRoute('medical_homepage');
    }

    /**
     * Creates a form to delete a Contact entity.
     *
     * @param Contact $contact The Contact entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contact $contact) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('contact_delete', array('id' => $contact->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
