<?php
namespace Ext\Stdlib\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\DefaultStrategy;

class DateStrategy extends DefaultStrategy
{
    
    public function extract($value)
    {
    	return $value ? $value->format('d/m/Y') : null;
    }
    
    /**
     * {@inheritdoc}
     *
     * Convert a string value into a DateTime object
     */
    public function hydrate($value)
    {
        if (is_string($value)) {
            $value = substr($value, 0, 8);
    		$value = \DateTime::createFromFormat('d/m/y', str_replace(' 00:00:00', '', $value));
    	}
    	
    	return $value;
    }
}

?>