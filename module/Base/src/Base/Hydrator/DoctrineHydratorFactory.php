<?php


namespace Base\Hydrator;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\Filter\PropertyName;
use Phpro\DoctrineHydrationModule\Service\DoctrineHydratorFactory as BaseHydratorFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\Filter\FilterComposite;
use Zend\Stdlib\Hydrator\Filter\FilterInterface;
use Zend\Stdlib\Hydrator\FilterEnabledInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

class DoctrineHydratorFactory extends BaseHydratorFactory
{
    /**
     * @param ServiceLocatorInterface $serviceManager
     * @param                         $config
     * @param ObjectManager           $objectManager
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
        $this->configureHydratorFilters($hydrator, $serviceManager, $config);

        return $hydrator;
    }

    /**
     * @param HydratorInterface $hydrator
     * @param                   $config
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotCreatedException
     */
    protected function configureHydratorFilters($hydrator, $serviceManager, $config)
    {
        if (!($hydrator instanceof FilterEnabledInterface) || !isset($config['filters'])) {
            return;
        }

        foreach ($config['filters'] as $filterName => $filterConfig) {

            foreach($filterConfig as $field => $options) {

                if(!is_array($options)) {
                    $field = $options;
                    $options = array();
                }

                $filter = $this->getFilter($filterName, $field, $options);

                if($filter) {
                    $hydrator->addFilter($field, $filter, FilterComposite::CONDITION_AND);
                }
            }
        }
    }

    protected function getFilter($name, $field, array $options)
    {
        switch($name) {
            default:
                break;
            case 'exclude':
                return new PropertyName($field, true);
        }

        return null;
    }
}
