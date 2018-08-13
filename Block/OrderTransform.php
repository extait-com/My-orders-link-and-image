<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the commercial license
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category Extait
 * @package Extait_Link
 * @copyright Copyright (c) 2016-2018 Extait, Inc. (http://www.extait.com)
 */

namespace Extait\Link\Block;

use Extait\Link\Helper\Data as LinkHelper;
use Extait\Link\Api\OrderTransformInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * @api
 */
class OrderTransform extends Template
{
    /**
     * @var \Extait\Link\Api\OrderTransformInterface
     */
    protected $orderTransform;

    /**
     * @var \Extait\Link\Helper\Data
     */
    protected $linkHelper;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * OrderTransform constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Extait\Link\Api\OrderTransformInterface $orderTransform
     * @param \Extait\Link\Helper\Data $linkHelper
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        OrderTransformInterface $orderTransform,
        LinkHelper $linkHelper,
        Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->orderTransform = $orderTransform;
        $this->registry = $registry;
        $this->linkHelper = $linkHelper;
    }

    /**
     * Get json configuration for upgrading order view.
     *
     * @return mixed
     */
    public function getJsonConfig()
    {
        return $this->orderTransform->generateJsonConfig($this->getCurrentOrder());
    }

    /**
     * Check whether the module is enabled.
     *
     * @return bool
     */
    public function isModuleEnabled()
    {
        return $this->linkHelper->isModuleEnabled();
    }

    /**
     * Get a current order.
     *
     * @return \Magento\Sales\Model\Order
     */
    protected function getCurrentOrder()
    {
        return $this->registry->registry('current_order');
    }
}
