<?php

namespace Harentius\BlogBundle\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController
{
    /**
     * @return Response
     */
    public function login()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('@HarentiusBlog/Security/login.html.twig', [
                'last_username' => $authenticationUtils->getLastUsername(),
                'error' => $authenticationUtils->getLastAuthenticationError(),
            ]
        );
    }

    /**
     * This controller will not be executed, as the route is handled by the Security system.
     */
    public function loginCheck()
    {
    }
}