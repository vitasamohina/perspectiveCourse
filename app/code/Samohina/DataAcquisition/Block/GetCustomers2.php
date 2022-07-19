<?php
namespace Samohina\DataAcquisition\Block;

use Magento\Catalog\Api\Data\ProductInterface;

class GetCustomers2 extends \Magento\Framework\View\Element\Template
{
    private $customerRepository;

    private $searchCriteriaBuilder;

    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->customerRepository = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }

    public function getCustomers()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $customerCollection = $this->customerRepository->getList($searchCriteria);
        return $customerCollection->getItems();
    }
}


