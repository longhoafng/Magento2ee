<?php
namespace LongHoang\VnpayWallet\Gateway\Http;

use LongHoang\VnpayWallet\Gateway\Helper\CheckData;
use LongHoang\VnpayWallet\Gateway\Request\AbstractDataBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;

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
     * AbstractTransferFactory constructor.
     *
     * @param CheckData       $checkData
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
     * @retrun string
     */
    protected function getUrl()
    {
        return $this->scopeConfig->getValue('payment/vnpay/payment_url');
    }

    /**
     * @return CheckData
     */
    protected function getCheckData()
    {
        return $this->checkData;
    }

    /**
     * @return array
     */
    protected function getPartnerInfo()
    {
        return [
            AbstractDataBuilder::TERMINAL_CODE => $this->scopeConfig->getValue('payment/vnpay/tmn_code')
        ];
    }

    /**
     * @return mixed
     */
    protected function getSecretKey()
    {
        return $this->scopeConfig->getValue('payment/vnpay/hash_code');
    }
}
