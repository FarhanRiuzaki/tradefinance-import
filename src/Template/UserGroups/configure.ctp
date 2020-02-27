<?php
    $this->start('sub_header_toolbar');
?>
    <?php if($this->Acl->check(['action'=>'index']) == true):?>
        <a href="<?=$this->Url->build(['action'=>'index']);?>" class="btn btn-warning">
            <i class="la la-angle-double-left"></i> Kembali
        </a>
    <?php endif;?>
<?php
    $this->end();
?>
<div class="row">
    <div class="col-md-12">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						<?=$titlesubModule;?>
					</h3>
				</div>
			</div>
			<!--begin::Form-->
			<?= $this->Form->create($record,['class'=>'kt-form','type'=>'file']) ?>
				<div class="kt-portlet__body">
                    <table class="table k-table table-bordered">
                        <thead>
                            <tr>
                                <th width="30px"><input type="checkbox" id="allCheck"></th>
                                <th>Module Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($acos as $key => $aco):?>
                                <tr class="table-active">
                                    <td>
                                        <?=$this->Form->checkbox('aco_parent_id.'.$aco->alias,[
                                            'checked' => ($aco->read  == 1 ? true:false),
                                            'value' => 1,
                                            'class' => 'checkParent',
                                            'data-id' => $aco->id,
                                        ]);?>
                                    </td>
                                    <td><?=empty($aco->name) ? $aco->alias : $aco->name;?></td>
                                </tr>
                                <?php foreach($aco->children as $ckey => $child):?>
                                    <tr class="">
                                        <td>
                                            <?=$this->Form->checkbox('aco_id.'.$aco->alias.'.'.$child->alias,[
                                                'checked' => ($child->read  == 1 ? true:false),
                                                'value' => 1,
                                                'class' => 'checkChild',
                                                'data-parent' => $aco->id,
                                            ]);?>
                                        </td>
                                        <td><?=empty($child->name) ? $child->alias : $child->name;?></td>
                                    </tr>
                                <?php endforeach;?>
                            <?php endforeach;?>
                        </tbody>
                    </table>
	            </div>
	            <div class="kt-portlet__foot">
					<div class="kt-form__actions">
						<div class="row">
							<div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
								<button type="reset" class="btn btn-warning">Reset</button>
							</div>
						</div>
					</div>
				</div>
			<?=$this->Form->end();?>
			<!--end::Form-->
		</div>
    </div>
</div>


<?php $this->start('script');?>
    <script>
        $("#allCheck").on("click",function(e){
            if($(this).prop("checked")){
                $("input[type=\"checkbox\"]").prop("checked",true);
            }else{
                $("input[type=\"checkbox\"]").prop("checked",false);
            }
        })
        $(".checkParent").on("click",function(e){
            if($(this).prop("checked")){
                $("input[data-parent=\""+$(this).data("id")+"\"]").prop("checked",true);
            }else{
                $("input[data-parent=\""+$(this).data("id")+"\"]").prop("checked",false);
            }
        })
        $(".checkChild").on("click",function(e){
            var thisParentVal = $(this).data("parent");
            if($(this).prop("checked")){
                $("input[data-id=\""+thisParentVal+"\"]").prop("checked",true);
            }else{
                var countCheck = $("input[data-parent=\""+thisParentVal+"\"]:checked").length;
                if(countCheck == 0){
                    $("input[data-id=\""+thisParentVal+"\"]").prop("checked",false);
                }
                //$("input[data-parent=\""+$(this).val()+"\"]").prop("checked",false);
            }
        })
    </script>
<?php $this->end();?>