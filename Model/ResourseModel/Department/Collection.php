<?php

namespace Training\Jobs\Model\ResourceModel\Department;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected $_idFieldName = \Training\Jobs\Model\Department::DEPARTMENT_ID;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Training\Jobs\Model\Department', 'Training\Jobs\Model\ResourceModel\Department');
    }
}
