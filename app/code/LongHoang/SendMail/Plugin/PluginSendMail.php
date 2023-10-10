<?php

declare(strict_types=1);

namespace LongHoang\SendMail\Plugin;

use LongHoang\SendMail\Block\Adminhtml\Order\ModalBox;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\ObjectManagerInterface;
use Magento\Sales\Block\Adminhtml\Order\View;

/**
 * Plugin send mail
 */
class PluginSendMail
{
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var UrlInterface
     */
    protected $backendUrl;

    /**
     * @param ObjectManagerInterface $om
     * @param UrlInterface $backendUrl
     */
    public function __construct(
        ObjectManagerInterface $om,
        UrlInterface $backendUrl
    ) {
        $this->objectManager = $om;
        $this->backendUrl = $backendUrl;
    }

    /**
     * Create button to send email
     *
     * @param View $subject
     * @param $layout
     * @return string[]
     */
    public function beforeSetLayout(View $subject, $layout)
    {
        $subject->addButton(
            'sendconfigemail',
            [
                'label' => __('Send Pre-config Email'),
                'onclick' => "",
                'class' => 'send-mail'
            ]
        );
        return [$layout];
    }

    /**
     * Create modal box
     *
     * @param View $subject
     * @param $result
     * @return mixed|string
     * @throws LocalizedException
     */
    public function afterToHtml(
        View $subject,
        $result
    ) {
        if ($subject->getNameInLayout() == 'sales_order_edit') {
            $customBlockHtml = $subject->getLayout()->createBlock(
                ModalBox::class,
                $subject->getNameInLayout() . '_modal_box'
            )->setOrder($subject->getOrder())
                ->setTemplate('LongHoang_SendMail::order/modalbox.phtml')
                ->toHtml();
            return $result . $customBlockHtml;
        }
        return $result;
    }
}
