<?php

// controller pour tester notre ajout de cookie 

namespace Training\Jobs\Controller\Cookie;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\App\Action\Context;

class Testaddcookie extends Action
{
    const JOB_COOKIE_NAME = 'jobs';
    const JOB_COOKIE_DURATION = 86400; // lifetime in seconds
 
    /**
     * @var CookieManagerInterface
     */
    protected $_cookieManager;
 
    /**
     * @var CookieMetadataFactory
     */
    protected $_cookieMetadataFactory;
 
    /**
     * @param Context $context
     * @param CookieManagerInterface $cookieManager
     * @param CookieMetadataFactory $cookieMetadataFactory
     */
    public function __construct(
        Context $context,
        CookieManagerInterface $cookieManager,
        CookieMetadataFactory $cookieMetadataFactory
    )
    {
        $this->_cookieManager = $cookieManager;
        $this->_cookieMetadataFactory = $cookieMetadataFactory;
        parent::__construct($context);
    }
 
    public function execute()
    {
        $metadata = $this->_cookieMetadataFactory
            ->createPublicCookieMetadata()
            ->setDuration(self::JOB_COOKIE_DURATION);
            // ->setPath('YOUR PATH')   le path  du cookie
            // ->setDomain('YOUR DOMAIN')    le domain du cookie
 
        $this->_cookieManager->setPublicCookie(
            self::JOB_COOKIE_NAME,
            'MY COOKIE VALUE',
            $metadata
        );
 
        echo('COOKIE OK');
    }
}