<?php

namespace Samohina\DataAcquisition\Block;

use Magento\Catalog\Api\Data\ProductInterface;

class GetGroup extends \Magento\Framework\View\Element\Template
{
    private $groupRepository;

    private $searchCriteriaBuilder;

    public function __construct(
        \Magento\Customer\Api\GroupRepositoryInterface   $groupRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder     $searchCriteriaBuilder,
        \Magento\Framework\View\Element\Template\Context $context,
        array                                            $data = []
    )
    {
        $this->groupRepository = $groupRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }


    public function getAllGroup()   {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $groupCollection = $this->groupRepository->getList($searchCriteria);

        return $groupCollection->getItems();
    }
}
