<?php

namespace Training\Jobs\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Job post mysql resource
 */
class Job extends AbstractDb
{

    /**
     * Initialize Resource model
     *  
     * @return void
     */
    protected function _construct()
    {
        // Table Name and Primary Key column
        $this->_init('training_job', 'entity_id');
    }
}
