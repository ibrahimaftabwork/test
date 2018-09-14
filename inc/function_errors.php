<?
function empty_field_error($error, $error_text = "You forgot to enter ", $fixed = NULL) {
    $f = NULL;
    if($fixed == 'fixed')
        $f = $fixed;
    return "<p class='error $f'><span><i class='icon-close'></i>$error_text&nbsp;<strong>$error</strong></span></p>";
}
function error($error_text, $fixed = NULL) {
    $f = NULL;
    if($fixed == 'fixed')
        $f = $fixed;
    return "<p class='error $f'><span><i class='icon-close'></i>$error_text</span></p>";
}
