<?php

namespace Samohina\CityByIp\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CitySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get cities list.
     *
     * @return \Samohina\CityByIp\Api\Data\CityInterface[]
     */
    public function getItems();

    /**
     * Set cities list.
     *
     * @param \Samohina\CityByIp\Api\Data\CityInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
