<?php
namespace Samohina\DataAcquisition\Block;


class GetGroup2 extends \Magento\Framework\View\Element\Template
{
    /** @var \Magento\Customer\Model\GroupFactory  */
    protected $_groupFactory;


    /** @var \Magento\Customer\Model\ResourceModel\Group  */
    protected $_groupResource;


    /** @var \Magento\Customer\Model\ResourceModel\Group\CollectionFactory */
    protected $_groupCollectionFactory;

    public function __construct(
        \Magento\Customer\Model\GroupFactory $groupFactory,
        \Magento\Customer\Model\ResourceModel\Customer $customersResource,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customersCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->_customersFactory = $customersFactory;
        $this->_customersResource = $customersResource;
        $this->_customersCollectionFactory = $customersCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get product by id via resource
     *
     * @param string $productId
     * @return \Magento\Catalog\Model\Product|null
     */
    public function getcustomersById($customerId)
    {
        if (is_null($customerId)) {
            return null;
        }

        $customerModel = $this->_customersFactory->create();
        $this->_customersResource->load($customerModel, $customerId);

        return $customerModel;
    }

    /**
     * @param int $price
     * @return array|\Magento\Framework\DataObject[]
     */
    public function getCustomer()
    {


        $customerCollection = $this->_customersCollectionFactory->create();
        $firstname= 'Vita';
        $customerCollection->addAttributeToSelect('*')
            ->load();

        return $customerCollection->getItems();
    }
}

