<?php
namespace Ext\Stdlib\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\DefaultStrategy;

class ValueStrategy extends DefaultStrategy
{
    
    public function extract($value)
    {
    	return str_replace(",", ".", $value);
    }
    
    /**
     * {@inheritdoc}
     *
     * Convert a string value into a DateTime object
     */
    public function hydrate($value)
    {
    	return $value;
    }
}

?>