define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'vnpay',
                component: 'Checkout_VnpayWallet/js/view/payment/method-renderer/vnpay-method'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);
