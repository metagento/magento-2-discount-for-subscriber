require([
        "jquery",
        "loader",
        'Magento_Ui/js/modal/confirm',
        'mage/translate'],
    function ($, loader, confirm) {
        $(document).ready(function () {
            $('#program-delete-button').click(function () {
                var msg = $.mage.__('Are you sure you want to delete?'),
                    url = $('#program-delete-button').data('url');
                confirm({
                    'content': msg,
                    'actions': {

                        /**
                         * 'Confirm' action handler.
                         */
                        confirm: function () {
                            window.location = url;
                        }
                    }
                });

                return false;
            });
        })
    });