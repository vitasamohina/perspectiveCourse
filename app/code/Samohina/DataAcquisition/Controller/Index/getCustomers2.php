<?php
namespace Samohina\DataAcquisition\Controller\Index;
class getCustomers2 extends \Magento\Framework\App\Action\Action
{
    private $pageFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        return parent::__construct($context);
    }
    public function execute()
    {
        return $this->pageFactory->create();
    }
}
