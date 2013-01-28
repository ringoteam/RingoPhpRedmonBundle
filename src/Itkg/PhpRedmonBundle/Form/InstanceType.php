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
        $builder->add('name', 'text', array('label' => 'Libellé'));
        $builder->add('host', 'text');
        $builder->add('port', 'text');
        
        $builder->add('databases', 'collection', array(
            'type' => new DatabaseType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Itkg\PhpRedmonBundle\Model\Instance',
        );
    }
    
    
    
    public function getName()
    {
        return 'itkg_php_redmon_instance';
    }
}