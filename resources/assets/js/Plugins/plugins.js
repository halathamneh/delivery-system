require('./autogrow');
require('./iosComponents');
require('./rangeSlider');
require('./select2');
require('./tables');
require('./datePickers');
require('./rateit');
require('./editor');
require('./wizards');
require('./liveTitles');
require('./charts');
require('bootstrap-select');

(function ($) {
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
})(jQuery)