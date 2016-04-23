<?php

namespace Harentius\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * @return Response
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render(
            'HarentiusBlogBundle:Security:login.html.twig', [
                'last_username' => $authenticationUtils->getLastUsername(),
                'error'         => $authenticationUtils->getLastAuthenticationError(),
            ]
        );
    }

    /**
     * This controller will not be executed, as the route is handled by the Security system
     */
    public function loginCheckAction()
    {
    }
}
