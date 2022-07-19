<?php
namespace Samohina\DataAcquisition\Block;
class ProductStock extends \Magento\Framework\View\Element\Template
{
    private $stockItemRepository;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\CatalogInventory\Api\StockItemRepositoryInterface $stockItemRepository,
        array $data = []
    )
    {
        $this->stockItemRepository = $stockItemRepository;
        parent::__construct($context, $data);
    }

    public function getStockItem($productId)
    {
        return $this->stockItemRepository->get($productId);
    }
}

