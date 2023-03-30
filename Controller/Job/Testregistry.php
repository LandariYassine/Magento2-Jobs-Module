<?php

namespace Training\Jobs\Controller\Job;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Registry;
use Magento\Framework\App\Action\Context;

class Testregistry extends Action
{
    /**
     * Registry
     *
     * @var Registry
     */
    protected $_registry;

    /**
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->_registry = $registry;
    }

    public function execute()
    {
        $this->_registry->register('my_registry_var', 'my global value');

        echo $this->_registry->registry('my_registry_var');
    }
}
