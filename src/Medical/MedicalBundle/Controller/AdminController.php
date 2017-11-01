<?php

namespace Medical\MedicalBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Medical\MedicalBundle\Entity\Notification;
use Medical\MedicalBundle\Entity\Contact;

class AdminController extends Controller {

    private function recherche($recherche) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        'SELECT u
                        FROM MedicalMedicalBundle:User u
                        WHERE u.role = :x OR u.firstName like :x OR u.lastName like :x OR u.username= :x OR u.tel= :x OR u.state like :x OR u.code= :x OR u.year= :x 
                        ORDER BY u.lastLogin DESC')
                ->setParameter('x', $recherche);

        return $query->getResult();
    }

    private function nombreVisiteur() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                'SELECT Count(u)
                        FROM MedicalMedicalBundle:User u');

        return $query->getResult();
    }
    
    private function nombreSoin() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                'SELECT Count(u)
                        FROM MedicalMedicalBundle:Soin u');
         return $query->getResult();
    }
    
    private function nombreMed() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                'SELECT Count(u)
                        FROM MedicalMedicalBundle:Medicament u');

        return $query->getResult();
    }
    
    private function nombreLab() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                'SELECT Count(u)
                        FROM MedicalMedicalBundle:Bilan u');

        return $query->getResult();
    }

    private function nombreVisiteurM() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                'SELECT Count(u)
                            FROM MedicalMedicalBundle:User u
                            WHERE u.sex= :h ')
                            ->setParameter('h','h');

        return $query->getResult();
    }

    private function nombreVisiteurF() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                            'SELECT Count(u)
                            FROM MedicalMedicalBundle:User u
                            WHERE u.sex= :f ')
                            ->setParameter('f','f');

        return $query->getResult();
    }
    
    private function nombreVisiteurW() {
        $em = $this->getDoctrine()->getManager();
        $d = Date('Y-m-d',strtotime('-7 days'));
        $query = $em->createQuery(
                            'SELECT u.createDt ,count(u) AS nb
                            FROM MedicalMedicalBundle:User u
                            WHERE u.createDt>=  :d
                            GROUP BY u.createDt
                            ORDER BY u.createDt DESC')
                            ->setParameter('d',$d)
                            ->setMaxResults('7');

        return $query->getResult();
    }
    
     private function nombreArticle() {
        $em = $this->getDoctrine()->getManager();
        $d = Date('Y-m-d',strtotime('-7 days'));
        $query = $em->createQuery(
                            'SELECT u.dateArt ,count(u) AS nb
                            FROM MedicalMedicalBundle:Article u
                            WHERE u.dateArt>=  :d
                            GROUP BY u.dateArt
                            ORDER BY u.dateArt DESC')
                            ->setParameter('d',$d)
                            ->setMaxResults('7');

        return $query->getResult();
    }
    
    private function nombreReg(){
         $em = $this->getDoctrine()->getManager();
         $query = $em->createQuery("SELECT u.state,Count(u) AS nb
                                    FROM MedicalMedicalBundle:User u 
                                    where u.state IS NOT NULL
                                    Group by u.state");
          return $query->getResult();
    }

    private function nombreVisiteurRole() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT count(u)
                                    FROM MedicalMedicalBundle:User u
                                    WHERE u.role>0
                                    group by u.role');
        return $query->getResult();
    }

    private function rechercheMessage() {
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

    private function rechercheNotification() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        'SELECT a.auteur ,a.titre ,c.nomCat,u.picture,a.etatArt,a.id
                        FROM MedicalMedicalBundle:Article a,MedicalMedicalBundle:Categorie c,MedicalMedicalBundle:User u
                        WHERE a.auteurId=u.id And a.categorieArt=c.id 
                        ORDER BY a.dateArt DESC')
                ->setMaxResults(3);

        return $query->getResult();
    }

    private function rechercheInbox() {
        $em = $this->getDoctrine()->getManager();
        $admin = $this->container->get('security.token_storage')->getToken()->getUser()->getEmail();
        $query = $em->createQuery(
                        'SELECT u.picture,c.firstnameCont,c.lastnameCont,c.dateCont,c.subjectCont,c.etatCont,c.id,c.emailCont
                        FROM MedicalMedicalBundle:User u,MedicalMedicalBundle:Contact c
                        WHERE u.email = c.emailCont And c.emailCont != :admin
                        ORDER BY c.dateCont DESC')
                ->setParameter('admin', $admin);

        return $query->getResult();
    }

    private function rechercheFilter($filter) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        'SELECT u
                        FROM MedicalMedicalBundle:User u
                        WHERE u.role = :role
                        ORDER BY u.lastLogin DESC')
                ->setParameter('role', $filter);

        return $query->getResult();
    }

    private function rechercheUser() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                'SELECT u
                        FROM MedicalMedicalBundle:User u
                        WHERE u.role >0
                        ORDER BY u.lastLogin DESC');
        return $query->getResult();
    }

    public function indexAction() {
        $nr = $this->nombreVisiteurRole();
        $nt = $this->nombreVisiteur()[0][1];
        $nm = $this->nombreVisiteurM()[0][1];
        $nf = $this->nombreVisiteurF()[0][1];
        $s = $this->nombreSoin()[0][1];
        $m = $this->nombreMed()[0][1];
        $b = $this->nombreLab()[0][1];
        $ng= $this->nombreReg();
        $nwe = $this->nombreVisiteurW();
        $mails = $this->rechercheMessage();
        $articles = $this->rechercheNotification();
        return $this->render('MedicalMedicalBundle:Admin:home.html.twig', array('mails' => $mails, 'articles' => $articles, 'nr' => $nr, 'nt' => $nt, 'nm' => $nm, 'nw' => $nf,'ng'=>$ng,'nwe'=>$nwe,'s'=>$s,'m'=>$m,'b'=>$b));
    }

    public function inboxAction() {
        $em = $this->getDoctrine()->getManager();
        $nbun= $em->getRepository('MedicalMedicalBundle:Contact')->findBy(array('etatCont'=>'non lu','emailRecu'=>'admin@gmail.com'));
        $messages = $this->get('knp_paginator')->paginate($this->rechercheInbox(), $this->get('request')->query->get('page', 1), 10);
        $mails = $this->rechercheMessage();
        $articles = $this->rechercheNotification();
        return $this->render('MedicalMedicalBundle:Admin:inbox.html.twig', array('mails' => $mails, 'articles' => $articles, 'messages' => $messages, 'indice' => 1,'nbun'=>count($nbun)));
    }

    public function sendAction() {
        $admin = $this->container->get('security.token_storage')->getToken()->getUser()->getEmail();
        $message = $this->getDoctrine()->getRepository("MedicalMedicalBundle:Contact")->findByEmailCont($admin,array('id' => 'desc'));
        $messages = $this->get('knp_paginator')->paginate($message, $this->get('request')->query->get('page', 1), 10);
        $mails = $this->rechercheMessage();
        $articles = $this->rechercheNotification();
        return $this->render('MedicalMedicalBundle:Admin:inbox.html.twig', array('mails' => $mails, 'articles' => $articles, 'messages' => $messages, 'indice' => 0,'nbun'=>0));
    }

    public function messageAction($id, $email) {
        $em = $this->getDoctrine()->getManager();
        $nbun= $em->getRepository('MedicalMedicalBundle:Contact')->findBy(array('etatCont'=>'non lu','emailRecu'=>'admin@gmail.com'));
        $em = $this->getDoctrine()->getManager();
        $mail = $em->getRepository("MedicalMedicalBundle:Contact")->findById($id);
        $user = $em->getRepository("MedicalMedicalBundle:User")->findByEmail($email);
        $mails = $this->rechercheMessage();
        $articles = $this->rechercheNotification();
        $message = $em->getRepository("MedicalMedicalBundle:Contact")->findOneById($id);
        $message->setEtatCont("lu");
        $em->flush();
        return $this->render('MedicalMedicalBundle:Admin:message.html.twig', array('mail' => $mail, 'user' => $user, 'mails' => $mails, 'articles' => $articles,'nbun'=>count($nbun)));
    }

    public function composeAction() {
        $em = $this->getDoctrine()->getManager();
        $nbun= $em->getRepository('MedicalMedicalBundle:Contact')->findBy(array('etatCont'=>'non lu','emailRecu'=>'admin@gmail.com'));
        $articles = $this->rechercheNotification();
        $mails = $this->rechercheMessage();
        return $this->render('MedicalMedicalBundle:Admin:compose.html.twig', array('mails' => $mails, 'articles' => $articles,'nbun'=>count($nbun)));
    }

    public function sendMessageAction(Request $request) {
        $admin = $this->container->get('security.token_storage')->getToken()->getUser();
        $contact = new Contact();
        $contact->setFirstnameCont($admin->getFirstname());
        $contact->setLastNameCont($admin->getLastname());
        $contact->setEmailCont($admin->getEmail());
        $contact->setEmailRecu($request->get('To'));
        $contact->setDateCont(new \DateTime());
        $contact->setEtatCont("non lu");
        $contact->setSubjectCont($request->get('subject'));
        $contact->setContenuCont($request->get('contenu'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Article ajouté avec succès');

        return $this->redirect($this->generateUrl('admin_inbox'));
    }

    public function userAction() {
        $articles = $this->rechercheNotification();
        $mails = $this->rechercheMessage();
        $users = $this->get('knp_paginator')->paginate($this->rechercheUser(), $this->get('request')->query->get('page', 1), 16);
        return $this->render('MedicalMedicalBundle:Admin:user.html.twig', array('users' => $users, 'mails' => $mails, 'articles' => $articles));
    }

    public function articleAction() {
        $em = $this->getDoctrine()->getManager();
        $articles = $this->rechercheNotification();
        $mails = $this->rechercheMessage();
        $article = $em->getRepository("MedicalMedicalBundle:Article")->findAll();
        return $this->render('MedicalMedicalBundle:Admin:article.html.twig', array('mails' => $mails, 'article' => $article, 'articles' => $articles));
    }

    public function billAction() {
        $em = $this->getDoctrine()->getManager();
        $articles = $this->rechercheNotification();
        $factures = $em->createQuery('select u.id,u.entrepriseFact,u.classFact,u.prixFact,u.dateFact,u.telFact,u.emailFact from MedicalMedicalBundle:Facture u')->getResult();
        $mails = $this->rechercheMessage();
        return $this->render('MedicalMedicalBundle:Admin:bill.html.twig', array('mails' => $mails, 'factures' => $factures, 'articles' => $articles));
    }

    public function editArticleAction($id) {
        $em = $this->getDoctrine()->getManager();
        $mails = $this->rechercheMessage();
        $article = $em->getRepository("MedicalMedicalBundle:Article")->findById($id);
        $articles = $this->rechercheNotification();
        return $this->render('::admin/editArticle.html.twig', array('article' => $article, 'mails' => $mails, 'articles' => $articles));
    }

    public function addArticleAction($id, $etat) {
        $notification = new Notification();
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository("MedicalMedicalBundle:Article")->findOneById($id);
        $email = $this->container->get('security.token_storage')->getToken()->getUser()->getEmail();
        $expediteur = $em->getRepository("MedicalMedicalBundle:User")->findOneById($article->getAuteurId())->getEmail();
        $notification->setEtatNot("non lu");
        $notification->setExpediteur($expediteur);
        $notification->setDestinateur($email);
        $notification->setSujetNot("articale " . $etat);
        $notification->setContenuNot("articale" . $article->getTitre() . " is " . $etat);
        if ($etat == "refused") {
            $patient = $em->getRepository("MedicalMedicalBundle:User")->findOneById($article->getAuteurId());
            $patient->setNombre($patient->getNombre() + 1);
        }
        $article->setEtatArt($etat);
        $em->persist($notification);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_article'));
    }

    public function filterAction($filter) {
        $articles = $this->rechercheNotification();
        $users = $this->get('knp_paginator')->paginate($this->rechercheFilter($filter), $this->get('request')->query->get('page', 1), 16);
        $mails = $this->rechercheMessage();
        return $this->render('MedicalMedicalBundle:Admin:user.html.twig', array('users' => $users, 'mails' => $mails, 'articles' => $articles));
    }

    public function rechercheAction(Request $request) {
        $articles = $this->rechercheNotification();
        $users = $this->get('knp_paginator')->paginate($this->recherche($request->get('recherche')), $this->get('request')->query->get('page', 1), 16);
        $mails = $this->rechercheMessage();
        return $this->render('MedicalMedicalBundle:Admin:user.html.twig', array('users' => $users, 'mails' => $mails, 'articles' => $articles));
    }

    public function rechercheArticleAction() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        'SELECT COUNT(a)
                        FROM MedicalMedicalBundle:Article a
                        WHERE a.etatArt = :l')
                ->setParameter('l', 'waiting');

        $nb = $query->getSingleResult();

        return new JsonResponse(array('not' => $nb));
    }

}
