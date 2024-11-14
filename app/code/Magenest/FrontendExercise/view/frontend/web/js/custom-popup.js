define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/modal',
    'Magento_Customer/js/model/authentication-popup',
    'mage/translate'
], function ($, alert, modal, authenticationPopup, $t) {
    'use strict';

    return function (config, element) {
        var $element = $(element);

        // Normal Alert
        $element.on('click', '[data-trigger="normal-alert"]', function () {
            alert({
                title: $t('Alert'),
                content: $t('Hello World!')
            });
        });

        // Magento Alert Modal
        var $magentoAlertContent = $('#magento-alert-content');
        var magentoAlertModal = modal({
            type: 'popup',
            responsive: true,
            title: $t('Main title'),
            buttons: [{
                text: $t('Ok'),
                class: '',
                click: function () {
                    this.closeModal();
                }
            }]
        }, $magentoAlertContent);

        $element.on('click', '[data-trigger="magento-alert"]', function () {
            magentoAlertModal.openModal();
        });


        // Custom Login Modal
        var $customLoginContent = $('#custom-login-content');
        var customLoginModal = modal({
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: $t('Custom Login Modal'),
            buttons: [{
                text: $t('Close'),
                class: '',
                click: function () {
                    this.closeModal();
                }
            }]
        }, $customLoginContent);

        $element.on('click', '[data-trigger="custom-login"]', function () {
            customLoginModal.openModal();
        });

        // Custom login form validation
        $('#custom-login-form').submit(function (e) {
            if (!$(this).validation('isValid')) {
                e.preventDefault();
            }
        });
    };
});
