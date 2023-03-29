<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Training\Jobs\Cron;

use Training\Jobs\Model\Job;
use Magento\Cron\Model\Schedule;
 
class DisableJobs
{
    /**
     * @var Job
     */
    protected $_job;
 
    /**
     * @param Job $job
     */
    public function __construct(
        Job $job
    ) {
        $this->_job = $job;
    }
 
    /**
     * Disable jobs which date is less than the current date
     *
     * @param Schedule $schedule
     * @return void
     */
    public function execute(Schedule $schedule)
    {
        $nowDate = date('Y-m-d');
        $jobsCollection = $this->_job->getCollection()
            ->addFieldToFilter('date', array ('lt' => $nowDate));
 
        foreach($jobsCollection AS $job) {
            $job->setStatus($job->getDisableStatus());
            $job->save();
        }
    }
}