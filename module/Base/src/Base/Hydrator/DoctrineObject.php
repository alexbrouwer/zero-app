<?php


namespace Base\Hydrator;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as BaseDoctrineObject;

class DoctrineObject extends BaseDoctrineObject
{
    /**
     * Prepare strategies before the hydrator is used
     *
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function prepareStrategies()
    {
        parent::prepareStrategies();

        $fieldNames = $this->metadata->getFieldNames();
        foreach ($fieldNames as $fieldName) {
            $typeOfField = $this->metadata->getTypeOfField($fieldName);

            $this->handleTypeStrategies($fieldName, $typeOfField);
        }
    }

    /**
     * @param string $fieldName
     * @param string $typeOfField
     */
    protected function handleTypeStrategies($fieldName, $typeOfField)
    {
        switch ($typeOfField) {
            case 'datetimetz':
            case 'datetime':
                $this->addStrategy($fieldName, new Strategy\DateTimeStrategy());
                break;
            case 'time':
                $this->addStrategy($fieldName, new Strategy\DateTimeStrategy(Strategy\DateTimeStrategy::FORMAT_TIME));
                break;
            case 'date':
                $this->addStrategy($fieldName, new Strategy\DateTimeStrategy(Strategy\DateTimeStrategy::FORMAT_DATE));
                break;

            default;
                // do nothing
                break;
        }
    }
}
