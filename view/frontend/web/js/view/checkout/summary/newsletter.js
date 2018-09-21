define(
    [
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote'
    ],
    function (Component, quote) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Metagento_NewsletterDiscountPro/checkout/summary/newsletter'
            },
            totals: quote.getTotals(),
            isDisplay: function () {
                if (this.getPureValue()) {
                    return true;
                }
                return false;
            },
            getPureValue: function () {
                var value = 0;
                if(this.getSegment('newsletter_discount')){
                    value = this.getSegment('newsletter_discount').value;
                }
                return value;
            },
            getValue: function () {
                return this.getFormattedPrice(this.getPureValue());
            },
            /**
             * @param code
             * @return {*}
             */
            getSegment: function (code) {
                if (!this.totals()) {
                    return null;
                }

                for (var i in this.totals().total_segments) {
                    var total = this.totals().total_segments[i];

                    if (total.code == code) {
                        return total;
                    }
                }

                return null;
            }
        });
    }
);
