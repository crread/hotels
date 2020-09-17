<?php

namespace App\Form;

use App\Entity\Hotel;
use App\Form\RoomNewFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class HotelsNewFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('street')
            ->add('img', FileType::class, 
                [ 'mapped' => false ,
                  'required' => false ,
                  'constraints' => 
                    [
                      new File([    'maxSize' => '16M',
                                    'mimeTypes' => 
                                    [
                                        'application/pdf',
                                        'application/x-pdf'
                                    ]
                                ])
                    ],
                ] )
            ->add('country')
            ->add('rooms', CollectionType::class, 
                    [ 
                        'entry_type' => RoomNewFormType::class, 
                        'entry_options' => ['label' => false],
                        'allow_add' => true,
                        'allow_delete' => true,
                    ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
        ]);
    }
}
