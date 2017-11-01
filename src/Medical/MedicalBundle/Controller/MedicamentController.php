<?php

namespace Medical\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Medical\MedicalBundle\Entity\Medicament;
use Medical\MedicalBundle\Entity\Categorie;
use Faker\Provider\cs_CZ\DateTime;

/**
 * Medicament controller.
 *
 */
class MedicamentController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $medicaments = $em->getRepository('MedicalMedicalBundle:Medicament')->findAll();

        return $this->render('medicament/index.html.twig', array(
                    'medicaments' => $medicaments,
        ));
    }

    /**
     * Creates a new Medicament entity.
     *
     */
    public function newAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $medicament = new Medicament();
        $form = $this->createForm('Medical\MedicalBundle\Form\MedicamentType', $medicament);
        $user = $em->getRepository("MedicalMedicalBundle:User")->findOneById($id);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $medicament->uploads();
            $medicament->setEntrepriseMed($id);
            $user->setNbprod($user->getNbprod() - 1);
            $em->persist($user);
            $em->persist($medicament);
            $em->flush();
            return $this->redirectToRoute('medicament_show', array('id' => $medicament->getId()));
        }
        return $this->render('medicament/new.html.twig', array(
                    'medicament' => $medicament,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Medicament entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $medicament = $em->getRepository("MedicalMedicalBundle:Medicament")->findOneById($id);
        return $this->render('medicament/show.html.twig', array('medicament' => $medicament));
    }

    /**
     * Displays a form to edit an existing Medicament entity.
     *
     */
    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $medicament = $em->getRepository("MedicalMedicalBundle:Medicament")->findOneById($id);
        $editForm = $this->createForm('Medical\MedicalBundle\Form\MedicamentTypeEdit', $medicament);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('medicament_show', array('id' => $medicament->getId()));
        }

        return $this->render('medicament/edit.html.twig', array(
                    'medicament' => $medicament,
                    'edit_form' => $editForm->createView(), 'id' => $id
        ));
    }

    /**
     * Deletes a Medicament entity.
     *
     */
    public function deleteAction(Request $request, Medicament $medicament) {
        $form = $this->createDeleteForm($medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($medicament);
            $em->flush();
        }

        return $this->redirectToRoute('medicament_index');
    }

    /**
     * Creates a form to delete a Medicament entity.
     *
     * @param Medicament $medicament The Medicament entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Medicament $medicament) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('medicament_delete', array('id' => $medicament->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
