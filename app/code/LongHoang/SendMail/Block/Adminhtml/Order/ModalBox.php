<?php

declare(strict_types=1);

namespace LongHoang\SendMail\Block\Adminhtml\Order;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;

/**
 * Class ModalBox
 */
class ModalBox extends Template
{

    /**
     * Constructor
     *
     * @param Context  $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return __('Are you sure you want to send an order email to pre-config email?');
    }

    /**
     * @return string
     */
    public function getFormUrl()
    {
        $orderId = false;
        if ($this->hasData('order')) {
            $orderId = $this->getOrder()->getId();
        }
        return $this->getUrl('sendconfigmail/order/mail', [
            'order_id' => $orderId
        ]);
    }
}
