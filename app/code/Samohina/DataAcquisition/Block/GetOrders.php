<?php
namespace Samohina\DataAcquisition\Block;


class GetOrders extends \Magento\Framework\View\Element\Template
{
    private $ordersCollectionFactory;

    public function __construct(
       \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $ordersCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->ordersCollectionFactory = $ordersCollectionFactory;
        parent::__construct($context, $data);
    }


    public function getOrdersWithAttibute()
    {
        $orderCollection = $this->ordersCollectionFactory->create();
        $orderCollection->addAttributeToSelect('*')->addAttributeToFilter('status', 'pending')
            ->load();
        return $orderCollection->getItems();
    }
}

