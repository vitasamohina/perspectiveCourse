/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Magento_Ui/js/form/element/single-checkbox'
], function (checkbox) {
    'use strict';

    return checkbox.extend({
        defaults: {
            linkedValueTo: '',
            linkedValueFrom: '',
            percent: '',
            listens: {
                checked: 'onCheckedChanged'
            }

        },

        /**
         * @returns {Element}
         */
        initObservable: function () {
            return this
                ._super()
                .observe(['linkedValueTo', 'linkedValueFrom', 'percent']);
        },

        /**
         * @inheritdoc
         */
        onCheckedChanged: function (newChecked) {
            if (!newChecked) {
                this.linkedValueTo(Math.round(this.linkedValueFrom()*((parseInt(this.percent()) + 100)/100)));

            }
            this._super(newChecked);

        }
    });
});
