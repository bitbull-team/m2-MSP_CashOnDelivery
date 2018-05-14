<?php
/**
 * IDEALIAGroup srl
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@idealiagroup.com so we can send you a copy immediately.
 *
 * @category   MSP
 * @package    MSP_CashOnDelivery
 * @copyright  Copyright (c) 2016 IDEALIAGroup srl (http://www.idealiagroup.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace MSP\CashOnDelivery\Model;

use Magento\Payment\Model\Method\AbstractMethod;
use Magento\Framework\DataObject;

class Payment extends AbstractMethod
{
    const CODE = 'msp_cashondelivery';

    protected $_code = self::CODE;

    protected $_formBlockType = 'Magento\OfflinePayments\Block\Form\Checkmo';
    protected $_infoBlockType = 'MSP\CashOnDelivery\Block\Info\CashOnDelivery';

    protected $_isOffline = true;

    /**
     * Check whether payment method can be used
     *
     * @param \Magento\Quote\Api\Data\CartInterface|null $quote
     * @return bool
     */
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        $parent = parent::isAvailable($quote);

        $checkResult = new DataObject();
        $checkResult->setData('is_available', $parent);

        // Exclude payment if shipping method select is in backend list
        $storeId = $quote->getStoreId();
        $excludeShippingMethod = $this->getConfigData('exclude_shipping_method', $storeId);
        $excludeShippingMethod = explode(",", $excludeShippingMethod);

        $quoteShippingAddress = $quote->getShippingAddress();
        $shippingMethod = $quoteShippingAddress->getShippingMethod();

        if(in_array($shippingMethod, $excludeShippingMethod))
        {
            $checkResult->setData('is_available', false);
        }

        return $checkResult->getData('is_available');
    }
}
