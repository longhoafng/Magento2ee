<?php

declare(strict_types=1);

namespace LongHoang\VnpayWallet\Controller\Order;

use LongHoang\VnpayWallet\Gateway\Helper\ResponseMessage;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Payment\Gateway\Command\CommandException;
use Magento\Payment\Gateway\Command\CommandPoolInterface;
use Magento\Payment\Gateway\Data\PaymentDataObjectFactory;
use Magento\Payment\Gateway\Helper\ContextHelper;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;

/**
 * The address to receive payment results from VNPAY
 */
class Pay extends \Magento\Framework\App\Action\Action
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
     * @var CommandPoolInterface commandPool
     */
    private $commandPool;

    /**
     * @var OrderRepositoryInterface orderRepository
     */
    private $orderRepository;

    /**
     * @var PaymentDataObjectFactory paymentDataObjectFactory
     */
    private $paymentDataObjectFactory;

    /**
     * @var ResponseMessage responseMessage
     */
    private $responseMessage;

    /**
     * @param Context $context
     * @param Session $checkoutSession
     * @param CommandPoolInterface $commandPool
     * @param PaymentDataObjectFactory $paymentDataObjectFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param ResponseMessage $responseMessage
     */
    public function __construct(
        Context $context,
        Session $checkoutSession,
        CommandPoolInterface $commandPool,
        PaymentDataObjectFactory $paymentDataObjectFactory,
        OrderRepositoryInterface $orderRepository,
        ResponseMessage $responseMessage
    ) {
        parent::__construct($context);
        $this->checkoutSession          = $checkoutSession;
        $this->commandPool              = $commandPool;
        $this->orderRepository          = $orderRepository;
        $this->paymentDataObjectFactory = $paymentDataObjectFactory;
        $this->responseMessage          = $responseMessage;
    }

    /**
     * Order success action
     *
     * @return ResultInterface
     * @throws NotFoundException
     * @throws CommandException
     */
    public function execute()
    {
        $responseParams = $this->getRequest()->getParams();
        $vnp_ResponseCode = $this->getRequest()->getParam('vnp_ResponseCode', '');
        $orderId = $this->checkoutSession->getLastOrderId();

        if ($orderId) {
            /** @var Order $order */
            $order   = $this->orderRepository->get($orderId);
            $payment = $order->getPayment();
            ContextHelper::assertOrderPayment($payment);
            $paymentDataObject = $this->paymentDataObjectFactory->create($payment);
            $result = $this->commandPool->get('complete')->execute(
                [
                    'response' => $responseParams,
                    'payment'  => $paymentDataObject,
                    'amount'   => $order->getTotalDue()
                ]
            );

            if ($result) {
                if ($vnp_ResponseCode == ResponseMessage::RES_CODE_00) {
                    $this->messageManager->addSuccess(__('Successful payment via VNPAY'));
                    return $this->resultRedirectFactory->create()->setPath('checkout/onepage/success');
                } else {
                    $this->messageManager->addError(__('Payment via VNPAY failed. ') . $this->responseMessage->getErrorMess($vnp_ResponseCode));
                    return $this->resultRedirectFactory->create()->setPath('checkout/onepage/failure');
                }
            } else {
                $this->messageManager->addError(__('Payment via VNPAY failed.'));
                return $this->resultRedirectFactory->create()->setPath('checkout/onepage/failure');
            }
        }
    }
}
