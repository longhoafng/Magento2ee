<?php

declare(strict_types=1);

namespace LongHoang\VnpayWallet\Gateway\Http;

use LongHoang\VnpayWallet\Gateway\Helper\CheckData;
use LongHoang\VnpayWallet\Gateway\Request\AbstractDataBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;

/**
 * Abstract transfer factory class
 */
abstract class AbstractTransferFactory implements TransferFactoryInterface
{
    /** @var ScopeConfigInterface $scopeConfig */
    protected $scopeConfig;

    /**
     * @var CheckData $checkData
     */
    protected $checkData;

    /**
     * @var Json jsonFac
     */
    protected $jsonFac;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param CheckData $checkData
     * @param Json $json
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        CheckData            $checkData,
        Json                 $json
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->checkData   = $checkData;
        $this->jsonFac     = $json;
    }

    /**
     * Return payment url
     * @retrun string
     */
    protected function getUrl()
    {
        return $this->scopeConfig->getValue('payment/vnpay/payment_url');
    }

    /**
     * Return class CheckData
     * @return CheckData
     */
    protected function getCheckData()
    {
        return $this->checkData;
    }

    /**
     * Return terminal code
     * @return array
     */
    protected function getPartnerInfo()
    {
        return [
            AbstractDataBuilder::TERMINAL_CODE => $this->scopeConfig->getValue('payment/vnpay/tmn_code')
        ];
    }

    /**
     * Return hash code
     * @return mixed
     */
    protected function getSecretKey()
    {
        return $this->scopeConfig->getValue('payment/vnpay/hash_code');
    }
}
