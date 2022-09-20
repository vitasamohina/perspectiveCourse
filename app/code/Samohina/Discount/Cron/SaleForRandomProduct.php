<?php

namespace Samohina\Discount\Cron;

class SaleForRandomProduct
{

    protected $_logger;

    protected $configWriter;

    protected $_scopeConfig;

    protected $_cacheFrontendPool;

    protected $_cacheTypeList;



    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
    ) {
        $this->_logger = $logger;
        $this->configWriter = $configWriter;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->_scopeConfig = $scopeConfig;
        $this->_cacheTypeList = $cacheTypeList;
    }

    /**
     * Method executed when cron runs in server
     */
    public function execute() {
        $this->_logger->debug('Running Cron from Test class');
        return $this;
    }
    public function SetDataOn()
    {
        $path = 'mydiscount/general/enable_discount';
        $value = '1';

        $this->configWriter->save($path, $value, $scope = $this->_scopeConfig::SCOPE_TYPE_DEFAULT, $scopeId = 0);
    }

    public function SetDataOff()
    {
        $path = 'mydiscount/general/enable_discount';
        $value = '0';

        $this->configWriter->save($path, $value, $scope = $this->_scopeConfig::SCOPE_TYPE_DEFAULT, $scopeId = 0);
    }

    public function cacheClear()
    {
        /* get all types of cache in system */
        $allTypes = array_keys($this->_cacheTypeList->getTypes());

        /* Clean cached data for specific cache type */
        foreach ($allTypes as $type) {
            $this->_cacheTypeList->cleanType($type);
        }

        /* flushed the Entire cache storage from system, Works like Flush Cache Storage button click on System -> Cache Management */
        foreach ($this->_cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
    }

}
