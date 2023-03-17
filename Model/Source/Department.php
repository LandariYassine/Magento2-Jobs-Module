<?php

namespace Training\Jobs\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Training\Jobs\Model\Department;

class Status implements OptionSourceInterface
{
    /**
     * @var Department
     */
    protected $_department;

    /**
     * Constructor
     * 
     * @param Department $department
     */

    public function __construct(Department $department)
    {
        $this->_department = $department;
    }
    /**
     * Get options 
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $departmentCollection = $this->_department->getCollection()
            ->addFieldToSelect('entity_id')
            ->addFieldToSelect('name');
        foreach ($departmentCollection as $department) {
            $options[] = [
                'label' => $department->getName(),
                'value' => $department->getId(),
            ];
        }
        return $options;
    }
}