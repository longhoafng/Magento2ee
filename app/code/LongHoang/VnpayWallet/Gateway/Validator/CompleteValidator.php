<?php
namespace LongHoang\VnpayWallet\Gateway\Validator;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Payment\Gateway\Validator\AbstractValidator;
use Magento\Payment\Gateway\Validator\ResultInterfaceFactory;

class CompleteValidator extends AbstractValidator
{

    /**
     * @var ScopeConfigInterface scopseConfig
     */
    private $scopeConfig;

    public function __construct(
        ResultInterfaceFactory $resultFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($resultFactory);
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param array $validationSubject
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function validate(array $validationSubject)
    {
        $SECURE_SECRET = $this->scopeConfig->getValue('payment/vnpay/hash_code');
        $vnp_SecureHash = $validationSubject['vnp_SecureHash'];

        unset($validationSubject['vnp_SecureHashType']);
        unset($validationSubject['vnp_SecureHash']);

        ksort($validationSubject);
        $i = 0;
        $hashData = "";
        foreach ($validationSubject as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $SECURE_SECRET);

        return isset($vnp_SecureHash) && $secureHash === (string)$vnp_SecureHash;
    }
}
