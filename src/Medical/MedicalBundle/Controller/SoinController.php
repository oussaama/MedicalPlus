<?php

namespace Medical\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Medical\MedicalBundle\Entity\Soin;

/**
 * Soin controller.
 *
 */
class SoinController extends Controller {

    /**
     * Lists all Soin entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $soins = $em->getRepository('MedicalMedicalBundle:Soin')->findAll();

        return $this->render('MedicalMedicalBundle:Beauty:cares.html.twig', array(
                    'soins' => $soins,
        ));
    }

    /**
     * Creates a new Soin entity.
     *
     */
    public function newAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $soin = new Soin();
        $form = $this->createForm('Medical\MedicalBundle\Form\SoinType', $soin);
        $form->handleRequest($request);
        $user = $em->getRepository("MedicalMedicalBundle:User")->findOneById($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $soin->uploads();
            $soin->setEntrepriseSoin($id);
            $user->setNbprod($user->getNbprod() - 1);
            $em->persist($user);
            $em->persist($soin);
            $em->flush();

            return $this->redirectToRoute('soin_show', array('id' => $soin->getId()));
        }

        return $this->render('soin/new.html.twig', array(
                    'soin' => $soin,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Soin entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $soin = $em->getRepository("MedicalMedicalBundle:Soin")->findById($id);
        return $this->render('soin/show.html.twig', array(
                    'soin' => $soin
        ));
    }

    /**
     * Displays a form to edit an existing Soin entity.
     *
     */
    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $soin = $em->getRepository("MedicalMedicalBundle:Soin")->findOneById($id);
        $editForm = $this->createForm('Medical\MedicalBundle\Form\SoinTypeEdit', $soin);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($soin);
            $em->flush();

            return $this->redirectToRoute('soin_show', array('id' => $soin->getId()));
        }

        return $this->render('soin/edit.html.twig', array(
                    'soin' => $soin,
                    'edit_form' => $editForm->createView(),'id'=>$id
        ));
    }

    /**
     * Deletes a Soin entity.
     *
     */
    public function deleteAction(Request $request, Soin $soin) {
        $form = $this->createDeleteForm($soin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($soin);
            $em->flush();
        }

        return $this->redirectToRoute('soin_index');
    }

    private function createDeleteForm(Soin $soin) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('soin_delete', array('id' => $soin->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
