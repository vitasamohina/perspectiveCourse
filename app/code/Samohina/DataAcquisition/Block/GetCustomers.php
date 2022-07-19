<?php
namespace Samohina\DataAcquisition\Block;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Customer\Model\CustomerFactory;

class GetCustomers extends \Magento\Framework\View\Element\Template
{
    private $customersFactory;

    private $customersResource;

    private $customersCollectionFactory;

    public function __construct(
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customersCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->customersCollectionFactory = $customersCollectionFactory;
        parent::__construct($context, $data);
    }
    public function getCustomer()
    {
        $customerCollection = $this->customersCollectionFactory->create();
        $customerCollection->addAttributeToSelect('*')
            ->load();

        return $customerCollection->getItems();
    }
}

