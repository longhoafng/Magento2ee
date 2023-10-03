<?php

declare(strict_types=1);

namespace LongHoang\VnpayWallet\Gateway\Helper;

/**
 * Checkout response code
 */
class ResponseMessage
{
    /**
     * Response code
     */
    const RES_CODE_00 = '00';

    const RES_CODE_01 = '01';

    const RES_CODE_02 = '02';

    const RES_CODE_03 = '03';

    const RES_CODE_04 = '04';

    const RES_CODE_05 = '05';

    const RES_CODE_06 = '06';

    const RES_CODE_07 = '07';

    const RES_CODE_08 = '08';

    const RES_CODE_09 = '09';

    const RES_CODE_10 = '10';

    const RES_CODE_11 = '11';

    const RES_CODE_12 = '12';

    const RES_CODE_51 = '51';

    const RES_CODE_65 = '65';

    const RES_CODE_99 = '99';

    /**
     * Get error message
     *
     * @param string $responseCode
     * @retrun string
     */
    public function getErrorMess(string $responseCode)
    {
        switch ($responseCode) {
            case self::RES_CODE_00:
                $result = __("Successful transaction");
                break;
            case self::RES_CODE_01:
                $result = __("The transaction already exists");
                break;
            case self::RES_CODE_02:
                $result = __("Merchant is invalid (check vnp_TmnCode again)");
                break;
            case self::RES_CODE_03:
                $result = __("The data sent is not in the correct format");
                break;
            case self::RES_CODE_04:
                $result = __("Transaction initiation failed because the Website is temporarily locked");
                break;
            case self::RES_CODE_05:
                $result = __("Transaction failed due to: You entered the wrong password more than the specified number of times. Please retry the transaction");
                break;
            case self::RES_CODE_06:
                $result = __("The transaction was unsuccessful because you entered the wrong transaction authentication password (OTP). Please retry the transaction");
                break;
            case self::RES_CODE_07:
                $result = __("The transaction is suspected to be a fraudulent transaction");
                break;
            case self::RES_CODE_09:
                $result = __("Transaction failed due to: Customer's card/account has not registered for InternetBanking service at the bank.");
                break;
            case self::RES_CODE_10:
                $result = __("Transaction failed due to: Customer verified incorrect card/account information more than 3 times");
                break;
            case self::RES_CODE_11:
                $result = __("Transaction failed due to: Payment waiting period has expired. Please retry the transaction.");
                break;
            case self::RES_CODE_12:
                $result = __("Transaction failed due to: Customer's card/account is locked.");
                break;
            case self::RES_CODE_51:
                $result = __("Transaction failed due to: Your account does not have enough balance to make the transaction.");
                break;
            case self::RES_CODE_65:
                $result = __("Transaction failed due to: Your account has exceeded the transaction limit for the day.");
                break;
            case self::RES_CODE_08:
                $result = __("Transaction failed due to: The Banking system is under maintenance. Please temporarily do not make transactions using this Bank's card/account.");
                break;
            case self::RES_CODE_99:
                $result = __("An error occurred during the transaction");
                break;
            default:
                $result = __("Transaction failed");
        }
        return $result;
    }
}
