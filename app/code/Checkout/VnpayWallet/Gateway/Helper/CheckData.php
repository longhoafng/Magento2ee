<?php

namespace Checkout\VnpayWallet\Gateway\Helper;

use Checkout\VnpayWallet\Gateway\Request\AbstractDataBuilder;

class CheckData
{
    /**
     * Check data
     *
     * @param $data
     * @return boolean
     */
    public function checkData($data): bool
    {
        foreach ($this->getSignatureData() as $key) {
            if (empty($data[$key])) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array
     */
    public function getSignatureData(): array
    {
        return [
            AbstractDataBuilder::VERSION,
            AbstractDataBuilder::TERMINAL_CODE,
            AbstractDataBuilder::AMOUNT,
            AbstractDataBuilder::COMMAND,
            AbstractDataBuilder::CREATE_DATE,
            AbstractDataBuilder::CURRENCY_CODE,
            AbstractDataBuilder::IP_ADDRESS,
            AbstractDataBuilder::LOCALE,
            AbstractDataBuilder::ORDER_TYPE,
            AbstractDataBuilder::ORDER_INFO,
            AbstractDataBuilder::RETURN_URL,
            AbstractDataBuilder::TXN_REF,
        ];
    }
}
