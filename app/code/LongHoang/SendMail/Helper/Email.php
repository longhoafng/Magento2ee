<?php

declare(strict_types=1);

namespace LongHoang\SendMail\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Psr\Log\LoggerInterface;

/**
 * Send Mail Class
 */
class Email extends AbstractHelper
{
    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Context $context
     * @param StateInterface $inlineTranslation
     * @param Escaper $escaper
     * @param TransportBuilder $transportBuilder
     */
    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder
    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $context->getLogger();
    }

    /**
     * Send mail function
     *
     * @param OrderInterface $order
     * @param String $email
     * @return void
     */
    public function sendEmail(OrderInterface $order, String $email)
    {
        try {
            $this->inlineTranslation->suspend();

            $sender = [
                'name'  => $this->escaper->escapeHtml('Customer'),
                'email' => $this->escaper->escapeHtml($order->getCustomerEmail()),
            ];

            $transport = $this->transportBuilder
            ->setTemplateIdentifier('pre_config_email_template')
            ->setTemplateOptions(
                [
                    'area'   => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store'  => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ]
            )
            ->setTemplateVars([
                'customer_name'  => $order->getCustomerFirstname(),
                'amount'  => $order->getTotalDue(),
                'status'  => $order->getStatus(),
                'id'  => $order->getIncrementId(),
            ])
            ->setFrom($sender)
                ->addTo($email)
                ->setReplyTo($email)
            ->getTransport();

            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
