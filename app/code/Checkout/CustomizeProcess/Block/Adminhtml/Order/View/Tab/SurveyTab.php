<?php

namespace Checkout\CustomizeProcess\Block\Adminhtml\Order\View\Tab;

use Magento\Eav\Model\Config;
use Magento\Framework\Exception\LocalizedException;

class SurveyTab extends \Magento\Backend\Block\Template implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $_template = 'Checkout_CustomizeProcess::order/view/tab/survey-tab.phtml';
    /**
     * @var \Magento\Framework\Registry
     */
    private $_coreRegistry;

    protected \Magento\Customer\Model\CustomerFactory $customerFactory;
    private \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository;
    private Config $eavConfig;

    /**
     * View constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        Config $eavConfig,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry             $registry,
        array                                   $data = [],
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->eavConfig = $eavConfig;
    }

    /**
     * Retrieve order model instance
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Customer Survey');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Customer Survey');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @throws LocalizedException
     *
     * @return array
     */
    public function getCustomerSurvey()
    {
        /** @var \Magento\Customer\Api\Data\CustomerInterface $customer */
        $customer = $this->customerRepository->get($this->getOrder()->getCustomerEmail());

        $hobbyAttribute = 'customer_hobby';
        $bobbyValue = $customer->getCustomAttribute($hobbyAttribute)->getValue();
        $incomeAttribute = 'customer_income';
        $incomeValue = $customer->getCustomAttribute($incomeAttribute)->getValue();

        $customerIncome = "customer_income";
        $attributeIncome = $this->eavConfig->getAttribute('customer', $customerIncome);

        $customerHobby = "customer_hobby";
        $attributeHobby = $this->eavConfig->getAttribute('customer', $customerHobby);

        return [
            $attributeIncome->getSource()->getOptionText($incomeValue),
            $attributeHobby->getSource()->getOptionText($bobbyValue)
        ];
    }
}
