<?php

declare(strict_types=1);

namespace LongHoang\VnpayWallet\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\UrlInterface;

/**
 * Class config provider
 */
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

    /**
     * Return config
     *
     * @return \array[][]
     */
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
