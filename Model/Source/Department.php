<?php

namespace Training\Jobs\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Department implements OptionSourceInterface
 {
    /**
    * @var \Training\Jobs\Model\Department
    */
    protected $_department;

    /**
    * Constructor
    *
    * @param \Training\Jobs\Model\Department $department
    */

    public function __construct( \Training\Jobs\Model\Department $department )
 {
        $this->_department = $department;
    }
    /**
    * Get options
    * @return array Format: array( array( 'value' => '<value>', 'label' => '<label>' ), ... )
    */

    public function toOptionArray()
 {
        $options[] = [ 'label' => '', 'value' => '' ];
        $departmentCollection = $this->_department->getCollection()
        ->addFieldToSelect( 'entity_id' )
        ->addFieldToSelect( 'name' );
        foreach ( $departmentCollection as $department ) {
            $options[] = [
                'label' => $department->getName(),
                'value' => $department->getId(),
            ];
        }
        return $options;
    }
}