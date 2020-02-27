
<!--Begin::Main Portlet-->
<div class="kt-portlet">
    <div class="kt-portlet__body  ">
        <div class="row kt-row--no-padding kt-row--col-separator-xl">
        <div class="col-xl-12">
            <h5>SELAMAT DATANG DI:</h5>
            <h3><?=$defaultAppSettings['App.Name'];?> </h3><br>
            <p>
                <b>Anda login sebagai</b> : <?=$userData->name;?><br>
                <b>Username</b> :  <?=$userData->username;?> <br>
                <b>Email</b> : <?=$userData->email;?><br>
                <b>Group</b> : <?=$userData->user_group->name;?>
            </p>
            <p>
                <?=$userData->user_group->descriptions;?>
            </p>

        </div>
        </div>
    </div>
</div>
<!--End::Main Portlet-->