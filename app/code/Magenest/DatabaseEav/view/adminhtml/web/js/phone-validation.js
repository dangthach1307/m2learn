/*
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Thach The Dang.
 *
 */

define(['jquery'], function($) {
    'use strict';
    $(document).ready(function() {
        $('#telephone').on('blur', function() {
            let phoneNumber = $(this).val();
            $('#phone-error').hide();

            // Kiểm tra xem số điện thoại có bắt đầu bằng +84 không
            if (phoneNumber.startsWith('+84')) {
                phoneNumber = '0' + phoneNumber.substring(3); // Chuyển đổi +84 thành 0
                $(this).val(phoneNumber);
            }

            // Kiểm tra độ dài
            if (phoneNumber.length > 10) {
                $('#phone-error').text('Số điện thoại không được quá 10 chữ số.').show();
            } else if (!/^0[0-9]{9}$/.test(phoneNumber)) {
                $('#phone-error').text('Số điện thoại phải bắt đầu bằng 0 và có độ dài 10 chữ số.').show();
            }
        });
    });
});
