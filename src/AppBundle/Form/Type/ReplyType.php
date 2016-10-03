<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\Reply;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReplyType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
            ->add('author', textType::class,['label'=> 'Nom'])
            ->add('email', textType::class,['label'=> 'Email'])
            ->add('comment', TextareaType::class,['label'=> 'Réponse','attr' => ['cols' => 40]]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    	$resolver->setDefaults(
    		[	
    			'data_class'=> Reply::class,
    			'method' => 'POST',
    		]

    	);
    }
 }