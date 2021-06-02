<?php

namespace App\Form;

use App\Entity\Manga;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title:*',
                'required' => true
            ])
            ->add('status', EntityType::class, [
                'label' => 'Status:',
                'class' => Status::class,
                'placeholder' => 'Choose a status',
                'choice_label' => 'status',
                'expanded'=>false,
                'multiple'=>false,
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Note:',
            ])
            ->add('rating', IntegerType::class, [
                'label' => 'Rating:'
            ])
            ->add('imageFile', FileType::class,[
                'required'=>false,
                'label'=> 'Manga image',
                'attr'=>['onchange="loadFile(event)"'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Manga::class,
        ]);
    }
}
