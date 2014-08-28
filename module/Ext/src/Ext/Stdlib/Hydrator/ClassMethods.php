<?php
namespace Ext\Stdlib\Hydrator;

class ClassMethods extends \Zend\Stdlib\Hydrator\ClassMethods
{
    /**
     * Hydrate an object by populating getter/setter methods use lowercase to $data
     *
     * Hydrates an object by getter/setter methods of the object.
     *
     * @param  array                            $data
     * @param  object                           $object
     * @return object
     * @throws Exception\BadMethodCallException for a non-object $object
     */
    public function hydrate(array $data, $object)
    {
        return parent::hydrate(array_change_key_case($data, CASE_LOWER), $object);
    }
    
    /**
     * Extract values from an object with class methods
     *
     * Extracts the getter/setter of the given $object.
     *
     * @param object $object
     * @param bool $underscoreSeparatedKeys
     * @return array
     * @throws Exception\BadMethodCallException for a non-object $object
     */
    public function extract($object, $underscoreSeparatedKeys = false)
    {
        $this->setUnderscoreSeparatedKeys($underscoreSeparatedKeys);
        return parent::extract($object);
    }
    
}

?>