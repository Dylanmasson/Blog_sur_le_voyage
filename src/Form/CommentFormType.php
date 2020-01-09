<?php

namespace App\Form;

use App\Entity\Comment;
use Doctrine\DBAL\Types\BooleanType;
use Faker\Provider\DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content');
            /*->add('created_at', DateTime::class)
            ->add('is_signaled', BooleanType::class)
            ->add('is_visible', BooleanType::class)
            ->add('comment', EntityType::class)
            ->add('article', EntityType::class)
            ->add('user', EntityType::class)
        ;*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
