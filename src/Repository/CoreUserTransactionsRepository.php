<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Powerbi\Repository;

/**
 * Description of CoreUserTransactionsRepository
 *
 * @author dev
 */
use Doctrine\ORM\EntityRepository;

class CoreUserTransactionsRepository extends EntityRepository{
    
    public function fetchAll()
    {
        $items = [];
        $result = $this->createQueryBuilder('T')
            ->select('R.id as userId,R.username as Usuario,R.firstName as Nombre,'.
                    'R.lastName as ApellidoPaterno,R.surname as '.
                    'ApellidoMaterno,R.enabled as Estatus,C.id as usercedisId,'.
                    ' SUM(T.amount) as acumulados')
            ->innerJoin('T.user', 'R')  
            ->leftJoin('Adteam\Core\Powerbi\Entity\CoreUserCedis',
                    'C', \Doctrine\ORM\Query\Expr\Join::WITH, 'C.user = T.id')                 
            ->groupBy('T.user')    
            ->getQuery()->iterate();  
        foreach ($result as $item){
            $items[]=  $this->setEntities(reset($item));
        }
        return $items;
    }
    
    private function setEntities($item)
    {
        $cedis = $this->getCedis($item['usercedisId']);
        $canjeados = $this->getAmoutByType($item['userId']);
        $extras = $this->getAmoutByType($item['userId'], 'extra');
        return [
            'Usuarios'=>$item['Usuario'],
            'Nombre'=>$item['Nombre'],
            'Estatus'=>$item['Estatus'],
            'Apellido Paterno'=>$item['ApellidoPaterno'],
            'Apellido Materno'=>$item['ApellidoMaterno'],
            'Perfil'=>null,
            '* ID Dealer/Cedis'=>$cedis['cedisId'],
            '* Nombre Dealer/Cedis'=>$cedis['namesCedis'],
            'Puntos Acumulados'=>(int)$item['acumulados'],
            'Puntos Canjeados'=>  -(int)$canjeados,
            'Puntos Disponibles'=>((int)$item['acumulados'])+$canjeados,
            'Puntos extras/Bonos'=>(int)$extras
        ];
    } 
    
    private function getCedis($id)
    {
        $cedis = ['cedisId'=>null,'namesCedis'=>null];
        if(!is_null($id)){
            $result = $this->_em->getRepository(CoreUserCedis::class)
                    ->createQueryBuilder('T')
                    ->select('C.cedisId,C.namesCedis')                    
                    ->innerJoin('T.cedis', 'C')
                    ->where('T.id = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getSingleResult();                   
            $cedis = [
                'cedisId'=>$result['cedisId'],
                'namesCedis'=>$result['namesCedis']
            ];            
        }
        return $cedis;
    }

    private function getAmoutByType($userId,$type='order')
    {
        $result = $this->createQueryBuilder('T0')
            ->select('SUM(T0.amount) as canjeados')
            ->innerJoin('T0.user', 'R')
            ->where('T0.user = :id AND T0.type = :tipe')  
            ->setParameter('id', $userId)
            ->setParameter('tipe', $type)    
            ->getQuery()->getSingleResult();  
        return is_null($result['canjeados'])?0:$result['canjeados'];
    }
}
