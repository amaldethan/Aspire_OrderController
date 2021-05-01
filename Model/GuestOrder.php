<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Aspire\OrderController\Model;

class GuestOrder implements \Aspire\OrderController\Api\GuestOrderInterface
{

    /**
     * {@inheritdoc}
     */
    public function __construct(\Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    public function getGuestOrderHistory($order_id){
    	$orders_array = [];
    	$orderCollection = $this->orderCollectionFactory->create();
    	$orderCollection->addAttributeToSelect('*');
    	$orderCollection->addAttributeToFilter('customer_is_guest',['eq' => 1]);
    	$orderCollection->addAttributeToFilter('entity_id',['eq' => $order_id]);
    	
    	if($orderCollection->getSize()){

    		foreach($orderCollection as $order){

    		$guestOrder['status'] = $order->getStatus();
    		$guestOrder['increment_id'] = $order->getIncrementId();
    		$guestOrder['total'] = $order->getGrandTotal();
    		$items = $order->getAllItems();
    		$order_items = [];
    		$total_invoiced_qty = 0;

    		foreach($items as $item){

    			$order_item['sku'] = $item->getSku();
    			$order_item['item_id'] = $item->getItemId();
    			$order_item['price'] = $item->getRowTotal();
    			$total_invoiced_qty += $item->getQtyInvoiced();
    			$order_items[] = $order_item;
    		}

    		$guestOrder['items'] = $order_items;
    		$guestOrder['total_invoiced_qty'] = $total_invoiced_qty;

    		$orders_array[] = $guestOrder;
    		}

    	}

    	else {

    		$orders_array[] = ['response' => 'Not a guest order'];
    	}

    	return $orders_array;

    }
}

