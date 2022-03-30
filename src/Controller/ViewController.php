<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ViewController extends AbstractController
{
    #[Route('/{all}', name: 'app_view')]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }
}
