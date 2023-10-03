<?php

declare(strict_types=1);

namespace LongHoang\VnpayWallet\Gateway\Helper;

use Magento\Directory\Helper\Data;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Model\Order;

/**
 * Check rate currency
 */
class Rate
{
    /**
     * Vietnam dong currency
     */
    const CURRENCY_CODE = 'VND';

    /**
     * @var Data
     */
    private $helperData;

    /**
     * OrderDetailsDataBuilder constructor.
     *
     * @param Data                  $helperData
     */
    public function __construct(
        Data $helperData,
    ) {
        $this->helperData   = $helperData;
    }

    /**
     * Return VND currency
     *
     * @param Order  $order
     * @param $amount
     * @return string
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function getVndAmount(Order $order, $amount)
    {
        if ($this->isVietnamDong($order)) {
            return round($amount);
        } else {
            try {
                return round($this->helperData->currencyConvert(
                    $amount,
                    $order->getOrderCurrencyCode(),
                    self::CURRENCY_CODE
                ));
            } catch (\Exception $e) {
                throw new LocalizedException(
                    __('We can\'t convert base currency to %1. Please setup currency rates.', self::CURRENCY_CODE)
                );
            }
        }
    }

    /**
     * Check VND
     *
     * @param Order $order
     * @return boolean
     * @throws NoSuchEntityException
     */
    private function isVietnamDong($order)
    {
        return $order->getOrderCurrencyCode() === self::CURRENCY_CODE;
    }
}
