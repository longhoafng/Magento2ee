<?php
namespace Checkout\VnpayWallet\Gateway\Request;

use Checkout\VnpayWallet\Gateway\Helper\Rate;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Sales\Model\Order\Payment;

class PaymentDataBuilder extends AbstractDataBuilder implements BuilderInterface
{
    const ORDER_TYPE_VALUE = 'orther';

    /**
     * @var Rate
     */
    private $helperRate;

    /**
     * OrderDetailsDataBuilder constructor.
     *
     * @param Rate                  $helperRate
     */
    public function __construct(
        Rate $helperRate,
    ) {
        $this->helperRate   = $helperRate;
    }

    /**
     * @param array $buildSubject
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function build(array $buildSubject)
    {
        $paymentDO = SubjectReader::readPayment($buildSubject);
        /** @var Payment $payment */
        $payment = $paymentDO->getPayment();
        $order   = $payment->getOrder();

        $incrementID = $order->getIncrementId();

        return [
            self::AMOUNT => $this->helperRate->getVndAmount($order, round($order->getTotalDue() * 100, 0)),
            self::ORDER_INFO => $incrementID,
            self::ORDER_TYPE => self::ORDER_TYPE_VALUE,
            self::TXN_REF => $incrementID,
        ];
    }
}
