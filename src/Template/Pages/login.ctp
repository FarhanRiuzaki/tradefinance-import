<div class="kt-login__signin">
    <div class="kt-login__head">
        <h3 class="kt-login__title">Masuk Pengelola <?=$defaultAppSettings['App.Name'];?><?=(!empty($titleModule) ? ' | '.$titleModule : '');?></h3>
    </div>
    <div class="kt-login__form">
        <?=$this->Flash->render();?>
        <?=$this->Form->create(null,['class'=>'kt-form']);?>
            <?php
                $this->Form->setTemplates([
                    'input' => '<input type="{{type}}" name="{{name}}" {{attrs}}/>',
                    'formGroup' => '{{label}}{{input}}',
                    'inputContainer' => '<div class="form-group">{{content}}</div>',
                ]);
            ?>
            <?=$this->Form->controls([
                'username' => ['label'=>false,'autocomplete'=>'off','placeholder'=>'Username','class'=>'form-control'],
            ],[
                'legend'=>false,
                'fieldset' => false
            ]);?>
            <?php
                $this->Form->setTemplates([
                    'input' => '<input type="{{type}}" name="{{name}}" {{attrs}}/>',
                    'formGroup' => '{{label}}{{input}}',
                    'inputContainer' => '<div class="form-group">{{content}}</div>',
                ]);
            ?>
            <?=$this->Form->controls([
                'password' => ['label'=>false,'autocomplete'=>'off','placeholder'=>'Password','class'=>'form-control form-control-last'],
            ],[
                'legend'=>false,
                'fieldset' => false
            ]);?>
            <div class="kt-login__extra">
                <label class="kt-checkbox">
                    <?=$this->Form->checkbox('remember', ['value' => 1]);?> INGAT SAYA
                    <span></span>
                </label>
            </div>
            <div class="kt-login__actions">
                <button id="kt_login_signin_submit" class="btn btn-brand btn-pill btn-elevate">MASUK</button>
            </div>
        <?=$this->Form->end();?>
    </div>
</div>
