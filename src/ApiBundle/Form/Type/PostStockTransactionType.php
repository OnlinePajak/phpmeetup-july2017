<?php

namespace ApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PostStockTransactionType extends AbstractType
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
        parent::buildForm($builder, $options);

        $builder
            ->add('item_id', IntegerType::class, array(
                "required" => true,
                'mapped' => false,
                'description' => 'Item Id'
            ))
            ->add('quantity', IntegerType::class, array(
                "required" => true,
                'description' => 'Item Quantity'
            ))
            ->add('incoming_stock', IntegerType::class, array(
                "required" => false,
                'description' => 'Phone Number'
            ))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'post_api_stock_transaction';
    }
}
