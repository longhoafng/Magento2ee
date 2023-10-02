<?php
namespace Checkout\CustomizeProcess\Controller\Index;

use Hoa\Exception\Error;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $quoteIdMaskFactory;

    protected $quoteRepository;
    protected $resultJsonFactory;

    protected \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
    ) {
        parent::__construct($context);
        $this->quoteRepository = $quoteRepository;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return mixed
     * @throws NoSuchEntityException
     * @throws LocalizedException
     * @throws \Exception
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $post = $this->getRequest()->getPostValue();
        if ($post) {
            $cartId       = $post['cartId'];
            $income        = $post['income'];
            $hobby        = $post['hobby'];
            $loggin       = $post['is_customer'];
            $customerId   = $post['customer_id'];

            if ($loggin === 'false') {
                $cartId = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id')->getQuoteId();
            }

            $quote = $this->quoteRepository->getActive($cartId);
            if (!$quote->getItemsCount()) {
                throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
            }

            $customer = $this->customerRepository->getById($customerId);

            if (!$customer) {
                throw new NoSuchEntityException(__('Cannot get the customer'));
            }

            $customer->setCustomAttribute('customer_hobby', $hobby);
            $customer->setCustomAttribute('customer_income', $income);
            $savedAttribute = $this->customerRepository->save($customer);
            if (!$savedAttribute) {
                throw new Error('Can not save custom attribute');
            }
        }
    }
}
