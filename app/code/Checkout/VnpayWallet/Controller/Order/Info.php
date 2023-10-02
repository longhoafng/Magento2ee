<?php

namespace Checkout\VnpayWallet\Controller\Order;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Payment\Gateway\Command\CommandPoolInterface;
use Magento\Payment\Gateway\Data\PaymentDataObjectFactory;
use Magento\Payment\Gateway\Helper\ContextHelper;
use Magento\Sales\Api\PaymentFailuresInterface;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;

class Info extends \Magento\Framework\App\Action\Action
{
    /**
     * @var  Order order
     */
    private $order;

    /**
     * @var  Session checkoutSession
     */
    private $checkoutSession;

    /**
     * @var PaymentDataObjectFactory paymentDataObject
     */
    private $paymentDataObjectFactory;

    /**
     * @var CommandPoolInterface commandPool
     */
    private $commandPool;

    /**
     * @var PaymentFailuresInterface paymentFailures
     */
    private $paymentFailures;

    /**
     * @var LoggerInterface logger
     */
    private $logger;

    public function __construct(
        Context $context,
        Order $order,
        Session $checkoutSession,
        PaymentDataObjectFactory $paymentDataObjectFactory,
        CommandPoolInterface $commandPool,
        PaymentFailuresInterface $paymentFailures,
        LoggerInterface $logger,
    ) {
        parent::__construct($context);
        $this->order = $order;
        $this->checkoutSession = $checkoutSession;
        $this->paymentDataObjectFactory = $paymentDataObjectFactory;
        $this->commandPool = $commandPool;
        $this->paymentFailures = $paymentFailures;
        $this->logger = $logger;
    }

    public function execute()
    {
        try {
            $id = $this->getRequest()->getParam('order_id', 0);
            if ($id) {
                $order = $this->order->load(intval($id));
                $payment = $order->getPayment();
                ContextHelper::assertOrderPayment($payment);
                $paymentDataObject = $this->paymentDataObjectFactory->create($payment);
                return $this->commandPool->get('pay_url')->execute(
                    [
                        'payment' => $paymentDataObject,
                        'amount'  => $order->getTotalDue(),
                    ]
                );
            }
        } catch (\Exception $e) {
            $this->paymentFailures->handle((int)$this->checkoutSession->getLastQuoteId(), $e->getMessage());
            $this->logger->critical($e);

            $this->messageManager->addErrorMessage(__('Can not pay'));
            return $this->_redirect('checkout/cart/*');
        }
    }
}
