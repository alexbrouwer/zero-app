<?php


namespace Base\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class DateTimeStrategy implements StrategyInterface
{
    const FORMAT_DATETIME = 'c';
    const FORMAT_DATE = 'Y-m-d';
    const FORMAT_TIME = '\TH:i:mP';

    /**
     * @var string
     */
    private $format;

    public function __construct($format = self::FORMAT_DATETIME)
    {
        $this->format = $format;
    }

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param \DateTime $value The original value.
     * @param object    $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     */
    public function extract($value)
    {
        if($value === null) {
            return $value;
        }

        return $value->format($this->format);
    }

    /**
     * Converts the given value so that it can be hydrated by the hydrator.
     *
     * @param mixed $value The original value.
     * @param array $data (optional) The original data for context.
     * @return mixed Returns the value that should be hydrated.
     */
    public function hydrate($value)
    {
        // TODO: Implement hydrate() method.
    }
}
