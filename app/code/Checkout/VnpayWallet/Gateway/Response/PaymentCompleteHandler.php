<?php
namespace Checkout\VnpayWallet\Gateway\Response;

use ErrorException;
use Magento\Payment\Gateway\Helper\ContextHelper;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Sales\Model\Order\Payment;

class PaymentCompleteHandler implements HandlerInterface
{
    /**
     * @param array $handlingSubject
     * @param array $response
     * @throws ErrorException
     */
    public function handle(array $handlingSubject, array $response)
    {
        $paymentDO = SubjectReader::readPayment($handlingSubject);
        $amount    = SubjectReader::readAmount($handlingSubject);
        /** @var Payment $payment */
        $payment = $paymentDO->getPayment();
        ContextHelper::assertOrderPayment($payment);
        $order   = $payment->getOrder();
        try {
            if ($order->getId()) {
                if ($order->getStatus() != null && $order->getStatus() == 'pending') {
                    $order->setTotalPaid(floatval($amount));
                    if ($response['vnp_ResponseCode'] == '00') {
                        $orderState = $order::STATE_PROCESSING;
                        $order->setState($orderState)->setStatus($order::STATE_PROCESSING);
                        $order->save();
                    } else {
                        $order->addStatusHistoryComment('Giao dịch thất bại');
                        $orderState = $order::STATE_CLOSED;
                        $order->setState($orderState)->setStatus($order::STATE_CLOSED);
                        $order->save();
                    }
                }
            }
        } catch (\Exception $e) {
            throw new \ErrorException('Can not update order');
        }
    }
}
