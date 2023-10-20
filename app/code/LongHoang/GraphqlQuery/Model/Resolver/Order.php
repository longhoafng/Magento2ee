<?php

declare(strict_types=1);

namespace LongHoang\GraphqlQuery\Model\Resolver;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Customer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

/**
 * Get order infor class
 */
class Order implements ResolverInterface
{
    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param CollectionFactory $orderCollectionFactory
     */
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly CollectionFactory $orderCollectionFactory
    ) {
    }

    /**
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws GraphQlAuthorizationException
     * @throws GraphQlNoSuchEntityException
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!isset($args['customer_email'])) {
            throw new GraphQlAuthorizationException(
                __(
                    'email for customer should be specified',
                    [Customer::ENTITY]
                )
            );
        }

        return $this->getOrderData($args['customer_email']);
    }

    /**
     * @param $customerEmail
     * @return array
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    private function getOrderData($customerEmail) : array
    {
        try {
            $result = [];
            $customer = $this->customerRepository->get($customerEmail);
            $orders = $this->orderCollectionFactory->create()->addFieldToFilter('customer_email', $customerEmail);

            $result['customer_name'] = $customer->getFirstname() . ' ' . $customer->getLastname();
            $result['customer_email'] = $customer->getEmail();

            $result['customer_total_amount'] = 0;

            foreach ($orders as $order) {
                $result['orders'][] = (object) [
                    'increment_id' => $order->getIncrementId(),
                    'order_status' => $order->getStatus(),
                    'order_grand_total' => $order->getGrandTotal()
                ];
                $result['customer_total_amount'] += $order->getTotalPaid() ?? 0;
            }
            return $result ?? [];
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__('Had some error when build order infors'));
        }
    }
}
