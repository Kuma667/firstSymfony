<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ArticleRepository;

class BlogController extends AbstractController
{
	
	/**
     * @Route("/blog", name="articleList")
     */
    public function articleList(ArticleRepository $articleRepository)
    {
		$articles = $articleRepository->findAll();
		
        return $this->render('base/blog/articleList.html.twig',[
			'articles' => $articles
		]);
	}
	
	/**
     * @Route("/blog/article/{id}", name="articleSingle")
     */
    public function articleSingle($id, Article $article)
    {
        return $this->render('base/blog/articleSingle.html.twig', [
			'article' => $article
		]);
	}
	
	/**
     * @Route("/blog", name="articleList")
     */
	
//	public function liste(){
//		
//		for($i = 0; $i<12; $i++){
//			$articles[] = [
//				"titre" => "Mon titre ".$i,
//				"sousTitre" => "Mon sous-titre ".$i
//			];
//		}
//		
//		return $this->render('base/blog/articleList.html.twig', [
//			"articles" => $articles
//		]);
//	}
	
	/**
     * @Route("/blog/nouvel-article", name="articleNew")
     */
    public function articleNew(Request $request)
    {
		$article = new Article();
		$form = $this->createForm(ArticleType::class, $article);
		$form->handleRequest($request);
		//dd($article, $form);
		
		if($form->isSubmitted() && $form->isValid()){
			//dd($article);
			$em = $this->getDoctrine()->getManager();
			$em->persist($article);
			$em->flush();
			$this->addFlash('success', "L'article a bien été créé");
			return $this->redirectToRoute('articleNew');
		}
		
        return $this->render('base/blog/articleNew.html.twig', [
			'form' => $form->createView()
		]);
	}
	
	/**
     * @Route("/blog/modifier-article/{id}", name="articleEdit")
     */
    public function articleEdit($id, Request $request, ArticleRepository $articleRepository)
    {
		$article = $articleRepository->find($id);
		$form = $this->createForm(ArticleType::class, $article);
		$form->handleRequest($request);
		//dd($article, $form);
		
		if($form->isSubmitted() && $form->isValid()){
			//dd($article);
			$em = $this->getDoctrine()->getManager();
			$em->persist($article);
			$em->flush();
			$this->addFlash('success', "L'article a bien été modifié");
			return $this->redirectToRoute('articleEdit', [
				'id' => $article->getId()
			]);
		}
		
        return $this->render('base/blog/articleEdit.html.twig', [
			'form' => $form->createView(),
			'article' => $article
		]);
	}
}
