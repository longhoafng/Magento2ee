<?php

declare(strict_types=1);

namespace LongHoang\VnpayWallet\Gateway\Helper;

/**
 * Checkout response code
 */
class ResponseMessage
{
    /**
     * Get error message
     *
     * @param string $responseCode
     * @retrun string
     */
    public function getErrorMess(string $responseCode)
    {
        switch ($responseCode) {
            case "00":
                $result = "Giao dịch thành công";
                break;
            case "01":
                $result = "Giao dịch đã tồn tại";
                break;
            case "02":
                $result = "Merchant không hợp lệ (kiểm tra lại vnp_TmnCode)";
                break;
            case "03":
                $result = "Dữ liệu gửi sang không đúng định dạng";
                break;
            case "04":
                $result = "Khởi tạo GD không thành công do Website đang bị tạm khóa";
                break;
            case "05":
                $result = "Giao dịch không thành công do: Quý khách nhập sai mật khẩu quá số lần quy định. Xin quý khách vui lòng thực hiện lại giao dịch";
                break;
            case "06":
                $result = "Giao dịch không thành công do Quý khách nhập sai mật khẩu xác thực giao dịch (OTP). Xin quý khách vui lòng thực hiện lại giao dịch.";
                break;
            case "07":
                $result = "Giao dịch bị nghi ngờ là giao dịch gian lận";
                break;
            case "09":
                $result = "Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.";
                break;
            case "10":
                $result = "Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần";
                break;
            case "11":
                $result = "Giao dịch không thành công do: Đã hết hạn chờ thanh toán. Xin quý khách vui lòng thực hiện lại giao dịch.";
                break;
            case "12":
                $result = "Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng bị khóa.";
                break;
            case "51":
                $result = "Giao dịch không thành công do: Tài khoản của quý khách không đủ số dư để thực hiện giao dịch.";
                break;
            case "65":
                $result = "Giao dịch không thành công do: Tài khoản của Quý khách đã vượt quá hạn mức giao dịch trong ngày.";
                break;
            case "08":
                $result = "Giao dịch không thành công do: Hệ thống Ngân hàng đang bảo trì. Xin quý khách tạm thời không thực hiện giao dịch bằng thẻ/tài khoản của Ngân hàng này.";
                break;
            case "99":
                $result = "Có lỗi sảy ra trong quá trình thực hiện giao dịch";
                break;
            default:
                $result = "Giao dịch thất bại - Failured";
        }
        return $result;
    }
}
