define([
    'uiComponent',
    'Magento_Checkout/js/model/step-navigator',
    'underscore',
    'ko',
    'mage/translate',
    'jquery',
    'mage/utils/wrapper',
    'Magento_CheckoutAgreements/js/model/agreements-assigner',
    'Magento_Checkout/js/model/quote',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/url-builder',
    'mage/url',
    'Magento_Checkout/js/model/error-processor',
    'uiRegistry'
], function (
    Component,
    stepNavigator,
    _,
    ko,
    $t,
    $,
    wrapper,
    agreementsAssigner,
    quote,
    customer,
    urlBuilder,
    urlFormatter,
    ) {
    'use strict';

    return Component.extend({

        defaults: {
            template: 'Checkout_CustomizeProcess/custom-checkout-form'
        },

        isVisible: ko.observable(true),

        initialize: function () {
            this._super();
            stepNavigator.registerStep('vote-step', null, $t('Vote'), this.isVisible, _.bind(this.navigate, this), 15);
            return this;
        },

        navigate: function () {
            this.isVisible(true);
        },

        setVoteInformation: function () {
                    var isCustomer = customer.isLoggedIn();
                    var customerId = customer.customerData.id;
                    var quoteId = quote.getQuoteId();

                    var url = urlFormatter.build(window.BASE_URL + 'customer_vote');

                    var hobby = $('[name="hobby"]').val();
                    var income = $('[name="income_range"]').val();


                    if (hobby || income) {

                        var payload = {
                            'cartId': quoteId,
                            'hobby': hobby,
                            'income': income,
                            'is_customer': isCustomer,
                            'customer_id': customerId
                        };

                        if (!payload.hobby || !payload.income) {
                            throw new Error('Cannot get hobby or income');
                            return true;
                        }

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: payload,
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    $('#result').text(response.message);
                                } else {
                                    $('#result').text('Error: ' + response.error);
                                }
                            },
                            error: function(response) {
                                $('#result').text('An error occurred while processing the request.');
                            }
                        });
                    }
            stepNavigator.next();
        }
    });
});
