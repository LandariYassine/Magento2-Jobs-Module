<?php

namespace Training\Jobs\Controller\Department;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Training\Jobs\Model\Department;

class View extends Action
{
    /**
     * @var Department
     */
    protected $_model;
 
    /**
     * @param Context $context
     * @param Department $model
     */
    public function __construct(
        Context $context,
        Department $model
    )
    {
        $this->_model = $model;
        parent::__construct($context);
    }
 
    public function execute()
    {
        // Get param id
        $id = $this->getRequest()->getParam('id');
        $model = $this->_model;
 
        // No id, redirect
        if(empty($id)){
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }
 
        $model->load($id);
        // Model not exists with this id, redirect
        if (!$model->getId()) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }
 
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}