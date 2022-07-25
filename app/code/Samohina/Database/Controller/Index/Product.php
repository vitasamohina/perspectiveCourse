<?php
namespace Samohina\Database\Controller\Index;
class Product extends \Magento\Framework\App\Action\Action
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
