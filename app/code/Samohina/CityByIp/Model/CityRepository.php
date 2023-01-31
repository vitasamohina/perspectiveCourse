<?php

namespace Samohina\CityByIp\Model;

class CityRepository implements \Samohina\CityByIp\Api\CityRepositoryInterface
{

    /**
     * @var \Samohina\CityByIp\Model\CityFactory
     */
    private $cityFactory;

    /**
     * @var \Samohina\CityByIp\Model\ResourceModel\City
     */
    private $cityResourceModel;

    /**
     * @var \Samohina\CityByIp\Model\ResourceModel\City\CollectionFactory
     */
    private $cityCollectionFactory;

    /**
     * @var \Samohina\CityByIp\Api\Data\CitySearchResultsInterfaceFactory
     */
    private $citySearchResultFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var sting
     */
    private $lang;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Samohina\CityByIp\Model\CityFactory $cityFactory
     * @param \Samohina\CityByIp\Model\ResourceModel\City $cityResourceModel
     * @param \Samohina\CityByIp\Model\ResourceModel\City\CollectionFactory $cityCollectionFactory
     * @param \Samohina\CityByIp\Api\Data\CitySearchResultsInterfaceFactory $citySearchResultFactory
     */
    public function __construct(
            \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
            \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
            \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
            \Samohina\CityByIp\Model\CityFactory $cityFactory,
            \Samohina\CityByIp\Model\ResourceModel\City $cityResourceModel,
            \Samohina\CityByIp\Model\ResourceModel\City\CollectionFactory $cityCollectionFactory,
            \Samohina\CityByIp\Api\Data\CitySearchResultsInterfaceFactory $citySearchResultFactory
    )
    {

        $this->cityFactory = $cityFactory;
        $this->cityResourceModel = $cityResourceModel;
        $this->cityCollectionFactory = $cityCollectionFactory;
        $this->citySearchResultFactory = $citySearchResultFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionProcessor = $collectionProcessor;
        $this->scopeConfig = $scopeConfig;
        $this->lang = $scopeConfig->getValue(
                'carriers/novaposhta/lang',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getById($cityId)
    {
        $city = $this->cityFactory->create();
        $this->cityResourceModel->load($city, $cityId);
        return $city;
    }

    /**
     * {@inheritdoc}
     */
    public function getByRef($ref)
    {
        $city = $this->cityFactory->create();
        $this->cityResourceModel->load($city, $ref, 'ref');
        return $city;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->cityCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->citySearchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }

    /**
     * {@inheritdoc}
     */
    public function getJsonByCityName(string $name = null)
    {
        $data = array();
        $a = $name;
        $b=1;

        if (!empty($name) && mb_strlen($name) > 1) {
            $collection = $this->cityCollectionFactory->create();
            $collection->addFieldToFilter(
                    ['name_ru', 'name_ua'],
                    [
                        ['like' => $name . '%'],
                        ['like' => $name . '%']
                    ]
            );
            foreach ($collection->getItems() as $item)
            {
                $data[] = [
                    'id'   => $item->getData('ref'),
                    'text' => $item->getData('name_' . 'ru'),
                ];
            }
        }

        return json_encode($data);
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Samohina\CityByIp\Api\Data\CityInterface $city)
    {
        return $this->cityResourceModel->save($city);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\Samohina\CityByIp\Api\Data\CityInterface $city)
    {
        return $this->cityResourceModel->delete($city);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($cityId)
    {
        $city = $this->getById($cityId);
        if(!empty($city->getId())) {
            return $this->delete($city);
        }
        return false;
    }

}
