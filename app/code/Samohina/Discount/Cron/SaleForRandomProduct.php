<?php

namespace Samohina\Discount\Cron;

class SaleForRandomProduct
{

    protected $_logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_logger = $logger;
    }

    /**
     * Method executed when cron runs in server
     */
    public function execute() {
        $this->_logger->debug('Running Cron from Test class');
        return $this;
    }
}
