<?php

namespace Extait\Link\Model;

use Extait\Link\Api\OrderTransformInterface;
use Extait\Link\Helper\Data as LinkHelper;
use Magento\Sales\Model\Order;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Framework\Json\EncoderInterface;

class OrderTransform implements OrderTransformInterface
{
    /**
     * @var \Extait\Link\Helper\Data
     */
    protected $linkHelper;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * @var \Magento\Catalog\Block\Product\ImageBuilder
     */
    protected $imageBuilder;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * OrderTransform constructor.
     *
     * @param \Extait\Link\Helper\Data $linkHelper
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Catalog\Block\Product\ImageBuilder $imageBuilder
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     */
    public function __construct(
        LinkHelper $linkHelper,
        ProductFactory $productFactory,
        ImageBuilder $imageBuilder,
        EncoderInterface $jsonEncoder
    ) {
        $this->linkHelper = $linkHelper;
        $this->productFactory = $productFactory;
        $this->imageBuilder = $imageBuilder;
        $this->jsonEncoder = $jsonEncoder;
    }

    /**
     * {@inheritdoc}
     */
    public function generateJsonConfig(Order $order)
    {
        /** @var \Magento\Sales\Model\Order\Item[] $orderItems */
        $orderItems = $order->getItems();
        $jsonConfig['moduleConfig'] = $this->linkHelper->getModuleConfiguration();

        foreach ($orderItems as $item) {
            $parentItem = $item->getParentItem();

            if (isset($parentItem) === false) {
                $product = $item->getProduct() !== null ? $item->getProduct() : $this->productFactory->create();

                $jsonConfig[$item->getSku()] = [
                    'availableForView' => $this->isProductAvailableForView($product),
                    'renderedImage' => $this->renderProductImage($product),
                    'url' => $product->getProductUrl(),
                ];
            }
        }

        return $this->jsonEncoder->encode($jsonConfig);
    }

    /**
     * Render the product image to html.
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    private function renderProductImage(Product $product)
    {
        return $this->imageBuilder->setProduct($product)->setImageId('cart_page_product_thumbnail')->create()->toHtml();
    }

    /**
     * Check whether the product is available for individuality view.
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return bool
     */
    private function isProductAvailableForView(Product $product)
    {
        $productID = $product->getId();

        return $product->getVisibility() != Visibility::VISIBILITY_NOT_VISIBLE &&
            isset($productID) && $product->isDisabled() === false;
    }
}
