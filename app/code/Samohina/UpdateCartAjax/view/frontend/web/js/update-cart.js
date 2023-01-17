define([
    'jquery',
    'Magento_Checkout/js/action/get-totals',
    'Magento_Customer/js/customer-data',
    'domReady!'
], function ($, getTotalsAction, customerData) {
        function ajaxRequest(form, data, type, url) {
            $.ajax({
                url: url,
                data: data,
                showLoader: true,
                type: type,
                success: function (res) {
                    var parsedResponse = $.parseHTML(res);
                    var result = $(parsedResponse).find(form);
                    var sections = ['cart'];

                    $(form).replaceWith(result);

                    // The mini cart reloading
                    customerData.reload(sections, true);

                    // The totals summary block reloading
                    var deferred = $.Deferred();
                    getTotalsAction([], deferred);
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                }
            });
        }
        $(document).on('change', 'input[name$="[qty]"]', function(){
            let form = 'form#form-validate';
            let data = $(form).serialize();
            let type = "GET";
            let url = $(form).attr('action');
            ajaxRequest(form, data, type, url);
        });

        $(document).on('click', '#form-validate .action.action-delete', function(){
            let form = 'form#form-validate';
            let data = $(this).data('cart-item').data;
            $.extend(data, {
                'form_key': $.mage.cookies.get('form_key')
            });
            let type = "POST";
            let url = $(this).data('cart-item').action;
            $.ajax({
                url: url,
                data: data,
                showLoader: true,
                type: type,
                success: function (res) {
                    var parsedResponse = $.parseHTML(res);
                    var result = $(parsedResponse).find(form);

                    var sections = ['cart'];
                    customerData.reload(sections, true);
                    if (result.length > 0){
                        $(form).replaceWith(result);
                        var deferred = $.Deferred();
                        getTotalsAction([], deferred);
                    } else {
                        location.reload()
                    }
             },
             error: function (xhr, status, error) {
                 var err = eval("(" + xhr.responseText + ")");
             }
         });
     })
        $(document).on('change', '.product-item-details [name^="options"]', function(){
            let parent = $(this).parents('.item-info');
            let id= parent.data('id');
            let form = '#form-validate';
            let data = $(this).parents('.item-info').find('[name^="options"]').serialize();
            let type = "POST";
            let url = '/checkout/cart/updateItemOptions/id/'+id;
            $.extend(data, {
                'form_key': $.mage.cookies.get('form_key')
            });
            ajaxRequest(form, data, type, url);
        })
        $(document).on('click', '#discount-coupon-form button.action', function(Event){
            let form = 'form#discount-coupon-form';
            let data = $(form).serialize();
            let type = "POST";
            let url = $(form).attr('action');
            ajaxRequest(form, data, type, url);
        })
});
