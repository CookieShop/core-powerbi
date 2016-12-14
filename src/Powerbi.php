<?php
/**
 * Helper para formatear en json paginador
 * 
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @author Ing. Eduardo Ortiz
 * 
 */
namespace Adteam\Core\Powerbi;

use Zend\ServiceManager\ServiceManager;
use Doctrine\ORM\EntityManager;

class Powerbi{ 
    
    protected $service;
    
    protected $params;
        
    /**
     *
     * @var type 
     */
    protected $em;
    
    public function __construct(ServiceManager $service) {
        $this->service = $service;  
        $this->em = $service->get(EntityManager::class); 
    }

    public function getReport($params)
    {
        $this->params = $params;
        if(!$this->isValidToken($params['token'])){
           throw new \InvalidArgumentException(
                'Token_Invalid');             
        }        
        return $this->loaderResport($params['query']);
    }
    
    private function isValidToken($token)
    {
        $isValid = false;
        if($token==='c4fc2a01bee0b16d9e4309d41596761bfb72fcb8'){
            $isValid = true;
        }
        return $isValid;
    }  
    
    public function loaderResport($report)
    {
        $reports = [
            'usuarios'=> \Adteam\Core\Powerbi\Entity\OauthUsers::class,
            'puntos'=> \Adteam\Core\Powerbi\Entity\CoreUserTransactions::class,
            'canjes'=>\Adteam\Core\Powerbi\Entity\CoreOrders::class,
                ];
        if(!isset($reports[$report])){
           throw new \InvalidArgumentException(
                'Report_Invalid');              
        }
        return $this->em->getRepository($reports[$report])->fetchAll();
    }
}
