<?php

namespace App\Form;

use App\Entity\Manga;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title:*'
            ])
            ->add('note', TextType::class, [
                'label' => 'Note:'
            ])
            ->add('status', TextType::class, [
                'label' => 'Status:'
            ])
            ->add('rating', IntegerType::class, [
                'label' => 'Rating:'
            ])
//            ->add('imageFile', FileType::class,[
//                'required'=>false,
//                'label'=> 'Manga image'
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Manga::class,
        ]);
    }
}
