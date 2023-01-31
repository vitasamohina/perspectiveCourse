define([
    'jquery',
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function ($, Component, customerData) {
    'use strict';

    return Component.extend({
        /** @inheritdoc */
        initialize: function () {
            this._super();
            this.customsection = customerData.get('customsection');
            console.log(typeof this.customsection());
           if (Object.keys(this.customsection()).length == 0 || this.customsection().customer_city == ''){
               $.ajax({
                   url: 'city_by_ip/index/index',
                   data: {city: ''},
                   type: "POST",
                   success: function (res) {
                   },
                   error: function (xhr, status, error) {
                       var err = eval("(" + xhr.responseText + ")");
                   }
               })
            }
        }
    });
});
