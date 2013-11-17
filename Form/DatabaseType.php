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
 * Class InstanceType
 *
 * Form for Redis database
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class DatabaseType extends AbstractType
{

    /**
     * Class model
     *
     * @var string
     */
    protected $class;

    /**
     * Constructor
     *
     * @param $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * Build form
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('name', 'text');
    }

    /**
     * Get form default options
     *
     * @param array $options
     * @return array Form options
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => $this->class,
        );
    }

    /**
     * Get form name
     * @return string Form name
     */
    public function getName()
    {
        return 'ringo_php_redmon_database_type';
    }
}