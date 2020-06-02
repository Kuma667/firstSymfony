<?php

namespace App\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use App\Entity\Contact;
use App\Entity\ContactPro;
//use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class EmailService{
	
	private $mailer;
	private $MY_EMAIL;
	
	public function __construct($MY_EMAIL, MailerInterface $mailer){
		$this->mailer = $mailer;
		$this->MY_EMAIL = $MY_EMAIL;
	}
	
	public function sendEmail($mail, $message){
		 $mail = (new TemplatedEmail())
            ->from($mail)
            ->to($this->MY_EMAIL)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Formulaire Contact')
            ->text('Sending emails is fun again!')
            //->html('<p>Nouveau message du site : <br>'.$message.'</p>');
		
			// path of the Twig template to render
			->htmlTemplate('email/contact.email.twig')

    		// pass variables (name => value) to the template
    		->context([
				'mail' => $mail,
				'message' => $message,
			]);

        $this->mailer->send($mail);
	}
	
	public function sendMailPro($nom, $prenom, $societe, $sujet, $mail, $message){
		$msg = (new TemplatedEmail())
            ->from($mail)
            ->to($this->MY_EMAIL)
            ->subject($sujet)
			->htmlTemplate('email/contactPro.email.twig')
    		->context([
				'nom' => $nom,
				'prenom' => $prenom,
				'societe' => $societe,
				'sujet' => $sujet,
				'mail' => $mail,
				'message' => $message,
			]);

        $this->mailer->send($msg);
		
		$accuseMail = (new TemplatedEmail())
			->from('contact@cyrilrahmoun.fr')
			->to($mail)
			->subject('Accusé de réception de votre mail')
			->htmlTemplate('email/accuse.email.twig')
			->context([
				'nom' => $nom,
				'prenom' => $prenom,
				'mail' => $mail
			]);
		
		$this->mailer->send($accuseMail);
	}
}