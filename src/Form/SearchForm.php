<?php


namespace App\Form;


use App\Data\SearchData;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => "Title :",
                'required' => false,
                'attr' => [
                    'placeholder' => 'Search'
                ]
            ])
            ->add('status', EntityType::class, [
                'label' => "Status :",
                'required' => false,
                'class' => Status::class,
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Select status'
            ])
            ->add('rating', NumberType::class, [
                'label' => "Rating :",
                'required' => false,
                'attr' => [
                    'min' => '0',
                    'max' => '10',
                    'placeholder'=>'Rating'
                ],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'POST',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}