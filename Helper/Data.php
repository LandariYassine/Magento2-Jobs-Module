<?php
 
namespace Training\Jobs\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
 
class Data extends AbstractHelper
{
    const LIST_JOBS_ENABLED = 'jobs/department/view_list';
 
    /**
     * Return if display list is enabled on department view
     * @return bool
     */
    public function getListJobEnabled() {
        return $this->scopeConfig->getValue(
            self::LIST_JOBS_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
}