<?php

namespace App\Form;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Name',
                'help' => 'The name of the project',
                'required' => true
            ])
            ->add('breif', null, [
                'label' => 'Brief',
                'help' => 'A short description of the project',
                'required' => true
            ])
            // make checkbox not required
            ->add('active', CheckboxType::class, [
                'mapped' => true,
                'label' => 'Active',
                'help' => 'Whether the project is active or not',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
