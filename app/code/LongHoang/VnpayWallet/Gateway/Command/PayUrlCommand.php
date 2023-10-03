<?php

declare(strict_types=1);

namespace LongHoang\VnpayWallet\Gateway\Command;

use Magento\Payment\Gateway\CommandInterface;
use Magento\Payment\Gateway\Http\ClientException;
use Magento\Payment\Gateway\Http\ConverterException;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;

/**
 * Build url command
 */
class PayUrlCommand implements CommandInterface
{
    /**
     * @var BuilderInterface requestBuilder
     */
    private $requestBuilder;

    /**
     * @var TransferFactoryInterface transferFactory
     */
    private $transferFactory;

    /**
     * Constructor
     *
     * @param BuilderInterface         $requestBuilder
     * @param TransferFactoryInterface $transferFactory
     */
    public function __construct(
        BuilderInterface $requestBuilder,
        TransferFactoryInterface $transferFactory,
    ) {
        $this->requestBuilder  = $requestBuilder;
        $this->transferFactory = $transferFactory;
    }

    /**
     * Execute command
     * @param array $commandSubject
     * @throws ClientException
     * @throws ConverterException
     */
    public function execute(array $commandSubject)
    {
        return $this->transferFactory->create($this->requestBuilder->build($commandSubject));
    }
}
