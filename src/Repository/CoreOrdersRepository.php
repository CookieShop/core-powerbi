<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Powerbi\Repository;

/**
 * Description of CoreOrdersRepository
 *
 * @author dev
 */
use Doctrine\ORM\EntityRepository;
use Adteam\Core\Powerbi\Entity\CoreOrderCedis;

class CoreOrdersRepository extends EntityRepository{
    public function fetchAll()
    {
        $items = [];
        $result = $this->createQueryBuilder('T')
            ->select('R.id as userId,T.id as OrderId, T.deletedAt,T.createdAt,R.displayName,'.
                    'R.username,R.enabled,C.sku,C.title,C.quantity,C.price,'.
                    'C.realPrice,A.street,A.extNumber,A.intNumber,A.location,'.
                    'A.reference,A.city,A.state,A.zipCode,E.id as orderCedisId')
            ->innerJoin('T.user', 'R') 
            ->leftJoin('Adteam\Core\Powerbi\Entity\CoreOrderProducts',
                    'C', \Doctrine\ORM\Query\Expr\Join::WITH, 'C.order = T.id')     
            ->leftJoin('Adteam\Core\Powerbi\Entity\CoreOrderAddressses',
                    'A', \Doctrine\ORM\Query\Expr\Join::WITH, 'A.order = T.id')     
            ->leftJoin('Adteam\Core\Powerbi\Entity\CoreOrderCedis',
                    'E', \Doctrine\ORM\Query\Expr\Join::WITH, 'E.order = T.id')                  
            ->orderBy('T.createdAt','DESC')    
            ->getQuery()->iterate();


        foreach ($result as $item){
            $items[]=  $this->setEntities(reset($item));
        }
        return $items;
    } 
    
    private function setEntities($item)
    {
        $cedis = $this->getCedis($item['orderCedisId']);
        return [
            'id'=>$item['userId'],
            'No. de canje'=>$item['OrderId'],
            'Estatus del pedido'=>is_null($item['deletedAt'])?'activo':'cancelado',
            'Fecha de canje'=>  $this->formatObjectDateTime($item['createdAt']),
            'Nombre del Usuario'=>$item['displayName'],
            'Username'=>$item['username'],
            'Estatus de Usuario'=>$item['enabled']?'activo':'desactivo',
            'Código de PMR'=>'',
            'Código CU'=>$item['sku'],
            'Descripción de artículo'=>$item['title'],
            'Cantidad'=>$item['quantity'],
            'Precio unitario ( en puntos )'=>$item['price'],
            'Precio total ( en puntos )'=>$item['price']*$item['quantity'],
            'Precio unitario ( en pesos )'=>$item['realPrice'],
            'Precio total ( en pesos )'=>$item['realPrice']*$item['quantity'],
            '*ID Cedis/Dealer'=>$cedis['cedisId'],
            '*Nombre Cedis/Dealer'=>$cedis['namesCedis'],
            'Calle'=>$item['street'],
            'N. Exterior'=>$item['extNumber'],
            'N. interior'=>$item['intNumber'],
            'Colonia'=>$item['location'],
            'Referencia'=>$item['reference'],
            'Ciudad/Municipio'=>$item['city'],
            'Estado'=>$item['state'],
            'CP'=>$item['zipCode'],
            'Teléfono'=>'',
            'Celular'=>'',
        ];
    } 
    /**
     * 
     * @param DateTime $datetime
     * @param type $format
     * @return type
     */
    private function formatObjectDateTime(\DateTime $datetime,$format='d-m-Y H:i:s')
    {
        $datetime->setTimezone(new \DateTimeZone('America/Mexico_City'));
        return $datetime->format($format);
    }  

    private function getCedis($id)
    {
        $cedis = ['cedisId'=>null,'namesCedis'=>null];
        if(!is_null($id)){
            $result = $this->_em->getRepository(CoreOrderCedis::class)
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
}
