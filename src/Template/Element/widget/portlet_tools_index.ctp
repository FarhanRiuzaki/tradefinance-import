<div class="m-portlet__head-tools">
    <div class="m-btn-group btn-group btn-group-sm btn-toolbar" role="group" aria-label="button-group-tabble">
        <?php if(!empty($rightButton)):?>
        <?=$rightButton;?>
        <?php endif;?>	
        <a href="#"  m-portlet-tool="toggle" class="m-btn btn btn-info "><i class="la la-angle-down"></i></a>	
        <a href="#"  m-portlet-tool="fullscreen" class="m-m-btn btn btn-warning "><i class="la la-expand"></i></a>	
        <a href="#" m-portlet-tool="remove" class="m-m-btn btn btn-danger "><i class="la la-close"></i></a>
    </div>
</div>