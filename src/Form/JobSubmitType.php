<?php

namespace App\Form;

use App\Entity\JobSubmit;
use App\Entity\Task;
use App\Factory\TaskFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobSubmitType extends AbstractType
{
    private $taskFactory;

    public function __construct(TaskFactory $taskFactory)
    {
        $this->taskFactory = $taskFactory;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'required' => false,
            ])
            ->add('repo', UrlType::class, [
                'default_protocol' => 'https',
                'empty_data' => 'https://',
            ])
            ->add('branch', TextType::class)
            ->add('environment', ChoiceType::class, [
                'choices' => [
                    'PHP 8.0' => 'PHP80',
                    'PHP 7.4' => 'PHP74',
                    'PHP 7.3' => 'PHP73',
                ],
            ])
            ->add('tasks', ChoiceType::class, [
                'choice_label' => function (Task $task) {
                    return $task->getLabel();
                },
                'choice_value' => function (Task $task) {
                    return $task->getTool();
                },
                'group_by' => function (Task $task) {
                    return $task->getGroup();
                },
                'choices' => $this->taskFactory->getTasks(),
                'multiple' => true,
                'expanded' => true,
                'required' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Submit Job']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JobSubmit::class,
        ]);
    }
}
