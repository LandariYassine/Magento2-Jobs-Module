<?php

namespace Training\Jobs\Controller\adminhtml\Job;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Forward;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;

class NewAction extends Action
 {
    /**
    * @var Forward
    */
    protected $_resultForwardFactory;

    /**
    * @param Context $context
    * @param ForwardFactory $resultForwardFactory
    */

    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory
    ) {
        $this->_resultForwardFactory = $resultForwardFactory;
        parent::__construct( $context );
    }

    /**
    * {
        @inheritdoc}
        */
        protected function _isAllowed()
 {
            return $this->_authorization->isAllowed( 'Training_Jobs::job_save' );
        }

        /**
        * Forward to edit
        *
        * @return Forward
        */

        public function execute()
 {
            /** @var Forward $resultForward */
            $resultForward = $this->_resultForwardFactory->create();
            return $resultForward->forward( 'edit' );
        }
    }
