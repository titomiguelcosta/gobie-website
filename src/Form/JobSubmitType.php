<?php

namespace App\Form;

use App\Entity\JobSubmit;
use App\Factory\TaskFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use App\Entity\Task;

class JobSubmitType extends AbstractType
{
    private $security;
    private $taskFactory;

    public function __construct(Security $security, TaskFactory $taskFactory)
    {
        $this->security = $security;
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
                'required' => true
            ])
            ->add('save', SubmitType::class, ['label' => 'Submit Job']);



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
