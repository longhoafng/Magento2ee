<?php

declare(strict_types=1);

namespace LongHoang\VnpayWallet\Gateway\Helper;

use LongHoang\VnpayWallet\Gateway\Request\AbstractDataBuilder;

/**
 * Check the integrity of the data
 */
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
