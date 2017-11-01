<?php

namespace Medical\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Medical\MedicalBundle\Entity\Bilan;
use Medical\MedicalBundle\Form\BilanType;

/**
 * Bilan controller.
 *
 */
class BilanController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $bilans = $em->getRepository('MedicalMedicalBundle:Bilan')->findAll();

        return $this->render('bilan/index.html.twig', array(
                    'bilans' => $bilans,
        ));
    }

    /**
     * Creates a new Bilan entity.
     *
     */
    public function newAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $bilan = new Bilan();
        $form = $this->createForm('Medical\MedicalBundle\Form\BilanType', $bilan);
        $form->handleRequest($request);
        $user = $em->getRepository("MedicalMedicalBundle:User")->findOneById($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $bilan->setEntrepriseBilan($id);
            $user->setNbprod($user->getNbprod() - 1);
            $em->persist($user);
            $em->persist($bilan);
            $em->flush();

            return $this->redirectToRoute('bilan_show', array('id' => $bilan->getId()));
        }

        return $this->render('bilan/new.html.twig', array(
                    'bilan' => $bilan,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Bilan entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $bilan = $em->getRepository("MedicalMedicalBundle:Bilan")->findOneById($id);
        return $this->render('bilan/show.html.twig', array('bilan' => $bilan));
    }

    /**
     * Displays a form to edit an existing Bilan entity.
     *
     */
    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $bilan = $em->getRepository("MedicalMedicalBundle:Bilan")->findOneById($id);
        $editForm = $this->createForm('Medical\MedicalBundle\Form\BilanType', $bilan);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($bilan);
            $em->flush();

            return $this->redirectToRoute('bilan_show', array('id' => $bilan->getId()));
        }

        return $this->render('bilan/edit.html.twig', array(
                    'bilan' => $bilan,
                    'edit_form' => $editForm->createView(),'id'=>$id
        ));
    }

    /**
     * Deletes a Bilan entity.
     *
     */
    public function deleteAction(Request $request, Bilan $bilan) {
        $form = $this->createDeleteForm($bilan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bilan);
            $em->flush();
        }

        return $this->redirectToRoute('bilan_index');
    }

    /**
     * Creates a form to delete a Bilan entity.
     *
     * @param Bilan $bilan The Bilan entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bilan $bilan) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('bilan_delete', array('id' => $bilan->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
