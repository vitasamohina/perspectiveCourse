define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (Component,
              rendererList) {
        'use strict';
        rendererList.push(
            {
                type: 'simple',
                component: 'Samohina_MyPay/js/view/payment/method-renderer/mypay-method'
            }
        );
        return Component.extend({});
    }
);
