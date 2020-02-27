<?php
    $this->start('sub_header_toolbar');
?>
    <?php if($this->Acl->check(['action'=>'index']) == true):?>
        <a href="<?=$this->Url->build(['action'=>'index']);?>" class="btn btn-warning">
            <i class="la la-angle-double-left"></i> Kembali
        </a>
    <?php endif;?>
    <?php if($this->Acl->check(['action'=>'add']) == true):?>
        <a href="<?=$this->Url->build(['action'=>'add']);?>" class="btn btn-primary">
            <i class="la la-plus-circle"></i> Tambah Data
        </a>
    <?php endif;?>
    <?php if($this->Acl->check(['action'=>'edit']) == true):?>
        <a href="<?=$this->Url->build(['action'=>'edit',$record->id]);?>" class="btn btn-success">
            <i class="la la-edit"></i> Edit Data
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
            <div class="kt-portlet__body">
                <table class="table table-striped table-bordered table-hover table-checkable">
                    <tr>
                        <th scope="row" width="20%"><?= __('Username') ?></th>
                        <td><?= h($record->username) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Password') ?></th>
                        <td><?= h($record->password) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($record->name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Email') ?></th>
                        <td><?= h($record->email) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('User Group') ?></th>
                        <td><?= $record->has('user_group') ? $this->Html->link($record->user_group->name, ['controller' => 'UserGroups', 'action' => 'view', $record->user_group->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($record->created) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($record->modified) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $this->Utilities->statusLabel($record->status); ?></td>
                    </tr>
                </table>
            </div>
		</div>
    </div>
</div>