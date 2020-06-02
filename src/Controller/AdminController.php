<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
	
	/**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('base/pages/admin.html.twig');
	}
}
