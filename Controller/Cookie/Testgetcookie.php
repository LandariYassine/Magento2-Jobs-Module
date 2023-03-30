<?php

namespace Training\Jobs\Controller\Cookie;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\App\Action\Context;

class Testgetcookie extends Action
{
    /**
     * @var CookieManagerInterface
     */
    protected $_cookieManager;
 
    /**
     * @param Context $context
     * @param CookieManagerInterface $cookieManager
     */
    public function __construct(
        Context $context,
        CookieManagerInterface $cookieManager
    )
    {
        $this->_cookieManager = $cookieManager;
        parent::__construct($context);
    }
 
    public function execute()
    {
        $cookieValue = $this->_cookieManager->getCookie(\Training\Jobs\Controller\Cookie\Testaddcookie::JOB_COOKIE_NAME);
        echo($cookieValue);
    }
}