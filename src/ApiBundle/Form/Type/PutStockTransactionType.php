<?php

namespace ApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

class PutStockTransactionType extends AbstractType
{

    /**
     * [$em description]
     * @var [type]
     */
    private $em;

    private $doctrine;

    private $opt;

    private $factory;

    public function __construct(){
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('item_id', 'integer', array(
                "required" => true,
                'mapped' => false,
                'description' => 'Item Id'
            ))
            ->add('quantity', 'integer', array(
                "required" => true,
                'description' => 'Item Quantity'
            ))
            ->add('incoming_stock', 'integer', array(
                "required" => false,
                'description' => 'Phone Number'
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ApiBundle\Entity\StockTransaction',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'put_api_stock_transaction';
    }
}
