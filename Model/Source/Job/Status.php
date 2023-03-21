<?php

namespace Training\Jobs\Model\Source\Job;

use Magento\Framework\Data\OptionSourceInterface;
use Training\Jobs\Model\Job;

class Status implements OptionSourceInterface
 {
    /**
    * @var Job
    */
    protected $_job;

    /**
    * Constructor
    *
    * @param Job $job
    */

    public function __construct( Job $job )
 {
        $this->_job = $job;
    }
    /**
    * Get options
    *
    * @return array Format: array( array( 'value' => '<value>', 'label' => '<label>' ), ... )
    */

    public function toOptionArray()
 {
        $options[] = [ 'label' => '', 'value' => '' ];
        $availableOptions = $this->_job->getAvailableStatuses();
        foreach ( $availableOptions as $key => $value ) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}