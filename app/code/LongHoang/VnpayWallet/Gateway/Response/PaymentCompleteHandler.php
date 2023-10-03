<?php

declare(strict_types=1);

namespace LongHoang\VnpayWallet\Gateway\Response;

use ErrorException;
use LongHoang\VnpayWallet\Gateway\Helper\ResponseMessage;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Payment\Gateway\Helper\ContextHelper;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Sales\Model\Order\Payment;

/**
 * Save response data from VNPAY
 */
class PaymentCompleteHandler implements HandlerInterface
{
    /**
     * Pending status
     */
    const ORDER_PENDING = 'pending';

    /**
     * Save response data
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
                if ($order->getStatus() != null && $order->getStatus() == self::ORDER_PENDING) {
                    $order->setTotalPaid(floatval($amount));
                    if ($response['vnp_ResponseCode'] == ResponseMessage::RES_CODE_00) {
                        $orderState = $order::STATE_PROCESSING;
                        $order->setState($orderState)->setStatus($order::STATE_PROCESSING);
                        $order->save();
                    } else {
                        $order->addStatusHistoryComment(__('Giao dịch thất bại'));
                        $orderState = $order::STATE_CLOSED;
                        $order->setState($orderState)->setStatus($order::STATE_CLOSED);
                        $order->save();
                    }
                }
            }
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Không thể lưu đơn hàng'));
        }
    }
}
