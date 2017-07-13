<?php
/**
 * Created by PhpStorm.
 * User: Ardi
 * Date: 07/07/2017
 * Time: 16.53
 */

namespace ApiBundle\Services;

use AppBundle\Services\CommonService;
use Doctrine\ORM\EntityManagerInterface;

class ItemService
{
    private $em;
    private $commonService;
    private $result;

    public function __construct(EntityManagerInterface $em, CommonService $commonService)
    {
        $this->em = $em;
        $this->commonService = $commonService;
        $this->result = $this->commonService->setPredefinedResult();
    }

    public function fetchAllItems(){
        $items = $this->commonService->fetchItemObject();
        $this->result = $this->commonService->setResult($items);
        return $this->result;
    }

    public function fetchItem($id){
        $item = $this->commonService->fetchItemObject($id);
        if($item){
            $this->result = $this->commonService->setResult($item);
        }
        return $this->result;
    }
}