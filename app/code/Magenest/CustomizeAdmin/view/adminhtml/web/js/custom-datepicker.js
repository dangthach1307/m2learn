// define('Magenest_CustomizeAdmin/js/calendar-mixin', [
//     'Magento_Ui/js/form/element/date',
//     'jquery',
//     'mage/calendar'
// ], function (Element, $) {
//     'use strict';
//
//     return Element.extend({
//         defaults: {
//             options: {
//                 showsTime: true,
//                 beforeShowDay: function(date) {
//                     if(date.getDate() >= 8 && date.getDate() <= 12) {
//                         return [true, ''];
//                     }
//                     return [false, ''];
//                 }
//             }
//         },
//
//         initialize: function () {
//             this._super();
//
//             var self = this;
//
//             // Use setTimeout to ensure the element is rendered
//             setTimeout(function() {
//                 $(self.element).calendar(self.options);
//             }, 0);
//
//             return this;
//         }
//     });
// });
define('Magenest_CustomizeAdmin/js/custom-datepicker', [
    'Magento_Ui/js/form/element/date',
    'jquery',
    'mage/calendar'
], function (Element, $) {
    'use strict';

    return Element.extend({
        defaults: {
            options: {
                dateFormat: 'mm/dd/yy',
                showsTime: true,
                timeFormat: 'HH:mm:ss',
                showSecond: true,
                beforeShowDay: function(date) {
                    if(date.getDate() >= 8 && date.getDate() <= 12) {
                        return [true, ''];
                    }
                    return [false, ''];
                }
            }
        },

        initialize: function () {
            this._super();

            var self = this;

            setTimeout(function() {
                $(self.element).calendar(self.options);
            }, 0);

            return this;
        }
    });
});
