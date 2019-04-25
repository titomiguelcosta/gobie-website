<?php

namespace App\Form;

use App\Entity\JobSubmit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use Symfony\Component\Form\CallbackTransformer;
use App\Entity\Task;

class JobSubmitType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'required' => false,
            ])
            ->add('repo', UrlType::class)
            ->add('branch', TextType::class)
            ->add('tasks', ChoiceType::class, [
                'choices' => [
                    'Linter' => [
                        'Twig' => 'lint:twig',
                        'Yaml' => 'lint:yaml',
                        'Xliff' => 'lint:xliff',
                    ],
                    'Code' => [
                        'Mess Detection' => 'phpmd',
                    ],
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Submit Job']);

        $builder
            ->get('tasks')
            ->addModelTransformer(new CallbackTransformer(
                function ($tasksAsCollection) {
                    // transform the array of objects to an array of string
                    return is_array($tasksAsCollection) ? array_map(function ($task) {
                        return [$task => new Task($task)];
                    }, $tasksAsCollection) : [];
                },
                function ($tasksAsArray) {
                    // transform the array of strings back to an array of objects
                    return is_array($tasksAsArray) ? array_map(function ($task) {
                        return new Task($task);
                    }, $tasksAsArray) : [];
                }
            ));

        if ($this->security->getUser() instanceof User && $this->security->getUser()->getEmail()) {
            $builder->remove('email');
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JobSubmit::class,
        ]);
    }
}
