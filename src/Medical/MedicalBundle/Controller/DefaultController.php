<?php

namespace Medical\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Medical\MedicalBundle\Entity\Article;
use Medical\MedicalBundle\Form\ArticleType;
use Medical\MedicalBundle\Form\PatientFormType;
use Medical\MedicalBundle\Form\PharmacyFormType;
use Medical\MedicalBundle\Form\BeautyFormType;
use Medical\MedicalBundle\Form\LaboratoryFormType;
use Medical\MedicalBundle\Form\CabineFormType;
use Medical\MedicalBundle\Entity\Facture;
use Medical\MedicalBundle\Entity\Commentaire;
use Medical\MedicalBundle\Entity\Categorie;
use Medical\MedicalBundle\Entity\Promo;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('MedicalMedicalBundle:Default:index.html.twig');
    }

    public function langAction($locale) {
        $this->getRequest()->setLocale($locale);
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

    private function rechercheCategorie($categorie) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        'SELECT u.username,a.id,a.titre,a.photoArt,a.dateArt,a.contenuArt,c.nomCat
                        FROM MedicalMedicalBundle:User u,MedicalMedicalBundle:Article a,MedicalMedicalBundle:Categorie c 
                        WHERE u.id=a.auteurId AND a.etatArt= :e AND a.categorieArt=c.id AND c.nomCat= :c 
                        ORDER BY a.dateArt DESC')
                ->setParameter('e', 'approve')
                ->setParameter('c', $categorie);
        $panier = $query->getResult();
        return $panier;
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

    private function rechercheSimulArticle($categorie, $id) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        'SELECT u.email,u.username,a.id,a.titre,a.photoArt,a.dateArt,a.contenuArt,c.nomCat
                        FROM MedicalMedicalBundle:User u,MedicalMedicalBundle:Article a,MedicalMedicalBundle:Categorie c 
                        WHERE u.id=a.auteurId AND a.etatArt= :e AND a.categorieArt=c.id AND c.nomCat= :c AND a.id != :id
                        ORDER BY a.dateArt DESC')
                ->setParameter('e', 'approve')
                ->setParameter('c', $categorie)
                ->setParameter('id', $id)
                ->setMaxResults(3);
        $panier = $query->getResult();
        return $panier;
    }

    private function rechercheArticle() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        'SELECT u.email,u.username,a.id,a.titre,a.photoArt,a.dateArt,a.contenuArt,c.nomCat,a.commentaireArt
                        FROM MedicalMedicalBundle:User u,MedicalMedicalBundle:Article a,MedicalMedicalBundle:Categorie c 
                        WHERE u.id=a.auteurId AND a.etatArt= :e AND a.categorieArt=c.id 
                        ORDER BY a.dateArt DESC')
                ->setParameter('e', 'approve');
        $panier = $query->getResult();
        return $panier;
    }

    private function rechercheCommentaire($id) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        'SELECT u.picture,c.dateCom,c.commentaire,u.username
                        FROM MedicalMedicalBundle:User u,MedicalMedicalBundle:Commentaire c
                        WHERE u.id=c.utilisateurCom And c.articleCom= :id And c.typeCom= :type
                        ORDER BY c.dateCom DESC')
                ->setParameter('id', $id)
                ->setParameter('type', 'article');
        $commentaires = $query->getResult();

        return $commentaires;
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

    public function newsAction() {
        $messages = $this->rechercheMessagePanal();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $panier = $this->recherchePanier();
        $notif = $this->rechercheNotifPanal();
        $book = $this->rechercheBook();
        $articles = $this->get('knp_paginator')->paginate($this->rechercheArticle(), $this->get('request')->query->get('page', 1), 6);
        return $this->render('::Layout/news.html.twig', array('articles' => $articles, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif, 'book' => $book));
    }

    public function modifProfilAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
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
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirectToRoute('profil', array('id' => $entity->getId()));
        }
        return $this->render('::Layout/modifprofil.html.twig', array('entity' => $entity, 'form' => $form->createView()));
    }

    public function notificationAction() {
        $em = $this->getDoctrine()->getManager();
        $panier = $this->recherchePanier();
        $mb = $this->rechercheMessage();
        $nb = $this->rechercheNotif();
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $book = $this->rechercheBook();
        $email = $this->get('security.token_storage')->getToken()->getUser()->getEmail();
        $notifs = $em->getRepository('MedicalMedicalBundle:Notification')->findBy(array('destinateur' => $email));
        foreach ($notifs as $n) {
            $n->setEtatNot("lu");
            $em->persist($n);
        }
        $em->flush();
        return $this->render('::Layout/notification.html.twig', array('notif' => $notifs, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif, 'book' => $book));
    }

    public function messageAction() {
        $em = $this->getDoctrine()->getManager();
        $panier = $this->recherchePanier();
        $notif = $this->rechercheNotifPanal();
        $messages = $this->rechercheMessagePanal();
        $email = $this->get('security.token_storage')->getToken()->getUser()->getEmail();
        $message = $em->getRepository('MedicalMedicalBundle:Contact')->findByEmailRecu($email);

        foreach ($message as $m) {
            $m->setEtatCont("lu");
            $em->persist($m);
        }
        $em->flush();
        $mb = $this->rechercheMessage();
        $nb = $this->rechercheNotif();
        $book = $this->rechercheBook();
        return $this->render('::Layout/message.html.twig', array('message' => $message, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif, 'book' => $book));
    }

    public function aboutAction() {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $panier = $this->recherchePanier();
        $book = $this->rechercheBook();
        return $this->render('::Layout/about.html.twig', array('mb' => $mb, 'nb' => $nb, 'panier' => $panier, 'messages' => $messages, 'notifs' => $notif, 'book' => $book));
    }

    public function deactiveAction() {
        return $this->render('::Layout/deactive.html.twig');
    }

    public function deleteAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $findUser = $em->getRepository('MedicalMedicalBundle:User')->find($user);
        $findUser->setLocked(true);
        $em->flush();
        return $this->redirectToRoute('fos_user_security_logout');
    }

    public function addArticleAction() {
        $form = $this->createForm(new ArticleType());
        return $this->render('::Layout/addArticle.html.twig', array('form' => $form->createView()));
    }

    public function articleAction(Request $request) {
        $article = new Article();
        $form = $this->createForm('Medical\MedicalBundle\Form\ArticleType', $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $categorie = $em->getRepository("MedicalMedicalBundle:Categorie")->findOneByNomCat($form->getData()->getCategorieArt());
            $id = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $article->uploads();
            $article->setEtatArt('waiting');
            $article->setAuteurId($id);
            if (!$categorie) {
                $category = new Categorie();
                $category->setNomCat($form->getData()->getCategorieArt());
                $categorie->setTypeCat("article");
                $em->persist($category);
                $em->flush();
            } else {
                $article->setCategorieArt($categorie->getId());
            }
            $article->setCategorieArt($category->getId());
            $em->persist($article);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Article ajouté avec succès');
        } else {
            $this->get('session')->getFlashBag()->add('echec', 'Article ajouté avec echec');
        }
        return $this->redirectToRoute('medical_news');
    }

    public function formClassAction($price, $type) {
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $book = $this->rechercheBook();
        return $this->render('::Layout/payment.html.twig', array('price' => $price, 'type' => $type, 'nb' => $nb, 'mb' => $mb, 'messages' => $messages, 'notifs' => $notif, 'book' => $book));
    }

    public function classPaidAction(Request $request, $price, $type) {
        $em = $this->getDoctrine()->getManager();
        $id = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $facture = new Facture();
        $facture->setEntrepriseFact($id);
        $facture->setEmailFact($request->get('billing_email'));
        $facture->setTelFact((int)$request->get('billing_phone'));
        $facture->setClassFact($type);
        $facture->setPrixFact($price);
        $facture->setDateFact(new \DateTime());
        $facture->setTypeFact(0);
        $user = $em->getRepository("MedicalMedicalBundle:User")->findOneById($id);
        if ($type == "premium") {
            $user->setNombre(5);
            $user->setClass("premium");
            if($user->getRole()==3 ||$user->getRole()==4 ){
                $user->setNbprod(10);
                $user->setNbpromo(1);
            }else if($user->getRole()==5){
                $user->setNbprod(5);
            }
        } else {
            $user->setClass("ultra");
            $user->setNombre(20);
            if($user->getRole()==3 ||$user->getRole()==4 ){
                $user->setNbprod(50);
                $user->setNbpromo(5);
            }else if($user->getRole()==5){
                $user->setNbprod(10);
            }
        }
        $em->persist($user);
        $em->persist($facture);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Article ajouté avec succès');
        $html = $this->renderView('MedicalMedicalBundle:Default:pdf.html.twig', array(
            'id' => $facture->getId(),
            'dateFact' => $facture->getDateFact(),
            'entrepriseFact' => $facture->getEntrepriseFact(),
            'emailFact' => $facture->getEmailFact(),
            'telFact' => $facture->getTelFact(),
            'classFact' => $facture->getClassFact(),
            'prixFact' => $facture->getPrixFact()
        ));
        $html2pdf = $this->get('html2pdf_factory')->create();
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
         $message = \Swift_Message::newInstance()
        ->setSubject('upgrade premium')
        ->setFrom('akroutiioussama@gmail.com')
        ->setTo($request->get('billing_email'))
        ->setBody($this->renderView('MedicalMedicalBundle:Default:mail.html.twig',array('id' => $facture->getId(),
            'dateFact' => $facture->getDateFact(),
            'telFact' => $facture->getTelFact(),
            'classFact' => $facture->getClassFact(),
            'prixFact' => $facture->getPrixFact())),'text/html');
         
    $this->get('mailer')->send($message);
        
        
        return new Response($html2pdf->Output('facture.pdf'), 200, array('Content-Type' => 'application/pdf'));
    }

    public function newsArticleAction($id, $user, $categorie) {
        $em = $this->getDoctrine()->getManager();
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $panier = $this->recherchePanier();
        $book = $this->rechercheBook();
        $articles = $this->rechercheSimulArticle($categorie, $id);
        $commentaires = $this->rechercheCommentaire($id);
        $article = $em->getRepository("MedicalMedicalBundle:Article")->findOneById($id);
        $patient = $em->getRepository("MedicalMedicalBundle:User")->findOneById($article->getAuteurId());
        $patient->setNombre($patient->getNombre() - 1);
        $em->flush();
        return $this->render('::Layout/article.html.twig', array('nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'user' => $user, 'article' => $article, 'categorie' => $categorie, 'articles' => $articles, 'commentaires' => $commentaires, 'messages' => $messages, 'notifs' => $notif, 'book' => $book));
    }

    public function commentaireAction(Request $request, $id, $user, $categorie) {
        $em = $this->getDoctrine()->getManager();
        $patient = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $commentaire = new Commentaire();
        $commentaire->setArticleCom($id);
        $commentaire->setUtilisateurCom($patient);
        $commentaire->setCommentaire($request->get('comment'));
        $commentaire->setTypeCom('article');
        $commentaire->setDateCom(new \DateTime());
        $article = $em->getRepository("MedicalMedicalBundle:Article")->findOneById($id);
        $article->setCommentaireArt($article->getCommentaireArt() + 1);
        $em->persist($commentaire);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'commentaire ajouté avec succès');
        return $this->redirectToRoute('medical_news_article', array('user' => $user, 'id' => $id, 'categorie' => $categorie));
    }

    public function newsCategorieAction($categorie) {
        $articles = $this->get('knp_paginator')->paginate($this->rechercheCategorie($categorie), $this->get('request')->query->get('page', 1), 9);
        $nb = $this->rechercheNotif();
        $mb = $this->rechercheMessage();
        $messages = $this->rechercheMessagePanal();
        $notif = $this->rechercheNotifPanal();
        $panier = $this->recherchePanier();
        return $this->render('::Layout/news.html.twig', array('articles' => $articles, 'nb' => $nb, 'mb' => $mb, 'panier' => $panier, 'messages' => $messages));
    }

    public function nbrMessageAction() {
        $em = $this->getDoctrine()->getManager();
        $patient = $this->container->get('security.token_storage')->getToken()->getUser()->getEmail();
        $query = $em->createQuery(
                        'SELECT COUNT(c)
                        FROM MedicalMedicalBundle:Contact c
                        WHERE c.etatCont = :l AND c.emailRecu= :email')
                ->setParameter('l', 'non lu')
                ->setParameter('email', $patient);

        $nb = $query->getSingleResult();
        return new JsonResponse(array('nb' => $nb));
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

    public function nbrBookAction() {
        $em = $this->getDoctrine()->getManager();
        $docteurId = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $rendez = $em->createQuery(
                        'SELECT COUNT(p)
                            FROM MedicalMedicalBundle:RendezVous p
                            WHERE p.etatRv = :l AND p.idDocteur= :id')
                ->setParameter('l', 'reserved')
                ->setParameter('id', $docteurId);

        $mb = $rendez->getSingleResult();
        return new JsonResponse(array('mb' => $mb));
    }

    public function rechercheNotAction() {
        $em = $this->getDoctrine()->getManager();
        $patient = $this->container->get('security.token_storage')->getToken()->getUser()->getEmail();
        $query = $em->createQuery(
                        'SELECT COUNT(n)
                        FROM MedicalMedicalBundle:Notification n
                        WHERE n.etatNot = :l AND n.destinateur= :email')
                ->setParameter('l', 'non lu')
                ->setParameter('email', $patient);

        $nb = $query->getSingleResult();

        return new JsonResponse(array('not' => $nb));
    }

    public function rechercheMessagePanalAction() {
        $em = $this->getDoctrine()->getManager();
        $admin = $this->container->get('security.token_storage')->getToken()->getUser()->getEmail();
        $query = $em->createQuery(
                        'SELECT u.picture,c.firstnameCont,c.lastnameCont,c.dateCont,c.subjectCont,c.etatCont,c.id,c.emailCont
                        FROM MedicalMedicalBundle:User u,MedicalMedicalBundle:Contact c
                        WHERE u.email = c.emailCont And c.emailRecu = :admin
                        ORDER BY c.dateCont DESC')
                ->setParameter('admin', $admin)
                ->setMaxResults(3);
        $message = $query->getResult();
        return new JsonResponse(array('message' => $message));
    }

    public function promoAddAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $promo = new Promo();
        $form = $this->createForm('Medical\MedicalBundle\Form\PromoType', $promo);
        $id = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $user = $em->getRepository("MedicalMedicalBundle:User")->findOneById($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $promo->uploads();
            $promo->setEntreprisePr($id);
            $promo->setDatePr(new \DateTime());
            $user->setNbpromo($user->getNbpromo()-1);
            $em->persist($user);
            $em->persist($promo);
            $em->flush();
            return $this->redirectToRoute('medical_show_promo', array('id' => $promo->getId()));
        }
        return $this->render('::Layout/addPromo.html.twig', array(
                    'promo' => $promo,
                    'form' => $form->createView(),
        ));
    }
    public function promoShowAction($id) {
        $em = $this->getDoctrine()->getManager();
        $promo = $em->getRepository("MedicalMedicalBundle:Promo")->findById($id);
        return $this->render('::Layout/showPromo.html.twig', array('promo' => $promo));
    }
    public function logoutAction(){
        $session = $this->getRequest()->getSession();
        $session->clear();
        return $this->render('MedicalMedicalBundle:Default:index.html.twig');
    }
}
