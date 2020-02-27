<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @link https://book.cakephp.org/3.0/en/views.html#the-app-view
 */
class AppView extends View
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadHelper('Acl');
        $this->loadHelper('Utilities');
        $this->loadHelper('Form', [
            'templates' => 'app_form_admin',
        ]);
        // $myTemplates = [
        //     'inputContainerError' => '<div class="form-group m-form__group row has-danger">{{content}}{{error}}</div>',
        //     'inputContainer' => '<div class="form-group m-form__group row">{{content}}</div>',
        //     'input' => '<input type="{{type}}" name="{{name}}" {{attrs}}/>',
        //     'formGroup' => '{{label}}<div class="{{colsize}}">{{input}}{{helper}}</div>',
        //     'label' => '<label{{attrs}}>{{text}}</label>',
        //     'error' => '<div class="form-control-feedback">{{content}}</div>',
        //     'select' => '<select name="{{name}}" {{attrs}}>{{content}}</select>',
        //     'file' => '<div class="custom-file"><input type="file" name="{{name}}" class="custom-file-input" {{attrs}}><label class="custom-file-label">Choose File</label></div>',
        // ];
        // $this->Form->templates($myTemplates);
    }
}
