<?php


namespace Base\Hydrator;

use Doctrine\Common\Persistence\ObjectManager;
use Phpro\DoctrineHydrationModule\Service\DoctrineHydratorFactory as BaseHydratorFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

class DoctrineHydratorFactory extends BaseHydratorFactory
{
    /**
     * @param ServiceLocatorInterface $serviceManager
     * @param                         $config
     * @param ObjectManager $objectManager
     *
     * @return HydratorInterface
     */
    protected function loadDoctrineModuleHydrator(ServiceLocatorInterface $serviceManager, $config, $objectManager)
    {
        $objectManagerType = $this->getObjectManagerType($objectManager);

        if ($objectManagerType == self::OBJECT_MANAGER_TYPE_ODM_MONGODB) {
            return parent::loadEntityHydrator($serviceManager, $config, $objectManager);
        } else {
            $hydrator = new DoctrineObject($objectManager, $config['by_value']);
        }

        $this->configureHydratorStrategies($hydrator, $serviceManager, $config, $objectManager);
        return $hydrator;
    }
}
