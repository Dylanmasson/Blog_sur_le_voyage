<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Country;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('tags')
            ->add('content', CKEditorType::class, [
                'config' => [
                    'toolbar' => 'my_toolbar_1',
                    'required' => 'true'
                ]
            ])
            ->add('image', FileType::class, ['mapped' => false, 'required' => false])
            ->add('category', EntityType::class, [
                'class' => Category::class, 'choice_label' => 'name'
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class, 'choice_label' => 'name'
            ])
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

