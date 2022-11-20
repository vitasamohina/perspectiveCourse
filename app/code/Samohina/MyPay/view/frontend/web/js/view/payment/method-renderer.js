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
                type: 'mypay',
                component: 'Samohina_MyPay/js/view/payment/method-renderer/mypay'
            }
        );
        return Component.extend({});
    }
);
