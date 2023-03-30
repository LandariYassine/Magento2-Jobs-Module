<?php

namespace Training\Jobs\Block\Job;
//Without session

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
 
            // $jobCollection = $this->_job->getCollection()
            //     ->addFieldToSelect('*')
            //     ->addFieldToFilter('status', $this->_job->getEnableStatus())
            //     ->join(
            //         array('department' => $this->_department->getResource()->getMainTable()),
            //         'main_table.department_id = department.'.$this->_job->getIdFieldName(),
            //         array('department_name' => 'name')
            //     );

            $jobCollection = $this->_job->getCollection()->addStatusFilter($this->_job, $this->_department);
 
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






// With session

// use Magento\Framework\View\Element\Template;
// use Magento\Framework\View\Element\Template\Context;
// use Training\Jobs\Model\Job;
// use Training\Jobs\Model\Department;
// use Magento\Framework\App\ResourceConnection;
// use Magento\Framework\Session\Generic;

// class ListJob extends Template
// {

//     protected $_job;

//     protected $_department;

//     protected $_resource;

//     protected $_jobCollection = null;

//     protected $_jobSession = null;

//     /**
//      * @param Context $context
//      * @param Job $job
//      * @param Department $department
//      * @param ResourceConnection $resource
//      * @param array $data
//      */
//     public function __construct(
//         Context $context,
//         Job $job,
//         Department $department,
//         ResourceConnection $resource,
//         Generic $jobSession,
//         array $data = []
//     ) {
//         $this->_job = $job;
//         $this->_department = $department;
//         $this->_resource = $resource;
//         $this->_jobSession = $jobSession;

//         parent::__construct(
//             $context,
//             $data
//         );
//     }

//     /**
//      * @return $this
//      */
//     protected function _prepareLayout()
//     {
//         parent::_prepareLayout();


//         // You can put these informations editable on BO
//         $title = __('We are hiring');
//         $description = __('Look at the jobs we have got for you');
//         $keywords = __('job,hiring');

//         $this->getLayout()->createBlock('Magento\Catalog\Block\Breadcrumbs');

//         if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
//             $breadcrumbsBlock->addCrumb(
//                 'jobs',
//                 [
//                     'label' => $title,
//                     'title' => $title,
//                     'link' => false // No link for the last element
//                 ]
//             );
//         }

//         $this->pageConfig->getTitle()->set($title);
//         $this->pageConfig->setDescription($description);
//         $this->pageConfig->setKeywords($keywords);


//         $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
//         if ($pageMainTitle) {
//             $pageMainTitle->setPageTitle($title);
//         }

//         return $this;
//     }

//     protected function _getJobCollection()
//     {
//         if ($this->_jobCollection === null) {

//             $jobCollection = $this->_job->getCollection()->addStatusFilter($this->_job, $this->_department);

//             /**
//              * récupérer la valeur de session « getNumberByPage », 
//              * vérifier qu’elle est bien dans notre tableau retourné par getAvailablePager,
//              *  et limiter notre collection au nombre d’éléments à afficher
//              */
//             $numberByPage = $this->_jobSession->getNumberByPage();
//             // If no session value or value not available, we take and set the first value
//             if (empty($numberByPage) || !in_array($numberByPage, $this->getAvailablePager())) {
//                 $numberByPage = $this->getAvailablePager()[0];
//                 $this->_jobSession->setNumberByPage($numberByPage);
//             }
//             $jobCollection->setPageSize($numberByPage)->setCurPage(1);

//             $this->_jobCollection = $jobCollection;
//         }
//         return $this->_jobCollection;
//     }


//     public function getLoadedJobCollection()
//     {
//         return $this->_getJobCollection();
//     }

//     public function getListUrl()
//     {
//         return $this->getUrl('jobs/job');
//     }

//     // nous permettre de retourner une URL avec un paramètre, 
//     // qui sera le nombre de jobs que l’on veut afficher sur la page
//     public function getPagerUrl($numberByPage)
//     {
//         return $this->getUrl('jobs/job', array('n' => $numberByPage));
//     }

//     // définir un tableau de nombre d’éléments par page disponible à proposer. 
//     // Cela permettra d’éviter que l’utilisateur mette le nombre de son choix dans l’URL.
//     public function getAvailablePager()
//     {
//         return array(
//             1,
//             3,
//             10
//         );
//     }

//     public function getJobUrl($job)
//     {
//         if (!$job->getId()) {
//             return '#';
//         }

//         return $this->getUrl('jobs/job/view', ['id' => $job->getId()]);
//     }

//     public function getDepartmentUrl($job)
//     {
//         if (!$job->getDepartmentId()) {
//             return '#';
//         }

//         return $this->getUrl('jobs/department/view', ['id' => $job->getDepartmentId()]);
//     }

//     // pouvoir récupérer notre session n’importe où vu que la méthode est publique
//     public function getJobSession()
//     {
//         return $this->_jobSession;
//     }
// }