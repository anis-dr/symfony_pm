<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Name',
                'help' => 'The name of the task',
                'required' => true
            ])
            ->add('breif', null, [
                'label' => 'Brief',
                'help' => 'A short description of the task',
                'required' => false
            ])
            // make checkbox not required
            ->add('done', CheckboxType::class, [
                'mapped' => true,
                'label' => 'Done',
                'help' => 'Whether the project is active or not',
                'required' => false
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
