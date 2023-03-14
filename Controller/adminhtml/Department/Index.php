<?php

namespace Training\Jobs\Controller\Adminhtml\Department;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;

class Index extends Action
{

    //  vérifier si vous avez accès à ce contenu de l’admin (ACL)
    const ADMIN_RESOURCE = 'Training_Jobs::department';

    // l’injection de dépendance (L’attribut « resultPageFactory » et la méthode construct)
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Training_Jobs::department');
        // public function addBreadcrumb($label, $title, $link = null)
        $resultPage->addBreadcrumb(__('Jobs'), __('Jobs'));
        $resultPage->addBreadcrumb(__('Manage Departments'), __('Manage Departments'));
        $resultPage->getConfig()->getTitle()->prepend(__('Department'));

        return $resultPage;
    }
}
