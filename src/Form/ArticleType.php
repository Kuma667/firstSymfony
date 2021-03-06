<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
				'label' => "Titre de l'article",
				'attr' => [
					'placeholder' => "Indiquez le titre...",	
				],
			])
            ->add('text', TextareaType::class, [
				'label' => "Texte de l'article",
				'attr' => [
					'rows' => 10,
					'placeholder' => "Ecrivez quelque chose...",
				],
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
