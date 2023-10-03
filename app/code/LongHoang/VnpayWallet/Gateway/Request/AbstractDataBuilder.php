<?php
namespace LongHoang\VnpayWallet\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;
abstract class AbstractDataBuilder implements BuilderInterface
{
    /**
     * Terminal Code
     */
    const TERMINAL_CODE = 'vnp_TmnCode';

    /**
     * Order Info
     */
    const ORDER_INFO = 'vnp_OrderInfo';

    /**
     * Return Url
     */
    const RETURN_URL = 'vnp_ReturnUrl';

    /**
     * Amount
     */
    const AMOUNT = 'vnp_Amount';

    /**
     * Api version
     */
    const VERSION = 'vnp_Version';

    /**
     * Command
     */
    const COMMAND = 'vnp_Command';

    /**
     * Create date
     */
    const CREATE_DATE = 'vnp_CreateDate';

    /**
     * Currency code
     */
    const CURRENCY_CODE = 'vnp_CurrCode';

    /**
     * Ip Address
     */
    const IP_ADDRESS = 'vnp_IpAddr';

    /**
     * Locale
     */
    const LOCALE = 'vnp_Locale';

    /**
     * Order type
     */
    const ORDER_TYPE = 'vnp_OrderType';

    /**
     * TXN REF
     */
    const TXN_REF = 'vnp_TxnRef';

    /**
     * Secure hash
     */
    const SECURE_HASH = 'vnp_SecureHash';
}
