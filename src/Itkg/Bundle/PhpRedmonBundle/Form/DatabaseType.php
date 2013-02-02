<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Bundle\PhpRedmonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Classe InstanceType
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class DatabaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder->add('id', 'hidden');
         $builder->add('name', 'text', array(
             'label' => 'Libellé'
         ));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Itkg\Bundle\PhpRedmonBundle\Model\Database',
        );
    }

    public function getName()
    {
        return 'itkg_php_redmon_database';
    }
}