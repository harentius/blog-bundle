<?php

namespace Harentius\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    /**
     * @return Response
     */
    public function aboutAction()
    {
        return $this->render('@HarentiusBlog/Page/about.html.twig');
    }
}
