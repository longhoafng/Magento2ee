<?php
namespace Checkout\CustomizeProcess\Plugin\Checkout;

use Magento\Eav\Model\Config;
use Magento\Framework\Exception\LocalizedException;

class LayoutProcessorPlugin
{
    protected $eavConfig;

    /**
     * @param Config $eavConfig
     */
    public function __construct(
        Config $eavConfig
    ) {
        $this->eavConfig = $eavConfig;
    }

    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     * @throws LocalizedException
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        $customerHobby = "customer_hobby";
        $attribute = $this->eavConfig->getAttribute('customer', $customerHobby);
        $hobbies = $attribute->getSource()->getAllOptions();

        $bobbyOpts = [];
        foreach ($hobbies as $hobby) {
            if ($hobby['value'] > 0) {
                $bobbyOpts[] = [
                    'label' => $hobby['label'],
                    'value' => $hobby['value']
                ];
            }
        }

        $jsLayout['components']['checkout']['children']['steps']['children']['vote-step']
        ['children']['vote']['children']['vote-fieldset']['children']['hobby'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'customCheckoutForm',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'hobby'
            ],
            'dataScope' => 'customCheckoutForm.hobby',
            'label' => __('Hobby'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 1,
            'id' => 'hobby',
            'options' => $bobbyOpts
        ];

        $customerIncome = "customer_income";
        $attribute = $this->eavConfig->getAttribute('customer', $customerIncome);
        $incomes = $attribute->getSource()->getAllOptions();

        $incomeOpts = [];
        foreach ($incomes as $income) {
            if ($income['value'] > 0) {
                $incomeOpts[] = [
                    'label' => $income['label'],
                    'value' => $income['value']
                ];
            }
        }

        $jsLayout['components']['checkout']['children']['steps']['children']['vote-step']
        ['children']['vote']['children']['vote-fieldset']['children']['income_range'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'customCheckoutForm',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'income_range'
            ],
            'dataScope' => 'customCheckoutForm.income_range',
            'label' => __('Income Range (per week)'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 2,
            'id' => 'income_range',
            'options' => $incomeOpts
        ];

        return $jsLayout;
    }
}
