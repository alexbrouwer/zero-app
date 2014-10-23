<?php
return array(
    'doctrine' => array(
        'eventmanager' => array(
            'orm_default' => array(
                'subscribers' => array(
                    'Gedmo\Tree\TreeListener',
                    'Gedmo\Timestampable\TimestampableListener',
                    'Gedmo\Sluggable\SluggableListener',
                    'Gedmo\Loggable\LoggableListener',
                    'Gedmo\Sortable\SortableListener'
                ),
            ),
        ),
        'driver' => array(
            'translatable_metadata_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    'vendor/gedmo/doctrine-extensions/lib/Gedmo/Translatable/Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Gedmo\Translatable\Entity' => 'translatable_metadata_driver',
                ),
            ),
        ),
    ),
    'hydrators' => array(
        'abstract_factories' => array(
            'Base\Hydrator\DoctrineHydratorFactory'
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'ZF\\Apigility\\Doctrine\\Server\\Hydrator\\Strategy\\CollectionExtract' => 'ZF\\Apigility\\Doctrine\\Server\\Hydrator\\Strategy\\CollectionExtract',
        ),
    )
);
