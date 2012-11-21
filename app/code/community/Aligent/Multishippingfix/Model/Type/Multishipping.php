<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Multishipping
 *
 * @author luke
 */
class Aligent_Multishippingfix_Model_Type_Multishipping extends Mage_Checkout_Model_Type_Multishipping {

    public function createOrders() {
        $orderIds = array();
        $this->_validate();
        $shippingAddresses = $this->getQuote()->getAllShippingAddresses();
        $orders = array();
        $summaryOrder = Mage::getModel('sales/order');

        if ($this->getQuote()->hasVirtualItems()) {
            $shippingAddresses[] = $this->getQuote()->getBillingAddress();
        }

        try {
            foreach ($shippingAddresses as $address) {
                $order = $this->_prepareOrder($address);
                if (false === $summaryOrder->getBillingAddress()) {
                    // If this is the first order (After we've seen the first
                    // order, th summary order's billing address should be set),
                    // then use it to create the summary order with all of the 
                    // necessary fields.
                    
                    $summaryOrder->setData($order->getData());
                    
                    $summaryOrder->setBillingAddress(clone $order->getBillingAddress());
                    $summaryOrder->setShippingAddress(clone $order->getShippingAddress());

                } else {
                    // For every order, collect the totals in the summary order
                    $summaryOrder->setAdjustmentNegative($summaryOrder->getAdjustmentNegative() + $order->getAdjustmentNegative());
                    $summaryOrder->setAdjustmentPositive($summaryOrder->getAdjustmentPositive() + $order->getAdjustmentPositive());
                    $summaryOrder->setBaseAdjustmentNegative($summaryOrder->getBaseAdjustmentNegative() + $order->getBaseAdjustmentNegative());
                    $summaryOrder->setBaseAdjustmentPositive($summaryOrder->getBaseAdjustmentPositive() + $order->getBaseAdjustmentPositive());
                    $summaryOrder->setBaseDiscountAmount($summaryOrder->getBaseDiscountAmount() + $order->getBaseDiscountAmount());
                    $summaryOrder->setBaseDiscountCanceled($summaryOrder->getBaseDiscountCanceled() + $order->getBaseDiscountCanceled());
                    $summaryOrder->setBaseDiscountInvoiced($summaryOrder->getBaseDiscountInvoiced() + $order->getBaseDiscountInvoiced());
                    $summaryOrder->setBaseDiscountRefunded($summaryOrder->getBaseDiscountRefunded() + $order->getBaseDiscountRefunded());
                    $summaryOrder->setBaseGrandTotal($summaryOrder->getBaseGrandTotal() + $order->getBaseGrandTotal());
                    $summaryOrder->setBaseHiddenTaxAmount($summaryOrder->getBaseHiddenTaxAmount() + $order->getBaseHiddenTaxAmount());
                    $summaryOrder->setBaseHiddenTaxInvoiced($summaryOrder->getBaseHiddenTaxInvoiced() + $order->getBaseHiddenTaxInvoiced());
                    $summaryOrder->setBaseHiddenTaxRefunded($summaryOrder->getBaseHiddenTaxRefunded() + $order->getBaseHiddenTaxRefunded());
                    $summaryOrder->setBaseShippingAmount($summaryOrder->getBaseShippingAmount() + $order->getBaseShippingAmount());
                    $summaryOrder->setBaseShippingCanceled($summaryOrder->getBaseShippingCanceled() + $order->getBaseShippingCanceled());
                    $summaryOrder->setBaseShippingDiscountAmount($summaryOrder->getBaseShippingDiscountAmount() + $order->getBaseShippingDiscountAmount());
                    $summaryOrder->setBaseShippingHiddenTaxAmount($summaryOrder->getBaseShippingHiddenTaxAmount() + $order->getBaseShippingHiddenTaxAmount());
                    $summaryOrder->setBaseShippingInclTax($summaryOrder->getBaseShippingInclTax() + $order->getBaseShippingInclTax());
                    $summaryOrder->setBaseShippingInvoiced($summaryOrder->getBaseShippingInvoiced() + $order->getBaseShippingInvoiced());
                    $summaryOrder->setBaseShippingRefunded($summaryOrder->getBaseShippingRefunded() + $order->getBaseShippingRefunded());
                    $summaryOrder->setBaseShippingTaxAmount($summaryOrder->getBaseShippingTaxAmount() + $order->getBaseShippingTaxAmount());
                    $summaryOrder->setBaseShippingTaxRefunded($summaryOrder->getBaseShippingTaxRefunded() + $order->getBaseShippingTaxRefunded());
                    $summaryOrder->setBaseSubtotal($summaryOrder->getBaseSubtotal() + $order->getBaseSubtotal());
                    $summaryOrder->setBaseSubtotalCanceled($summaryOrder->getBaseSubtotalCanceled() + $order->getBaseSubtotalCanceled());
                    $summaryOrder->setBaseSubtotalInclTax($summaryOrder->getBaseSubtotalInclTax() + $order->getBaseSubtotalInclTax());
                    $summaryOrder->setBaseSubtotalInvoiced($summaryOrder->getBaseSubtotalInvoiced() + $order->getBaseSubtotalInvoiced());
                    $summaryOrder->setBaseSubtotalRefunded($summaryOrder->getBaseSubtotalRefunded() + $order->getBaseSubtotalRefunded());
                    $summaryOrder->setBaseTaxAmount($summaryOrder->getBaseTaxAmount() + $order->getBaseTaxAmount());
                    $summaryOrder->setBaseTaxCanceled($summaryOrder->getBaseTaxCanceled() + $order->getBaseTaxCanceled());
                    $summaryOrder->setBaseTaxInvoiced($summaryOrder->getBaseTaxInvoiced() + $order->getBaseTaxInvoiced());
                    $summaryOrder->setBaseTaxRefunded($summaryOrder->getBaseTaxRefunded() + $order->getBaseTaxRefunded());
                    $summaryOrder->setBaseToGlobalRate($summaryOrder->getBaseToGlobalRate() + $order->getBaseToGlobalRate());
                    $summaryOrder->setBaseToOrderRate($summaryOrder->getBaseToOrderRate() + $order->getBaseToOrderRate());
                    $summaryOrder->setBaseTotalCanceled($summaryOrder->getBaseTotalCanceled() + $order->getBaseTotalCanceled());
                    $summaryOrder->setBaseTotalDue($summaryOrder->getBaseTotalDue() + $order->getBaseTotalDue());
                    $summaryOrder->setBaseTotalInvoiced($summaryOrder->getBaseTotalInvoiced() + $order->getBaseTotalInvoiced());
                    $summaryOrder->setBaseTotalInvoicedCost($summaryOrder->getBaseTotalInvoicedCost() + $order->getBaseTotalInvoicedCost());
                    $summaryOrder->setBaseTotalOfflineRefunded($summaryOrder->getBaseTotalOfflineRefunded() + $order->getBaseTotalOfflineRefunded());
                    $summaryOrder->setBaseTotalOnlineRefunded($summaryOrder->getBaseTotalOnlineRefunded() + $order->getBaseTotalOnlineRefunded());
                    $summaryOrder->setBaseTotalPaid($summaryOrder->getBaseTotalPaid() + $order->getBaseTotalPaid());
                    $summaryOrder->setBaseTotalQtyOrdered($summaryOrder->getBaseTotalQtyOrdered() + $order->getBaseTotalQtyOrdered());
                    $summaryOrder->setBaseTotalRefunded($summaryOrder->getBaseTotalRefunded() + $order->getBaseTotalRefunded());
                    $summaryOrder->setDiscountAmount($summaryOrder->getDiscountAmount() + $order->getDiscountAmount());
                    $summaryOrder->setDiscountCanceled($summaryOrder->getDiscountCanceled() + $order->getDiscountCanceled());
                    $summaryOrder->setDiscountInvoiced($summaryOrder->getDiscountInvoiced() + $order->getDiscountInvoiced());
                    $summaryOrder->setDiscountRefunded($summaryOrder->getDiscountRefunded() + $order->getDiscountRefunded());
                    $summaryOrder->setGrandTotal($summaryOrder->getGrandTotal() + $order->getGrandTotal());
                    $summaryOrder->setHiddenTaxAmount($summaryOrder->getHiddenTaxAmount() + $order->getHiddenTaxAmount());
                    $summaryOrder->setHiddenTaxInvoiced($summaryOrder->getHiddenTaxInvoiced() + $order->getHiddenTaxInvoiced());
                    $summaryOrder->setHiddenTaxRefunded($summaryOrder->getHiddenTaxRefunded() + $order->getHiddenTaxRefunded());
                    $summaryOrder->setPaymentAuthorizationAmount($summaryOrder->getPaymentAuthorizationAmount() + $order->getPaymentAuthorizationAmount());
                    $summaryOrder->setShippingAmount($summaryOrder->getShippingAmount() + $order->getShippingAmount());
                    $summaryOrder->setShippingCanceled($summaryOrder->getShippingCanceled() + $order->getShippingCanceled());
                    $summaryOrder->setShippingDiscountAmount($summaryOrder->getShippingDiscountAmount() + $order->getShippingDiscountAmount());
                    $summaryOrder->setShippingHiddenTaxAmount($summaryOrder->getShippingHiddenTaxAmount() + $order->getShippingHiddenTaxAmount());
                    $summaryOrder->setShippingInclTax($summaryOrder->getShippingInclTax() + $order->getShippingInclTax());
                    $summaryOrder->setShippingInvoiced($summaryOrder->getShippingInvoiced() + $order->getShippingInvoiced());
                    $summaryOrder->setShippingRefunded($summaryOrder->getShippingRefunded() + $order->getShippingRefunded());
                    $summaryOrder->setShippingTaxAmount($summaryOrder->getShippingTaxAmount() + $order->getShippingTaxAmount());
                    $summaryOrder->setShippingTaxRefunded($summaryOrder->getShippingTaxRefunded() + $order->getShippingTaxRefunded());
                    $summaryOrder->setStoreToBaseRate($summaryOrder->getStoreToBaseRate() + $order->getStoreToBaseRate());
                    $summaryOrder->setStoreToOrderRate($summaryOrder->getStoreToOrderRate() + $order->getStoreToOrderRate());
                    $summaryOrder->setSubtotal($summaryOrder->getSubtotal() + $order->getSubtotal());
                    $summaryOrder->setSubtotalCanceled($summaryOrder->getSubtotalCanceled() + $order->getSubtotalCanceled());
                    $summaryOrder->setSubtotalInclTax($summaryOrder->getSubtotalInclTax() + $order->getSubtotalInclTax());
                    $summaryOrder->setSubtotalInvoiced($summaryOrder->getSubtotalInvoiced() + $order->getSubtotalInvoiced());
                    $summaryOrder->setSubtotalRefunded($summaryOrder->getSubtotalRefunded() + $order->getSubtotalRefunded());
                    $summaryOrder->setTaxAmount($summaryOrder->getTaxAmount() + $order->getTaxAmount());
                    $summaryOrder->setTaxCanceled($summaryOrder->getTaxCanceled() + $order->getTaxCanceled());
                    $summaryOrder->setTaxInvoiced($summaryOrder->getTaxInvoiced() + $order->getTaxInvoiced());
                    $summaryOrder->setTaxRefunded($summaryOrder->getTaxRefunded() + $order->getTaxRefunded());
                    $summaryOrder->setTotalCanceled($summaryOrder->getTotalCanceled() + $order->getTotalCanceled());
                    $summaryOrder->setTotalDue($summaryOrder->getTotalDue() + $order->getTotalDue());
                    $summaryOrder->setTotalInvoiced($summaryOrder->getTotalInvoiced() + $order->getTotalInvoiced());
                    $summaryOrder->setTotalOfflineRefunded($summaryOrder->getTotalOfflineRefunded() + $order->getTotalOfflineRefunded());
                    $summaryOrder->setTotalOnlineRefunded($summaryOrder->getTotalOnlineRefunded() + $order->getTotalOnlineRefunded());
                    $summaryOrder->setTotalPaid($summaryOrder->getTotalPaid() + $order->getTotalPaid());
                    $summaryOrder->setTotalQtyOrdered($summaryOrder->getTotalQtyOrdered() + $order->getTotalQtyOrdered());
                    $summaryOrder->setTotalRefunded($summaryOrder->getTotalRefunded() + $order->getTotalRefunded());
                    $summaryOrder->setWeight($summaryOrder->getWeight() + $order->getWeight());
                }
                $orders[] = $order;
                Mage::dispatchEvent(
                        'checkout_type_multishipping_create_orders_single', array('order' => $order, 'address' => $address)
                );
            }

            // Get the quote object, the convert_quote object, and use these
            // to get a payment object to attach to the summary order.
            // This code was taken from the standard _prepareOrder method()
            $quote = $this->getQuote();
            $convertQuote = Mage::getSingleton('sales/convert_quote');
            $summaryPayment = $convertQuote->paymentToOrderPayment($quote->getPayment());
            $summaryPayment->setParentOrderIncrementId($summaryOrder->getIncrementId());
            $summaryOrder->setPayment($summaryPayment);
            if (Mage::app()->getStore()->roundPrice($address->getGrandTotal()) == 0) {
                $summaryOrder->getPayment()->setMethod('free');
            }
            // Place the summary order
            $summaryOrder->place();

            // Attach the summary payment object to each of the multishipping orders.
            // The payment object must be set before it is saved, otherwise 
            // when setPayment is called, in Mage_Sales_Model_Order::addPayment()
            // the payment object will have an ID, and won't be added to the 
            // payments collection object for the order
            $summaryRelatedObjects = $summaryOrder->getRelatedObjects();
            foreach ($orders as $order) {
                $order->setPayment(clone $summaryPayment);
                foreach ($summaryRelatedObjects as $relatedObject) {
                    $order->addRelatedObject(clone $relatedObject);
                }
                $order->getPayment()->multishippingfixCapture(null);
                $order->setState(
                        $summaryOrder->getState(),
                        $summaryOrder->getStatus(),
                        $summaryOrder->getCustomerNote(),
                        $summaryOrder->getCustomerNoteNotify()
                );
            }
            
            //now capture the summary payment
            $summaryPayment->unsParentOrderIncrementId()->place();
            
            // Save each multishipping order.
            // Note: the summary order is NOT saved.
            foreach ($orders as $order) {
                /* @var $order Mage_Sales_Model_Order */
                //save the transaction ID onto each child order payment for reference/reconciliation
                $order->getPayment()->setLastTransId($summaryPayment->getLastTransId());
                $order->addStatusHistoryComment(Mage::helper('sales')->__('Multishippingfix Payment Capture. Transaction ID: "%s"', $summaryPayment->getLastTransId()), false);
                $order->save();
                if ($order->getCanSendNewEmailFlag()) {
                    $order->sendNewOrderEmail();
                }
                $orderIds[$order->getId()] = $order->getIncrementId();
            }

            Mage::getSingleton('core/session')->setOrderIds($orderIds);
            Mage::getSingleton('checkout/session')->setLastQuoteId($this->getQuote()->getId());

            $this->getQuote()
                    ->setIsActive(false)
                    ->save();

            Mage::dispatchEvent('checkout_submit_all_after', array('orders' => $orders, 'quote' => $this->getQuote()));

            return $this;
        } catch (Exception $e) {
            Mage::dispatchEvent('checkout_multishipping_refund_all', array('orders' => $orders));
            throw $e;
        }
    }

