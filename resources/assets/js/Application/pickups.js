import mixitup from 'mixitup';

(function ($) {
    var containerEl = document.querySelector('.pickups-list');
    if (containerEl)
        mixitup(containerEl,
            {
                selectors: {
                    control: '[data-mixitup-control]'
                },
                animation: {
                    clampHeight: false
                }
            });

    $(document).ready(function () {
        $(".pickup-item").each(function () {
            $(this).css({
                "max-height": $(this).innerHeight()
            });
        });
        $(".pickup-toggle-details").on('click', function () {
            var $this = $(this);
            var $parent = $this.closest('.pickup-item');
            var expanded = $this.attr("aria-expanded") !== "true";
            if (expanded) {
                $('body').addClass('lock-screen');
                $parent.addClass('item-expanded');
            } else {
                setTimeout(function () {
                    $parent.removeClass('item-expanded');
                    $('body').removeClass('lock-screen');
                }, 350)
            }
        });
        $(document).on('click', 'body.lock-screen', function (e) {
            e.stopPropagation();
            if ($(e.target).closest('.item-expanded').length === 0) {
                var $expanded = $('.item-expanded');
                $expanded.find(".pickup-meta.collapse").collapse('hide')
                setTimeout(function () {
                    $expanded.removeClass('item-expanded');
                    $('body').removeClass('lock-screen');
                }, 350)
            }
        });
    });

    let pickupForm = document.querySelector('.pickup-form');
    if(pickupForm) {
        $(pickupForm.querySelector("#client_account_number")).on('select2:select', e => {
            let client = e.params.data;
            pickupForm.querySelector('#client_name').value = client.trade_name;
            pickupForm.querySelector('#phone_number').value = client.phone_number;
            pickupForm.querySelector('#pickup_address_text').value = client.address_pickup_text;
            pickupForm.querySelector('#pickup_address_maps').value = client.address_pickup_maps;
        });
    }

    let pills = document.querySelector('.pickup-pills');
    if(pills) {
        pills.querySelectorAll('.nav-link').forEach(item => {
            let filter = item.dataset.filter;
            let count = document.querySelector('.pickups-list').querySelectorAll(filter).length;
            item.querySelector('.badge').textContent = count;
        });
    }
})(jQuery);