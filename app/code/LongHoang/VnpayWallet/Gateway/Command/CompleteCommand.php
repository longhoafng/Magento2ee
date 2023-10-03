<?php

declare(strict_types=1);

namespace LongHoang\VnpayWallet\Gateway\Command;

use Magento\Payment\Gateway\CommandInterface;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Payment\Gateway\Validator\ValidatorInterface;

/**
 * Complete command payment
 */
class CompleteCommand implements CommandInterface
{
    /**
     * @var SubjectReader $subjectReader
     */
    private $subjectReader;

    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    /**
     * @var HandlerInterface
     */
    private $handler;

    /**
     * @param SubjectReader $subjectReader
     * @param ValidatorInterface $validator
     * @param HandlerInterface $handler
     */
    public function __construct(
        SubjectReader $subjectReader,
        ValidatorInterface $validator,
        HandlerInterface $handler,
    ) {
        $this->subjectReader        = $subjectReader;
        $this->validator            = $validator;
        $this->handler   = $handler;
    }

    /**
     * Execute command
     *
     * @param array $commandSubject
     */
    public function execute(array $commandSubject)
    {
        $response = $this->subjectReader->readResponse($commandSubject);

        if ($this->validator) {
            $result = $this->validator->validate($response);
            if ($result) {
                $this->handler->handle($commandSubject, $response);
                return true;
            } else {
                return false;
            }
        }
    }
}
