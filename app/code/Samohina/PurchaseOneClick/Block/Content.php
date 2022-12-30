<?php

namespace Samohina\PurchaseOneClick\Block;

use Magento\Framework\Registry;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Framework\View\Element\Template\Context;

class Content extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Product
     */
    protected $product = null;

    /**
     * @var ImageBuilder
     */
    protected $imageBuilder;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * Content constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param ImageBuilder $builder
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ImageBuilder $builder,
        array $data = []
    )
    {
        $this->imageBuilder = $builder;
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve action url
     *
     * @return string
     */
    public function getActionUrl()
    {
        return $this->getUrl('purchaseoneclick/index/index');
    }

    /**
     * Retrieve current product
     *
     * @return Product
     */
    public function getProduct()
    {
        if (!$this->product) {
            $this->product = $this->coreRegistry->registry('product');
        }
        return $this->product;
    }

    /**
     * Retrieve product image
     *
     * @return \Magento\Catalog\Block\Product\Image
     */
    public function getImage()
    {
        return $this->imageBuilder->setProduct($this->getProduct())
            ->setImageId('cart_page_product_thumbnail')
            ->setAttributes([])
            ->create();
    }

    /**
     * Return HTML block with price
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductPrice()
    {
        return $this->getProductPriceHtml(
            $this->getProduct(),
            \Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
            \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST
        );
    }

    /**
     * Return HTML block with tier price
     *
     * @param Product $product
     * @param $priceType
     * @param string $renderZone
     * @param array $arguments
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductPriceHtml(
        \Magento\Catalog\Model\Product $product,
        $priceType,
        $renderZone = \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
        array $arguments = []
    )
    {
        if (!isset($arguments['zone'])) {
            $arguments['zone'] = $renderZone;
        }

        /** @var \Magento\Framework\Pricing\Render $priceRender */
        $priceRender = $this->getLayout()->getBlock('product.price.render.default');
        $price = '';

        if ($priceRender) {
            $price = $priceRender->render($priceType, $product, $arguments);
        }
        return $price;
    }
}
