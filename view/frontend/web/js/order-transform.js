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

define([
    'jquery',
    'mage/translate',
    'jquery/ui'
], function ($, $t) {
    $.widget('extait.orderTransform', {
        options: {
            jsonConfig: {},
            defaultColspan: {}
        },

        /**
         * @private
         */
        _create: function () {
            var $table = this.element,
                tabID = this.getTabID($table),
                moduleConfig = this.options.jsonConfig.moduleConfig,
                allowedDisplayingImage = moduleConfig['extait_link/' + tabID + '/display_image'],
                allowedDisplayingLink = moduleConfig['extait_link/' + tabID + '/display_link'];

            if (allowedDisplayingImage === true) {
                this.renderImages($table);
                this.watchWindowResize($table);
            }

            if (allowedDisplayingLink === true) {
                this.renderLinks($table);
            }
        },

        /**
         * Get the tab ID. The tab ID should be the same as a tab name (group name) in system.xml
         *
         * @param $table
         * @return {string}
         */
        getTabID: function ($table) {
            var tabID = 'items_ordered_tab';

            if ($table.attr('id').match('^my-invoice-table')) {
                tabID = 'invoices_tab';
            } else if ($table.attr('id').match('my-shipment-table')) {
                tabID = 'order_shipment_tab';
            } else if ($table.attr('id').match('my-refund-table')) {
                tabID = 'refunds_tab';
            }

            return tabID;
        },

        /**
         * Render product links.
         *
         * @param $table
         */
        renderLinks: function ($table) {
            var $widget = this;

            $table.find('tbody').each(function (index, tbody) {
                var productSKU = $(tbody).find('.col.sku').first().text();

                if ($widget.options.jsonConfig[productSKU].availableForView === true) {
                    var link = '<a href="' + $widget.options.jsonConfig[productSKU].url + '"></a>';

                    $(tbody).find('.product-item-name').first().wrap(link);
                }
            });
        },

        /**
         * Render product images.
         *
         * @param $table
         */
        renderImages: function ($table) {
            var $widget = this;

            // Add empty <th/> to table head.
            $table.find('thead tr').prepend('<th class="col image"></th>');

            // Add to each row rendered image by SKU in the table.
            $table.find('tbody').each(function (index, tbody) {
                var productSKU = $(tbody).find('.col.sku').first().text(),
                    image = $('<td/>', {
                        "class": 'col image',
                        "data-th": $t('Product Image'),
                        "html": $widget.options.jsonConfig[productSKU].renderedImage
                    });

                $(tbody).find('tr').each(function (index, tr) {
                    if (index === 0) {
                        $(tr).prepend(image);
                    } else {
                        $(tr).prepend('<td class="col image"></td>')
                    }
                })
            });

            // Changed value of colspan attribute in tfoot rows because of added column.
            $table.find('tfoot tr th').each(function (index, th) {
                $widget.options.defaultColspan = parseInt($(th).attr('colspan'));

                if (window.innerWidth < 640 || window.innerWidth > 768) {
                    $(th).attr('colspan', $widget.options.defaultColspan + 1);
                }
            });
        },

        /**
         * Watch window resize for tfoot colspans regulation.
         *
         * @param $table
         */
        watchWindowResize: function ($table) {
            var defaultColspan = this.options.defaultColspan;

            $(window).on('resize', function () {
                var prevColspan = parseInt($table.find('tfoot tr th').attr('colspan'));

                if ($(window).width() >= 640 && $(window).width() <= 768 && prevColspan === defaultColspan + 1) {
                    $table.find('tfoot tr th').attr('colspan', prevColspan - 1);
                } else if (($(window).width() < 640 || $(window).width() > 768) && prevColspan === defaultColspan) {
                    $table.find('tfoot tr th').attr('colspan', prevColspan + 1);
                }
            });
        }
    });

    return $.extait.orderTransform;
});
