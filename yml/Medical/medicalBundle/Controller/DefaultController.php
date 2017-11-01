<?php

namespace Medical\medicalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('medicalBundle:Default:index.html.twig');
    }
}
