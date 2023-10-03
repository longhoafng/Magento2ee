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
                $result = __("Giao dịch thành công");
                break;
            case self::RES_CODE_01:
                $result = __("Giao dịch đã tồn tại");
                break;
            case self::RES_CODE_02:
                $result = __("Merchant không hợp lệ (kiểm tra lại vnp_TmnCode)");
                break;
            case self::RES_CODE_03:
                $result = __("Dữ liệu gửi sang không đúng định dạng");
                break;
            case self::RES_CODE_04:
                $result = __("Khởi tạo GD không thành công do Website đang bị tạm khóa");
                break;
            case self::RES_CODE_05:
                $result = __("Giao dịch không thành công do: Quý khách nhập sai mật khẩu quá số lần quy định. Xin quý khách vui lòng thực hiện lại giao dịch");
                break;
            case self::RES_CODE_06:
                $result = __("Giao dịch không thành công do Quý khách nhập sai mật khẩu xác thực giao dịch (OTP). Xin quý khách vui lòng thực hiện lại giao dịch.");
                break;
            case self::RES_CODE_07:
                $result = __("Giao dịch bị nghi ngờ là giao dịch gian lận");
                break;
            case self::RES_CODE_09:
                $result = __("Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.");
                break;
            case self::RES_CODE_10:
                $result = __("Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần");
                break;
            case self::RES_CODE_11:
                $result = __("Giao dịch không thành công do: Đã hết hạn chờ thanh toán. Xin quý khách vui lòng thực hiện lại giao dịch.");
                break;
            case self::RES_CODE_12:
                $result = __("Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng bị khóa.");
                break;
            case self::RES_CODE_51:
                $result = __("Giao dịch không thành công do: Tài khoản của quý khách không đủ số dư để thực hiện giao dịch.");
                break;
            case self::RES_CODE_65:
                $result = __("Giao dịch không thành công do: Tài khoản của Quý khách đã vượt quá hạn mức giao dịch trong ngày.");
                break;
            case self::RES_CODE_08:
                $result = __("Giao dịch không thành công do: Hệ thống Ngân hàng đang bảo trì. Xin quý khách tạm thời không thực hiện giao dịch bằng thẻ/tài khoản của Ngân hàng này.");
                break;
            case self::RES_CODE_99:
                $result = __("Có lỗi sảy ra trong quá trình thực hiện giao dịch");
                break;
            default:
                $result = __("Giao dịch thất bại");
        }
        return $result;
    }
}
