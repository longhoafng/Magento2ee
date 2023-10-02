<?php
//
//namespace Checkout\CustomizeProcess\Block;
//
//use Magento\Checkout\Block\Checkout\AttributeMerger;
//use Magento\Customer\Model\AttributeMetadataDataProvider;
//use Magento\Eav\Api\Data\AttributeInterface;
//use Magento\Framework\Exception\LocalizedException;
//use Magento\Ui\Component\Form\AttributeMapper;
//
//class LayoutProcessor implements \Magento\Checkout\Block\Checkout\LayoutProcessorInterface
//{
//    /**
//     * @var AttributeMerger
//     */
//    private AttributeMerger $merger;
//    /**
//     * @var AttributeMapper
//     */
//    private AttributeMapper $attributeMapper;
//
//    /**
//    * @var AttributeMetadataDataProvider
//    */
//    private AttributeMetadataDataProvider $attributeMetadataDataProvider;
//
//    public function __construct(
//        AttributeMerger $merger,
//        AttributeMapper $attributeMapper,
//        AttributeMetadataDataProvider $attributeMetadataDataProvider
//    ) {
//        $this->merger = $merger;
//        $this->attributeMapper = $attributeMapper;
//        $this->attributeMetadataDataProvider = $attributeMetadataDataProvider;
//    }
//
//    /**
//     * @throws LocalizedException
//     */
//    public function process($jsLayout): array
//    {
//        $elements = $this->getAddressAttributes();
//        $fields = &$jsLayout['components']['checkout']['children']['steps']['children']['vote-step']
//            ['children']['vote']['children']['vote-fieldset']['children'];
//        $fieldCodes = array_keys($fields);
//        $elements = array_filter($elements, function ($key) use ($fieldCodes) {
//            return in_array($key, $fieldCodes);
//        }, ARRAY_FILTER_USE_KEY);
//        $fields = $this->merger->merge(
//            $elements,
//            'checkoutProvider',
//            'vote',
//            $fields
//        );
//        return $jsLayout;
//    }
//
//    /**
//     * @throws LocalizedException
//     */
//    private function getAddressAttributes() : array
//    {
//        /**
//         * @var AttributeInterface[] $attributes
//         */
//        $attributes = $this->attributeMetadataDataProvider->loadAttributesCollection(
//            'customer_address',
//            'customer_register_address'
//        );
//
//        $elements = [];
//
//        foreach ($attributes as $attribute) {
//            $code = $attribute->getAttributeCode();
//            $elements[$code] = $this->attributeMapper->map($attribute);
//            if (isset($elements[$code]['label'])) {
//                $label = $elements[$code]['label'];
//                $elements[$code]['label'] = __($label);
//            }
//        }
//
//        return $elements;
//    }
//}


//<!-- <?xml version="1.0"?><!-- -->-->
<!--<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">-->
<!--    <type name="Magento\Checkout\Block\Onepage">-->
<!--        <arguments>-->
<!--            <argument name="layoutProcessors" xsi:type="array">-->
<!--                <item name="VoteCheckoutLayoutProcessor" xsi:type="object">Checkout\CustomizeProcess\Block\LayoutProcessor</item>-->
<!--            </argument>-->
<!--        </arguments>-->
<!--    </type>-->
<!--</config>-->
