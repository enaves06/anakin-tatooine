<?php
namespace Ext\Stdlib\Hydrator\Strategy;

use DateTime;
use Zend\Stdlib\Hydrator\Strategy\DefaultStrategy;

class DateTimeStrategy extends DefaultStrategy
{
    
    public function extract($value)
    {
    	return $value ? $value->format('d/m/Y H:i:s') : null;
    }
    
    /**
     * {@inheritdoc}
     *
     * Convert a string value into a DateTime object
     */
    public function hydrate($value)
    {
        if (is_string($value)) {
    		$value = \DateTime::createFromFormat('d/m/y H:i:s', $value);
    	}
    	
    	return $value;
    }
}

?>