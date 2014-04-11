(function($) {

    var enabled = !('placeholder' in $('<input type="text">')[0]);

    $.fn.cleardefault = function() {

        // Cleardefault is not necessary, browser does support placeholder natively
        if (!enabled) {
            return this;
        }

        return this.each(function() {
            var el = $(this);

            // Password fields
            if (el.prop('tagName') == 'INPUT' && el.attr('type') == 'password') {
                var text = $('<input type="text" class="'+el.attr('class')+' cleardefault" value="'+el.attr('placeholder')+'"').on('focus', function() {
                    text.hide();
                    el.show().focus();
                }).insertBefore(el);

                el.hide().on('blur', function() {
                    if (el.attr('value') == '') {
                        el.hide();
                        text.show();
                    }
                });
            }

            // Other text fields
            else if (el.attr('placeholder') && ((el.prop('tagName') == 'INPUT' && $.inArray(el.attr('type'), ['text', 'search', 'url', 'tel', 'email']) != -1) || (el.prop('tagName') == 'TEXTAREA'))) {

                if (el[0].value == '') {
                    el.addClass('cleardefault');
                    el[0].value = el.attr('placeholder');
                }

                el.on('focus', function() {
                    if (el[0].value == el.attr('placeholder')) {
                        el.removeClass('cleardefault');
                        el[0].value = '';
                    }
                }).on('blur', function() {
                    if (el[0].value == '') {
                        el.addClass('cleardefault');
                        el[0].value = el.attr('placeholder');
                    }
                });
            }
        });
    }

    $('input[placeholder], textarea').cleardefault();
})(jQuery);