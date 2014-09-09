<?php

/**
 * Class Aligent_Multishippingfix_Model_Sales_Order_Invoice_Total_Discount
 * Adds fix for multishipping not adding discount to final payment capture
 */
class Aligent_Multishippingfix_Model_Sales_Order_Invoice_Total_Discount extends Mage_Sales_Model_Order_Invoice_Total_Discount {

    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
        $invoice->setDiscountAmount(0);
        $invoice->setBaseDiscountAmount(0);

        $totalDiscountAmount     = 0;
        $baseTotalDiscountAmount = 0;

        /**
         * Checking if shipping discount was added in previous invoices.
         * So basically if we have invoice with positive discount and it
         * was not canceled we don't add shipping discount to this one.
         */
        $addShippingDicount = true;
        foreach ($invoice->getOrder()->getInvoiceCollection() as $previusInvoice) {
            if ($previusInvoice->getDiscountAmount()) {
                $addShippingDicount = false;
            }
        }

        if ($addShippingDicount) {
            $totalDiscountAmount     = $totalDiscountAmount + $invoice->getOrder()->getShippingDiscountAmount();
            $baseTotalDiscountAmount = $baseTotalDiscountAmount + $invoice->getOrder()->getBaseShippingDiscountAmount();
        }

        foreach ($invoice->getAllItems() as $item) {
            if ($item->getOrderItem()->isDummy()) {
                continue;
            }
            $orderItem = $item->getOrderItem();
            $orderItemDiscount      = (float) $orderItem->getDiscountAmount();
            $baseOrderItemDiscount  = (float) $orderItem->getBaseDiscountAmount();
            $orderItemQty       = $orderItem->getQtyOrdered();

            if ($orderItemDiscount && $orderItemQty) {
                /**
                 * Resolve rounding problems
                 */
                if ($item->isLast()) {
                    $discount = $orderItemDiscount - $orderItem->getDiscountInvoiced();
                    $baseDiscount = $baseOrderItemDiscount - $orderItem->getBaseDiscountInvoiced();
                }
                else {
                    $discount = $orderItemDiscount*$item->getQty()/$orderItemQty;
                    $baseDiscount = $baseOrderItemDiscount*$item->getQty()/$orderItemQty;

                    $discount = $invoice->getStore()->roundPrice($discount);
                    $baseDiscount = $invoice->getStore()->roundPrice($baseDiscount);
                }

                $item->setDiscountAmount($discount);
                $item->setBaseDiscountAmount($baseDiscount);

                $totalDiscountAmount += $discount;
                $baseTotalDiscountAmount += $baseDiscount;
            }
        }

        /**
         * Check to see if an invoice has items, if not we can check for and add the discount amounts
         * from the order. This makes sure discounts from individual items are not missed out from the
         * summary orders created invoice.
         */

        if(!$invoice->getAllItems() && $invoice->getOrder()) {
            $totalDiscountAmount = abs($invoice->getOrder()->getDiscountAmount());
            $baseTotalDiscountAmount = abs($invoice->getOrder()->getBaseDiscountAmount());
        }

        $invoice->setDiscountAmount($totalDiscountAmount);
        $invoice->setBaseDiscountAmount($baseTotalDiscountAmount);

        $invoice->setGrandTotal($invoice->getGrandTotal() - $totalDiscountAmount);
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() - $baseTotalDiscountAmount);
        return $this;
    }
}