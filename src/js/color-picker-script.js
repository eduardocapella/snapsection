jQuery(document).ready(function($) {
    $(".color-picker").wpColorPicker({
        change: function(event, ui) {
            $("#" + event.target.id + "_code").val(ui.color.toString());
        }
    });
});