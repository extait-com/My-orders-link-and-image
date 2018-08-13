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

namespace Extait\Link\Api;

use Magento\Sales\Model\Order;

interface OrderTransformInterface
{
    /**
     * Generate json configuration with related to module product data.
     *
     * @param \Magento\Sales\Model\Order $order
     * @return string
     */
    public function generateJsonConfig(Order $order);
}
