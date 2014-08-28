<?php
namespace Ext\Stdlib;

use Zend\Stdlib\ArrayUtils as ZendArrayUtils;

class ArrayUtils extends ZendArrayUtils
{
 
    /**
     * http://stackoverflow.com/questions/8587341/recursive-function-to-generate-multidimensional-array-from-database-result/8587437#8587437
     */
    public static function buildTree(array $elements, $parentId = 0, $keys = null)
    {
        $branch = array();
        
        if(!$keys || !is_array($keys))
        {
            $keys = array('id' => 'id', 'id_parent' => 'parent_id', 'children' => 'children');
        }    
        
        foreach ($elements as $element) {
            if(!isset($element[$keys['id_parent']]))
            {
                throw new \Exception('Key '.$keys['id_parent'].' not localized in elements!');
            }    
        	if ($element[$keys['id_parent']] == $parentId) {
        		$children = self::buildTree($elements, $element[$keys['id']], $keys);
        		if ($children) {
        			$element[$keys['children']] = $children;
        		}
        		$branch[] = $element;
        	}
        }
         
        return $branch;
    }
}

?>