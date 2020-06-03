<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MembreController extends AbstractController
{
	
	/**
     * @Route("/membre", name="membre")
     */
    public function membre()
    {
        return $this->render('base/pages/membre.html.twig');
	}
}
