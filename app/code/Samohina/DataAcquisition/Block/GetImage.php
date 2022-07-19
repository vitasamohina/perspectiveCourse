<?php
namespace Samohina\DataAcquisition\Block;

class GetImage extends \Magento\Framework\View\Element\Template
{

    private $productRepository;

    private $imageHelper;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->imageHelper = $imageHelper;
        $this->productRepository = $productRepository;
        parent::__construct($context, $data);
    }
    public function getProductById($productId)
    {
        if (is_null($productId)) {
            return null;
        }

        $productModel = $this->productRepository->getById($productId);

        return $productModel;
    }

    public function getImageWidth($product, $imageId)
    {
        $image_width = $this->imageHelper->init($product, $imageId)->getWidth();

        return $image_width;

    }
    public function getImageHeight($product, $imageId)
    {

      $image_width = $this->imageHelper->init($product, $imageId)->getHeight();

        return $image_width;

    }
    public function getImageUrl($product, $imageId)
    {
        $image_url = $this->imageHelper->init($product, $imageId)->getUrl();

        return $image_url;

    }


}
