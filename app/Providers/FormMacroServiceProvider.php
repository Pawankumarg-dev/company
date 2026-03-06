<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;
use Input;
class FormMacroServiceProvider extends ServiceProvider {

    public function boot()
    {
        // Form (Create/Edit) 
    	Form::component('bsText', 'components.form.text', ['name', 'label'=>null, 'value' =>null , 'attributes'=> []]);
    	Form::component('bsPassword', 'components.form.text', ['name', 'label'=>null, 'value' =>null , 'attributes'=> []]);
    	Form::component('bsEmail', 'components.form.email', ['name', 'label'=>null, 'value' =>null , 'attributes'=> []]);
		Form::component('bsTextarea', 'components.form.textarea', ['name', 'label'=>null, 'value' =>null , 'attributes'=> []]);
    	Form::component('bsNumber', 'components.form.number', ['name', 'label'=>null, 'min','max','value'=>null]);		
    	Form::component('bsDate', 'components.form.date', ['name', 'label'=>null, 'value' =>null , 'attributes'=> []]);
        Form::component('bsDateTime', 'components.form.datetime', ['name', 'label'=>null, 'value' =>null , 'attributes'=> []]);
    	Form::component('bsSelect', 'components.form.select', ['field', 'lists', 'dtext', 'label'=>null, 'extra'=>null, 'value' => null]);	
    	Form::component('bsCheckbox', 'components.form.checkbox', ['field', 'lists', 'dtext', 'label'=>null, 'extra'=>null, 'value' => null]);	
    	Form::component('bsRadio', 'components.form.radio', ['field', 'lists', 'dtext', 'label'=>null, 'extra'=>null, 'value' => null]);	
		Form::component('bsFile', 'components.form.file', ['name', 'label'=>null, 'image' =>null , 'value'=> null, 'path' => null,'uploadpath' => 'fileupload']);
		Form::component('bsFile3', 'components.form.fileins', ['name', 'label'=>null, 'image' =>null , 'value'=> null, 'path' => null,'uploadpath' => 'fileupload']);
		Form::component('bsFiledirect', 'components.form.fileinsdirect', ['name', 'label'=>null, 'image' =>null , 'value'=> null, 'path' => null,'cid'=>null]);
		Form::component('bsFilewithdesc', 'components.form.filewithdesc', ['i']);
		Form::component('bsSelectandText', 'components.form.selectandtext', ['field', 'lists', 'dtext','choose', 'name','label'=>null,'attributes'=> [],'value'=>null,'extra'=>null,'optionvalue'=>null ]);

        // Editable Table

        Form::component('tbText','components.table.text',['field','collection']);
        Form::component('tbSelect','components.table.select',['dropdown','field','collection']);
        Form::component('tbEdit','components.table.edit',['link','collection']);
        Form::component('tbEditDelete','components.table.editanddelete',['link','collection']);
        Form::component('tbEditscript','components.table.editscript',['field','link','type']);
        Form::component('tbHeading','components.table.dropdown_heading',['heading','code','collection','display'=>null,'displayto'=>null]);
	}

   
    public function register()
    {
        //
    }

}
	
    	