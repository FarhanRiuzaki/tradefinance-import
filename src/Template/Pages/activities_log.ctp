<div class="m-portlet m-portlet--tab">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    <?=$titlesubModule;?>
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                </li>
            </ul>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="m-list-timeline">
            <div class="m-list-timeline__group">
                <div class="m-list-timeline__heading">
                    Apps Logs
                </div>
                <div class="m-list-timeline__items">
                <?php $a = 0;?>
                <?php foreach($auditLogs as $key => $log):?>
                    <?php 
                        if($a == 0){
                            $classes = "m-list-timeline__badge--success";
                        }else if($a == 1){
                            $classes = "m-list-timeline__badge--danger";
                        }else if($a == 2){
                            $classes = "m-list-timeline__badge--warning";
                        }else if($a == 3){
                            $classes = "m-list-timeline__badge--info";
                            $a = 0;
                        }
                    ?>
                    <div class="m-list-timeline__item">
                        <span class="m-list-timeline__badge <?=$classes;?>"></span>
                        <a href="#" class="m-list-timeline__text"><?=$log['description'];?> by id : <?=$log['id'];?></a>
                        <span class="m-list-timeline__time"><?=$log['time'];?></span>
                    </div>
                    <?php $a++;?>
                <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>