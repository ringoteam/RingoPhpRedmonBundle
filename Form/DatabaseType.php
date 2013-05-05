<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ringo\Bundle\PhpRedmonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class DatabaseType
 * 
 * Form for Redis database
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class DatabaseType extends AbstractType
{
    /**
     * Build the form
     * 
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder->add('id', 'hidden');
         $builder->add('name', 'text', array(
             'label' => 'Name'
         ));
    }

    /**
     * Get form options
     * 
     * @param array $options
     * @return array Current options
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Ringo\Bundle\PhpRedmonBundle\Model\Database',
        );
    }

    /**
     * Get form name
     * 
     * @return string Form name
     */
    public function getName()
    {
        return 'ringo_php_redmon_database';
    }
}