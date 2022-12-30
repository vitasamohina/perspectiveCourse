define([
    "uiComponent",
    "jquery",
    "Magento_Ui/js/modal/modal"
], function (Component, $, modal) {
    "use strict";

    return Component.extend({
        initialize: function () {
            this._super();
            var options = {
                type: "popup",
                responsive: true,
                innerScroll: false,
                title: 'Купить в 1 клик',
                buttons: false
            };

            var purchase_form_element = $("#purchase-form");
            modal(options, purchase_form_element);

            $(".primary.one-click").click(function () {
                purchase_form_element.css("display", "block");

                this.openModalOverlayModal();
            }.bind(this));
        },

        openModalOverlayModal: function () {
            var modalContainer = $("#purchase-form");
            modalContainer.modal("openModal");
        }
    });
});
