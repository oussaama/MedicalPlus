<?php

namespace Medical\MedicalBundle\Controller\menu;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MenuBeautyController extends Controller {

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

    public function indexBeautyAction() {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $article = $this->rechercheArticle();
        return $this->render('MedicalMedicalBundle:Beauty:homeBeauty.html.twig', array('articles' => $article, 'nb' => $nb, 'mb' => $mb));
    }

    private function verifAjout() {
        $em = $this->getDoctrine()->getManager();
        $m = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $query = $em->createQuery(
                        'SELECT(u.dateSoin)
                        FROM MedicalMedicalBundle:Soin u
                        WHERE u.entrepriseSoin = :l 
                        ORDER BY u.dateSoin DESC')
                ->setParameter('l', $m)
                ->setMaxResults(1);

        return $query->getResult();
    }

    public function caresAction() {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
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
        $cares = $em->getRepository('MedicalMedicalBundle:Soin')->findByEntrepriseSoin($id);
        return $this->render('MedicalMedicalBundle:Beauty:cares.html.twig', array('cares' => $cares, 'nb' => $nb, 'mb' => $mb, 'x' => $x));
    }

    private function verifPromo() {
        $em = $this->getDoctrine()->getManager();
        $m = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $query = $em->createQuery(
                        'SELECT u.datePr
                        FROM MedicalMedicalBundle:Promo u
                        WHERE u.entreprisePr = :l 
                        ORDER BY u.datePr DESC')
                ->setParameter('l', $m)
                ->setMaxResults(1);

        return $query->getResult();
    }

    public function promoAction() {
        $em = $this->getDoctrine()->getManager();
        $d = $this->verifPromo();
        if ($d) {
            $datetime1 = new \DateTime($this->verifPromo()[0]['datePr']->format("Y-m-d h:i:s"));
            $datetime2 = new \DateTime();
            $interval = (int) $datetime1->diff($datetime2)->format('%a');
            $interval2 = $datetime1->modify("+1 days")->diff($datetime2)->format('%h Hours %i Minute %s Seconds');
        }
        $id = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $user = $em->getRepository("MedicalMedicalBundle:User")->findOneById($id);
        if ($user->getClass() == "premium") {
            $c = 5;
        } else if ($user->getClass() == "ultra") {
            $c = 10;
        } else {
            $c = 0;
        }
        $x = 0;
        if ($user->getClass() == Null) {
            $this->get('session')->getFlashBag()->add('echec', "il faut un membre premium ");
        } else if ($user->getNbpromo() > 0) {
            $x = 1;
            $this->get('session')->getFlashBag()->add('info', "il reste " . $user->getNbpromo() . " promo pour ajouter");
        } else if ($interval >= 1 && $user->getNbpromo() >= 0) {
            $x = 1;
            $user->setNbpromo($c);
            $em->persist($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', "it remains " . $user->getNbpromo() . " promoto add");
        } else if ($datetime1 == Null && $user->getClass() != Null) {
            $x = 1;
        } else if ($user->getNbpromo() == 0) {
            if ($this->getRequest()->getLocale() == "fr") {
                $interval2 = $datetime1->modify("+1 days")->diff($datetime2)->format('%h Heures %i Minute %s Seconds');
                $this->get('session')->getFlashBag()->add('echec', "il reste $interval2 pour ajouter nouveaux promotion ");
            } else {
                $interval2 = $datetime1->modify("+1 days")->diff($datetime2)->format('%h Hours %i Minute %s Seconds');
                $this->get('session')->getFlashBag()->add('echec', "it $interval2 remains to add new promotion");
            }
        }
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $promos = $em->getRepository('MedicalMedicalBundle:Promo')->findByEntreprisePr($id);
        return $this->render('::Layout/promo.html.twig', array('promos' => $promos, 'nb' => $nb, 'mb' => $mb, 'x' => $x));
    }

    public function promoShowAction($id) {
        $em = $this->getDoctrine()->getManager();
        $promo = $em->getRepository("MedicalMedicalBundle:Promo")->findOneById($id);
        return $this->render('promo/show.html.twig', array('promo' => $promo));
    }

    public function promoModifAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $promo = $em->getRepository("MedicalMedicalBundle:Promo")->findOneById($id);
        $editForm = $this->createForm('Medical\MedicalBundle\Form\PromoTypeEdit', $promo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            return $this->redirectToRoute('promo_show', array('id' => $promo->getId()));
        }

        return $this->render('promo/edit.html.twig', array(
                    'promo' => $promo,
                    'edit_form' => $editForm->createView(),
        ));
    }

    public function promoSuppAction($id) {
        $em = $this->getDoctrine()->getManager();
        $promo = $em->getRepository("MedicalMedicalBundle:Promo")->findOneById($id);
        $em->remove($promo);
        $em->flush();
        return $this->redirectToRoute('medical_promo');
    }

}
