/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @api
 */
define([
    'jquery',
    'jquery/validate',
    'mage/translate'
], function ($) {
    'use strict';

    return function (validator) {
        validator.addRule(
            "msp-validate-emails",
            function (value) {
                var validRegexp, emails, i;

                if (!value) {
                    return true;
                }

                validRegexp = /^[a-z0-9\._-]{1,30}@([a-z0-9_-]{1,30}\.){1,5}[a-z]{2,4}$/i;
                emails = value.split(/\n+/g);

                for (i = 0; i < emails.length; i++) {
                    if (!validRegexp.test(emails[i].trim())) {
                        return false;
                    }
                }

                return true;
            },
            $.mage.__('Please enter valid email addresses. Multiple email must be in multiple lines. For example.')
        );

        return validator;
    }
});