<?php

namespace Codebender\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isbn')
            ->add('title')
            ->add('author')
            ->add('year')
            ->add('shelf')
            ->add('section')
            ->add('available')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Codebender\DefaultBundle\Entity\Book'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'codebender_defaultbundle_book';
    }
}
