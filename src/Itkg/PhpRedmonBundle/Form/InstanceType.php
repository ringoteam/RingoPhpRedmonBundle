<?php

namespace Itkg\PhpRedmonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Classe InstanceType
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class InstanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('name', 'text');
        $builder->add('host', 'text');
        $builder->add('port', 'text');
        
    }

    public function getName()
    {
        return 'itkg_phpredmon_instance';
    }
}



class ContactType
{
    
}
