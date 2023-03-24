<?php

namespace Training\Jobs\Block\Job;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Training\Jobs\Model\Job;
use Training\Jobs\Model\Department;
use Magento\Framework\App\ResourceConnection;

class ListJob extends Template
{
 
    protected $_job;
 
    protected $_department;
 
    protected $_resource;
 
    protected $_jobCollection = null;
 
    /**
     * @param Context $context
     * @param Job $job
     * @param Department $department
     * @param ResourceConnection $resource
     * @param array $data
     */
    public function __construct(
        Context $context,
        Job $job,
        Department $department,
        ResourceConnection $resource,
        array $data = []
    ) {
        $this->_job = $job;
        $this->_department = $department;
        $this->_resource = $resource;
 
        parent::__construct(
            $context,
            $data
        );
    }
 
    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
 
 
        // You can put these informations editable on BO
        $title = __('We are hiring');
        $description = __('Look at the jobs we have got for you');
        $keywords = __('job,hiring');
 
        $this->getLayout()->createBlock('Magento\Catalog\Block\Breadcrumbs');
 
        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb(
                'jobs',
                [
                    'label' => $title,
                    'title' => $title,
                    'link' => false // No link for the last element
                ]
            );
        }
 
        $this->pageConfig->getTitle()->set($title);
        $this->pageConfig->setDescription($description);
        $this->pageConfig->setKeywords($keywords);
 
 
        $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
        if ($pageMainTitle) {
            $pageMainTitle->setPageTitle($title);
        }
 
        return $this;
    }
 
    protected function _getJobCollection()
    {
        if ($this->_jobCollection === null) {
 
            $jobCollection = $this->_job->getCollection()
                ->addFieldToSelect('*')
                ->addFieldToFilter('status', $this->_job->getEnableStatus())
                ->join(
                    array('department' => $this->_department->getResource()->getMainTable()),
                    'main_table.department_id = department.'.$this->_job->getIdFieldName(),
                    array('department_name' => 'name')
                );
 
            $this->_jobCollection = $jobCollection;
        }
        return $this->_jobCollection;
    }
 
 
    public function getLoadedJobCollection()
    {
        return $this->_getJobCollection();
    }
 
    public function getJobUrl($job){
        if(!$job->getId()){
            return '#';
        }
 
        return $this->getUrl('jobs/job/view', ['id' => $job->getId()]);
    }
 
    public function getDepartmentUrl($job){
        if(!$job->getDepartmentId()){
            return '#';
        }
 
        return $this->getUrl('jobs/department/view', ['id' => $job->getDepartmentId()]);
    }
}