    public function _prepareOrder(Mage_Sales_Model_Quote_Address $address) {
        $quote = $this->getQuote();
        $quote->unsReservedOrderId();
        $quote->reserveOrderId();
        $quote->collectTotals();

        $convertQuote = Mage::getSingleton('sales/convert_quote');
        $order = $convertQuote->addressToOrder($address);
        $order->setBillingAddress(
                $convertQuote->addressToOrderAddress($quote->getBillingAddress())
        );

        if ($address->getAddressType() == 'billing') {
            $order->setIsVirtual(1);
        } else {
            $order->setShippingAddress($convertQuote->addressToOrderAddress($address));
        }

        // Don't set the payment on the order.
        // A summary payment needs to be created, and linked to the order later.
//        $order->setPayment($convertQuote->paymentToOrderPayment($quote->getPayment()));
//        if (Mage::app()->getStore()->roundPrice($address->getGrandTotal()) == 0) {
//            $order->getPayment()->setMethod('free');
//        }

        foreach ($address->getAllItems() as $item) {
            if (!$item->getQuoteItem()) {
                throw new Mage_Checkout_Exception(Mage::helper('checkout')->__('Item not found or already ordered'));
            }
            $item->setProductType($item->getQuoteItem()->getProductType())
                    ->setProductOptions($item->getQuoteItem()->getProduct()->getTypeInstance(true)->getOrderOptions($item->getQuoteItem()->getProduct()));
            $orderItem = $convertQuote->itemToOrderItem($item);
            if ($item->getParentItem()) {
                $orderItem->setParentItem($order->getItemByQuoteItemId($item->getParentItem()->getId()));
            }
            $order->addItem($orderItem);
        }

        return $order;
    }

}

?>
