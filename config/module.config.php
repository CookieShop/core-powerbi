<?php
$path=  realpath((__DIR__).'/../').'/src/';

return [
    'adteam_core_powerbi'=>[
        'test'=>$path
    ],
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'params' => [
                    'charset' => 'utf8',
                ],
            ],
        ],
        'driver' => [
            'Doctrine_driver_powerbi' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    0 => $path.'/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'Adteam\\Core\\Powerbi' => 'Doctrine_driver_powerbi',
                ],
            ],
        ],
    ],  
//    'configuration' => [
//        'orm_default' => [
//            'datetime_functions' => [
//                'DATE_FORMAT' => 'Adteam\Core\Checkout\Functionsmysql\DateFormat'
//            ],
//        ],
//    ],    
];
