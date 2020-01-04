<?php

namespace Harentius\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    /**
     * @return Response
     */
    public function aboutAction(): Response
    {
        return $this->render('@HarentiusBlog/Page/about.html.twig');
    }
}
