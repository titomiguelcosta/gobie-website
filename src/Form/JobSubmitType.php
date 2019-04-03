<?php

namespace App\Form;

use App\Entity\JobSubmit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class JobSubmitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('repo')
            ->add('branch')
            ->add('username')
            ->add('token')
            ->add('save', SubmitType::class, ['label' => 'Submit Job']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JobSubmit::class,
        ]);
    }
}
