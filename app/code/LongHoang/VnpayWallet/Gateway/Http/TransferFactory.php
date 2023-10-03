<?php

declare(strict_types=1);

namespace LongHoang\VnpayWallet\Gateway\Http;

/**
 * Prepare data to send to payment processor
 */
class TransferFactory extends AbstractTransferFactory
{
    /**
     * Prepare data
     *
     * @inheritdoc
     */
    public function create(array $request)
    {
        $request = array_replace_recursive($request, $this->getPartnerInfo());
        $result = $this->getCheckData()->checkData($request);
        if ($result) {
            ksort($request);
            $query = "";
            $i = 0;
            $hashdata = "";
            $url = $this->getUrl();
            foreach ($request as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $url . "?" . $query;
            $SECURE_SECRET = $this->getSecretKey();
            if (isset($SECURE_SECRET)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $SECURE_SECRET);
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }

            $this->jsonFac->setData($vnp_Url);
            return $this->jsonFac;
        }
    }
}
