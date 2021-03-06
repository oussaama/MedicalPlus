<?php

/**
 * @copyright  Copyright (c) 2009-2014 Steven TITREN - www.webaki.com
 * @package    Webaki\UserBundle\Redirection
 * @author     Steven Titren <contact@webaki.com>
 */

namespace Medical\MedicalBundle\Redirection;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface {

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router) {
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        // Get list of roles for current user
        $roles = $token->getRoles();
        // Tranform this list in array
        $rolesTab = array_map(function($role) {
            return $role->getRole();
        }, $roles);
        if (in_array('ROLE_PATIENT', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('Patient_homepage'));
        else if (in_array('ROLE_CABINE', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('Cabine_homepage'));
        else if (in_array('ROLE_PHARMACY', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('Pharmacy_homepage'));
        else if (in_array('ROLE_LABORATORY', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('Laboratory_homepage'));
        else if (in_array('ROLE_BEAUTY', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('Beauty_homepage'));
        else if (in_array('ROLE_ADMIN', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('admin_homepage'));
        else
            $redirection = new RedirectResponse($this->router->generate('medical_homepage'));
        return $redirection;
    }

}
