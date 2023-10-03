<?php

namespace LongHoang\VnpayWallet\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\UrlInterface;

class VnpayConfigProvider implements ConfigProviderInterface
{
    const PAYMENT_METHOD_VNPAY_CODE = 'vnpay';

    const IS_OFFLINE = true;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * Constructor
     *
     * @param UrlInterface urlBuilder
     */
    public function __construct(
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    public function getConfig()
    {
        return [
            'payment' => [
                self::PAYMENT_METHOD_VNPAY_CODE => [
                    'redirectUrl' => $this->urlBuilder->getUrl('checkout/cart/*'),
                    'isOffline'   => self::IS_OFFLINE,
                ],
            ],
        ];
    }
}
