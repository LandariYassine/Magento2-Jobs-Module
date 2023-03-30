<?php

namespace Training\Jobs\Controller\Cookie;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\App\Action\Context;

class Testdeletecookie extends Action
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
        $this->_cookieManager->deleteCookie(
            \Training\Jobs\Controller\Cookie\Testaddcookie::JOB_COOKIE_NAME
        );
 
        echo('COOKIE DELETED');
    }
}
/**
 *  il est également possible de définir le path et le domain du cookie à supprimer, 
 *  celà nécessite d’ajouter l’objet cookieMetadataFactory à votre classe et voici le code à utiliser :
 * 
 *      $this->_cookieManager->deleteCookie(
 *      \Training\Jobs\Controller\Cookie\Testaddcookie::JOB_COOKIE_NAME,
 *    $this->_cookieMetadataFactory
 *     ->createCookieMetadata()
 *      ->setPath('YOUR PATH')
 *       ->setDomain('YOUR DOMAIN')
 *       );
 */