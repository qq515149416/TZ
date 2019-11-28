<?php
use App\Admin\Extensions\WangEditor;
use Encore\Admin\Form;
/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Form::forget(['map', 'editor']);
Form::extend('editor', WangEditor::class);

app('view')->prependNamespace('admin', resource_path('views/admin'));
// Admin::css('/css/b.tabs.css');
Admin::css('/css/header.css');
Admin::js('/js/md5.js');
// Admin::js('/js/b.tabs.min.js');
Admin::js('/js/admin_tab.js');
