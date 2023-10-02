<?php

namespace Checkout\VnpayWallet\Gateway\Request;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class ExtraDataBuilder extends AbstractDataBuilder
{
    const COMMAND_VALUE = 'pay';

    const CURRENCY_CODE_VALUE = 'VND';

    const LOCALE_VALUE = 'vn';

    const VNP_VERSION = '2.1.0';

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        StoreManagerInterface $storeManager,
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function build(array $buildSubject)
    {
        $returnUrl = $this->storeManager->getStore()->getBaseUrl();
        $returnUrl = rtrim($returnUrl, "/");
        $returnUrl .= "/paymentvnpay/order/pay";

        return [
         self::VERSION => self::VNP_VERSION,
         self::COMMAND => self::COMMAND_VALUE,
         self::CREATE_DATE => date('YmdHis'),
         self::CURRENCY_CODE => self::CURRENCY_CODE_VALUE,
         self::IP_ADDRESS => $_SERVER['REMOTE_ADDR'],
         self::LOCALE => self::LOCALE_VALUE,
         self::RETURN_URL => $returnUrl,
     ];
    }
}
