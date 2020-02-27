<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
    <div class="m-alert__icon">
        <i class="flaticon-circle"></i>
        <span></span>
    </div>
    <div class="m-alert__text">
        <strong>
            <?=$message;?>
        </strong>
    </div>
    <div class="m-alert__close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
    </div>
</div>