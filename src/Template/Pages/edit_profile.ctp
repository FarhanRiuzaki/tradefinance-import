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
            <?php unset($user->password);?>
            <?= $this->Form->create($user,['class'=>'m-form']) ?>
                <div class="kt-portlet__body">
                    <div class="kt-form__section m-form__section--first">
                    <?php
                            echo $this->Form->control('username',[
                                'class'=>'form-control m-input',
                                'templateVars' => [
                                    'colsize' => 'col-lg-4 col-xl-3',
                                ],
                                'label' => [
                                    'class'=> 'col-lg-3 col-xl-2 col-form-label',
                                    'text'=>'Username *'
                                ],
                            ]);
                            echo $this->Form->control('password',[
                                'class'=>'form-control m-input',
                                'templateVars' => [
                                    'colsize' => 'col-lg-4 col-xl-3',
                                    'helper' => '<span class="kt-form__help">Kosongkan password jika tidak diubah</span>',
                                ],
                                'label' => [
                                    'class'=> 'col-lg-3 col-xl-2 col-form-label',
                                    'text'=>'Password *'
                                ],
                            ]);
                            echo $this->Form->control('name',[
                                'class'=>'form-control m-input',
                                'templateVars' => [
                                    'colsize' => 'col-lg-4 col-xl-3',
                                ],
                                'label' => [
                                    'class'=> 'col-lg-3 col-xl-2 col-form-label',
                                    'text'=>'Nama User *'
                                ],
                            ]);
                            echo $this->Form->control('email',[
                                'class'=>'form-control m-input',
                                'templateVars' => [
                                    'colsize' => 'col-lg-4 col-xl-3',
                                ],
                                'label' => [
                                    'class'=> 'col-lg-3 col-xl-2 col-form-label',
                                    'text'=>'Email User *'
                                ],
                            ]);
                            echo $this->Form->control('user_group_id',[
                                'class'=>'form-control m-input',
                                'templateVars' => [
                                    'colsize' => 'col-lg-4 col-xl-3',
                                ],
                                'label' => [
                                    'class'=> 'col-lg-3 col-xl-2 col-form-label',
                                    'text'=>'Group User *'
                                ],
                                'options' => $userGroups,
                                'empty' => 'Pilih group user'
                            ]);
                        ?>
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
            <?= $this->Form->end();?>
            <!--end::Form-->
        </div>
    </div>
</div>