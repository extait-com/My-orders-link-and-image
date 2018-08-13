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

namespace Extait\Link\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**
     * Config XML paths.
     */
    const CONFIG_XML_PATH_MODULE_ENABLED = 'extait_link/general/module_enabled';
    const CONFIG_XML_PATH_IOT_ALLOWED_LINK = 'extait_link/items_ordered_tab/display_link';
    const CONFIG_XML_PATH_IOT_ALLOWED_IMAGE = 'extait_link/items_ordered_tab/display_image';
    const CONFIG_XML_PATH_IT_ALLOWED_LINK = 'extait_link/invoices_tab/display_link';
    const CONFIG_XML_PATH_IT_ALLOWED_IMAGE = 'extait_link/invoices_tab/display_image';
    const CONFIG_XML_PATH_OST_ALLOWED_LINK = 'extait_link/order_shipment_tab/display_link';
    const CONFIG_XML_PATH_OST_ALLOWED_IMAGE = 'extait_link/order_shipment_tab/display_image';
    const CONFIG_XML_PATH_RT_ALLOWED_LINK = 'extait_link/refunds_tab/display_link';
    const CONFIG_XML_PATH_RT_ALLOWED_IMAGE = 'extait_link/refunds_tab/display_image';

    /**
     * Get all module configuration.
     *
     * @return array
     */
    public function getModuleConfiguration()
    {
        return [
            'extait_link/general/module_enabled' => $this->isModuleEnabled(),
            'extait_link/items_ordered_tab/display_link' => $this->isAllowedLinkInItemsOrderedTab(),
            'extait_link/items_ordered_tab/display_image' => $this->isAllowedImageInItemsOrderedTab(),
            'extait_link/invoices_tab/display_link' => $this->isAllowedLinkInInvoicesTab(),
            'extait_link/invoices_tab/display_image' => $this->isAllowedImageInInvoicesTab(),
            'extait_link/order_shipment_tab/display_link' => $this->isAllowedLinkInOrderShipmentTab(),
            'extait_link/order_shipment_tab/display_image' => $this->isAllowedImageInOrderShipmentTab(),
            'extait_link/refunds_tab/display_link' => $this->isAllowedLinkInRefundsTab(),
            'extait_link/refunds_tab/display_image' => $this->isAllowedImageInRefundsTab(),
        ];
    }

    /**
     * Check whether the module is enabled.
     *
     * @return bool
     */
    public function isModuleEnabled()
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_XML_PATH_MODULE_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check whether is allowed displaying a link to product for order items in the items ordered tab.
     *
     * @return bool
     */
    public function isAllowedLinkInItemsOrderedTab()
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_XML_PATH_IOT_ALLOWED_LINK, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check whether is allowed displaying an image to product for order items in the items ordered tab.
     *
     * @return bool
     */
    public function isAllowedImageInItemsOrderedTab()
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_XML_PATH_IOT_ALLOWED_IMAGE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check whether is allowed displaying a link to product for order items in the invoices tab.
     *
     * @return bool
     */
    public function isAllowedLinkInInvoicesTab()
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_XML_PATH_IT_ALLOWED_LINK, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check whether is allowed displaying an image to product for order items in the invoices tab.
     *
     * @return bool
     */
    public function isAllowedImageInInvoicesTab()
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_XML_PATH_IT_ALLOWED_IMAGE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check whether is allowed displaying a link to product for order items in the order shipment tab.
     *
     * @return bool
     */
    public function isAllowedLinkInOrderShipmentTab()
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_XML_PATH_OST_ALLOWED_LINK, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check whether is allowed displaying an image to product for order items in the order shipment tab.
     *
     * @return bool
     */
    public function isAllowedImageInOrderShipmentTab()
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_XML_PATH_OST_ALLOWED_IMAGE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check whether is allowed displaying a link to product for order items in the refunds tab.
     *
     * @return bool
     */
    public function isAllowedLinkInRefundsTab()
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_XML_PATH_RT_ALLOWED_LINK, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check whether is allowed displaying an image to product for order items in the refunds tab.
     *
     * @return bool
     */
    public function isAllowedImageInRefundsTab()
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_XML_PATH_RT_ALLOWED_IMAGE, ScopeInterface::SCOPE_STORE);
    }
}
