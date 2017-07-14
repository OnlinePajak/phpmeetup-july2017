<?php
namespace ApiBundle\Services;

use AppBundle\Services\CommonService;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManagerInterface;

class UserService
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

    public function fetchUser($id){
        $user = $this->commonService->fetchUserObject($id);
        if($user){
            $this->result = $this->commonService->setResult($user);
        }
        return $this->result;
    }
}