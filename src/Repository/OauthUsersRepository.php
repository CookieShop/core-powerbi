<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Adteam\Core\Powerbi\Repository;
/**
 * Description of OauthUsersRepository
 *
 * @author dev
 */
use Doctrine\ORM\EntityRepository;
use Adteam\Core\Powerbi\Entity\CoreUserCedis;

class OauthUsersRepository extends EntityRepository{
    
    public function fetchAll()
    {
        $items = [];
        $result = $this->createQueryBuilder('T')
            ->select('T.id,T.username as Usuario,T.firstName as Nombre,T.email as '.
                    'EMail,T.lastName as ApellidoPaterno,T.surname as '.
                    'ApellidoMaterno,R.role as Perfil,T.enabled as Estatus,T.profileFulfilled as profileFulfilled,A.'.
                    'street,A.extNumber as extNumber,A.intNumber as intNumber,'.
                    ' A.location as Colonia, A.reference as reference,A.city '.
                    'as ciudad,A.state as estado,A.zipCode as CP, T.telephone1 '.
                    'as telefono,T.mobile as celular,T.createdAt as fechadere'.
                    'gistro,C.id as usercedisId')
            ->innerJoin('T.role', 'R')              
            ->leftJoin('Adteam\Core\Powerbi\Entity\CoreUserAddresses',
                    'A', \Doctrine\ORM\Query\Expr\Join::WITH, 'A.user = T.id') 
            ->leftJoin('Adteam\Core\Powerbi\Entity\CoreUserCedis',
                    'C', \Doctrine\ORM\Query\Expr\Join::WITH, 'C.user = T.id') 
            ->getQuery()->iterate();  
        foreach ($result as $item){
            $items[]=  $this->setEntities(reset($item));            
        }
        return $items;
    }
    
    private function setEntities($item)
    {
        $cedis = $this->getCedis($item['usercedisId']);        
        return [
            'id'=>$item['id'],
            'Usuarios'=>$item['Usuario'],
            'Nombre'=>$item['Nombre'],
            'E-mail'=>$item['EMail'],
            'Apellido Paterno'=>$item['ApellidoPaterno'],
            'Apellido Materno'=>$item['ApellidoMaterno'],
            'Perfil'=>$item['Perfil'],
            'Estatus'=>$item['Estatus'],
            'profileFulfilled'=>$item['profileFulfilled'],
            'Calle'=>$item['street'],
            '* ID Dealer/Cedis'=>$cedis['cedisId'],
            '* Nombre Dealer/Cedis'=>$cedis['namesCedis'],
            'N. Exterior'=>$item['extNumber'],
            'N. Interior'=>$item['intNumber'],
            'Colonia'=>$item['Colonia'],
            'Referencia'=>$item['reference'],
            'Ciudad/Municipio'=>$item['ciudad'],
            'Estado'=>$item['estado'],
            'CP'=>$item['CP'],
            'Teléfono'=>$item['telefono'],
            'Celular'=>$item['celular'],
            'Fecha de registro'=>  $this->formatObjectDateTime($item['fechaderegistro']),
            'Última visita'=>'',
            'Visitas'=>'',
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
}
