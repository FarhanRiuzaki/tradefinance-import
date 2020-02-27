<?php
    $this->start('sub_header_toolbar');
?>
    <?php if($this->Acl->check(['action'=>'index']) == true):?>
        <a href="<?=$this->Url->build(['controller'=> 'Dashboard','action'=>'index']);?>" class="btn btn-warning">
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
			<?= $this->Form->create($dataSave,['class'=>'kt-form','type'=>'file']) ?>
				<div class="kt-portlet__body">
					<div class="kt-section kt-section--first">
                    <?=$this->Form->control('App_Name',[
                        'class'=>'form-control m-input',
                        'templateVars' => [
                            'colsize' => 'col-lg-4 col-xl-4',
                        ],
                        'value'=>$appSettings['App_Name']['valueField'],
                        'label' => [
                            'class'=> 'col-lg-3 col-xl-2 col-form-label',
                            'text'=>'Nama Aplikasi *'
                        ],
                        'placeholder' => 'Masukan nama aplikasi'
                    ]);;?>
                    <?=$this->Form->control('App_Description',[
                        'class'=>'form-control m-input',
                        'type'=>'textarea',
                        'value'=>$appSettings['App_Description']['valueField'],
                        'templateVars' => [
                            'colsize' => 'col-lg-4 col-xl-4',
                        ],
                        'label' => [
                            'class'=> 'col-lg-3 col-xl-2 col-form-label',
                            'text'=>'Deskripsi Aplikasi *'
                        ],
                        'placeholder' => 'Masukan deskripsi aplikasi'
                    ]);;?>
                <?=$this->Form->control('App_Logo',[
                    'type'=>'file',
                    'class'=>'form-control m-input',
                    'templateVars' => [
                        'colsize' => 'col-lg-4 col-xl-4',
                    ],
                    'label' => [
                        'class'=> 'col-lg-3 col-xl-2 col-form-label',
                        'text'=>'Logo Header *'
                    ],
                    'placeholder' => 'Pilih logo untuk header'
                ]);;?>
                <?=$this->Form->control('App_Logo_Login',[
                    'type'=>'file',
                    'class'=>'form-control m-input',
                    'templateVars' => [
                        'colsize' => 'col-lg-4 col-xl-4',
                    ],
                    'label' => [
                        'class'=> 'col-lg-3 col-xl-2 col-form-label',
                        'text'=>'Logo Login *'
                    ],
                    'placeholder' => 'Pilih logo untuk login'
                ]);;?>
                <?=$this->Form->control('App_Favico',[
                    'type'=>'file',
                    'class'=>'form-control m-input',
                    'templateVars' => [
                        'colsize' => 'col-lg-4 col-xl-4',
                    ],
                    'label' => [
                        'class'=> 'col-lg-3 col-xl-2 col-form-label',
                        'text'=>'Logo Icon *'
                    ],
                    'placeholder' => 'Pilih logo icon'
                ]);;?>
		            </div>
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