<?php

namespace Training\Jobs\Controller\adminhtml\Job;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\Model\View\Result\Redirect;
use Training\Jobs\Model\Job;

class Save extends Action
 {
    /**
    * @var Job
    */
    protected $_model;

    /**
    * @param Context $context
    * @param Job $model
    */

    public function __construct(
        Context $context,
        Job $model
    ) {
        parent::__construct( $context );
        $this->_model = $model;
    }

    /**
     * {@inheritdoc}
     */
        protected function _isAllowed()
        {
            return $this->_authorization->isAllowed( 'Training_Jobs::job_save' );
        }

        /**
        * Save action
        *
        * @return ResultInterface
        */

        public function execute()
            {
            $data = $this->getRequest()->getPostValue();
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            if ( $data ) {
                /** @var Job $model */
                $model = $this->_model;
//  var_dump($data);exit;
                $id = $this->getRequest()->getParam( 'id' );
                if ( $id ) {
                    $model->load( $id );
                }
 // var_dump($data);exit;
                $model->setData( $data );
             //   var_dump($model->getData());exit;
                $this->_eventManager->dispatch(
                    'jobs_job_prepare_save',
                    [ 'job' => $model, 'request' => $this->getRequest() ]
                );

                try {
                    $model->save();
                    $this->messageManager->addSuccess( __( 'Job saved' ) );
                    $this->_getSession()->setFormData( false );
                    if ( $this->getRequest()->getParam( 'back' ) ) {
                        return $resultRedirect->setPath( '*/*/edit', [ 'id' => $model->getId(), '_current' => true ] );
                    }
                    return $resultRedirect->setPath( '*/*/' );
                } catch ( \Magento\Framework\Exception\LocalizedException|\RuntimeException $e ) {
                    $this->messageManager->addError( $e->getMessage() );

                } catch ( \Exception $e ) {
                    $this->messageManager->addException( $e, __( 'Something went wrong while saving the job' ) );
                }

                $this->_getSession()->setFormData( $data );
                return $resultRedirect->setPath( '*/*/edit', [ 'entity_id' => $this->getRequest()->getParam( 'id' ) ] );
            }
            return $resultRedirect->setPath( '*/*/' );
        }
    }
