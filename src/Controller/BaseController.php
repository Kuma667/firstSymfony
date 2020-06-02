<?php

namespace App\Controller;

use App\Service\EmailService;
use App\Entity\Contact;
use App\Entity\ContactPro;
use App\Form\ContactProFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ContactRepository;
use App\Repository\ContactProRepository;


class BaseController extends AbstractController
{
	
	/**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('base/index.html.twig');
	}
	
	public function headerBase(){
		
		return $this->render('base/_partials/header.html.twig');
	}
	
	public function header($ROUTE_NAME){
		
		return $this->render('base/_partials/header.html.twig', [
			'ROUTE_NAME' => $ROUTE_NAME
		]);
	}
	
	public function footerBase(){
		
		return $this->render('base/_partials/footer.html.twig');
	}
	
	/**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('base/pages/about.html.twig');
	}
	
	/**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, EmailService $emailService, ContactRepository $contactRepository)
    {
		$em = $this->getDoctrine()->getManager();
		if($request->isMethod('POST')){
			
			// Récupération des inputs du formulaire
			$mail = $request->request->get('email');
			$msg = $request->request->get('message');
			
			// Création de l'objet contact à partir des variables
			$contact = (new Contact())
				->setEmail($mail)
				->setMessage($msg);
			
			// Appel de l'entité qui fait un appel BDD
			$em = $this->getDoctrine()->getManager();
			$em->persist($contact);
			$em->flush();
			//dd($contact);
			
			// Envoi de l'email
			$send = $emailService->sendEmail($mail, $msg);
			$this->addFlash('success', 'Nous avons bien reçu votre message.');
			//dd($email, $msg);
			return $this->redirectToRoute('contact');
		}
		
		// Trouver toutes les lignes de la table contact
//		$contacts = $contactRepository->findAll();
		
		// Trouver la ligne avec l'id 1
//		$contact = $contactRepository->find(1);
		// Modification de la ligne email avec l'id 1
//		$contact->setEmail('lololol@lol.fr');
		// Modification de la ligne message avec l'id 1
//		$contact->setMessage('test modif');
		// Exécution des modifs
//		$em->flush();
		
		// Suppression d'un objet
		$contact = $contactRepository->find(2);
		if($contact){
			$em->remove($contact);
			$em->flush();
		}
		
		
        return $this->render('base/pages/contact.html.twig',[
			
		]);
	}
	
	/**
     * @Route("/contact-pro", name="contactPro")
     */
	public function contactPro(Request $request, EmailService $emailService, ContactProRepository $contactProRepository){
		
		$em = $this->getDoctrine()->getManager();
		
		if($request->isMethod('POST')){
			$nom = $request->request->get('nom');
			$prenom = $request->request->get('prenom');
			$societe = $request->request->get('societe');
			$sujet = $request->request->get('sujet');
			$mail = $request->request->get('email');
			$msg = $request->request->get('message');
			
			// Création de l'objet
			$contact = (new ContactPro())
				->setNom($nom)
				->setPrenom($prenom)
				->setSociete($societe)
				->setEmail($mail)
				->setMessage($msg);
			
			// Envoi de l'objet en BDD
			$em->persist($contact);
			$em->flush();
			
			// Envoi de l'email
			$send = $emailService->sendMailPro($nom, $prenom, $societe, $sujet, $mail, $msg);
			$this->addFlash('success', 'Nous avons bien reçu votre message. Un accusé de réception vous a été envoyé à votre adresse email.');
			return $this->redirectToRoute('contactPro');
		}
		
		return $this->render('base/pages/contactPro.html.twig');
	}
	
	/**
     * @Route("/contact-pro-search", name="contactProSearch")
     */
	public function contactProSearch(ContactProRepository $contactProRepository){
//		$prenom = 'Cyril';
//		$contact = $contactProRepository->findContactByPrenom($prenom);
//		dd($contact);
		
		$date = new \DateTime('2020-05-29');
		$contact = $contactProRepository->findContactRecent($date);
		dd($contact);
		
//		$search = [
//			'prenom' = $prenom,
//			'nom' => $nom,
//			'date' => $date
//		];
		
		die();
	}
	
	/**
     * @Route("/contact", name="contact")
     */
	public function formContactPro(){
		$contact = new Contacts();
		$form = $this->createForm(ContactProFormType::class, $contact);
		
		return $this->render('base/pages/contact.html.twig',[
			'form' => $form->createView()
		]);
	}
}
