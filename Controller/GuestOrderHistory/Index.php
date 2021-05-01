<?php

namespace Aspire\OrderController\Controller\GuestOrderHistory;

class Index extends \Magento\Framework\App\Action\Action
{

	public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Aspire\OrderController\Model\GuestOrder $guestOrder
    ) {

        $this->guestOrder = $guestOrder;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $jsonData = $this->$guesOrder->getOrderHistory($order_id);
        return $result->setData($jsonData);
    }

}
?>