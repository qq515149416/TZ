<?php

namespace App\Admin\Controllers\User;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
// use Encore\Admin\Form;
use Encore\Admin\Controllers\UserController;

class UserExtendController extends UserController {
    public function create(Content $content)
    {
        return $content
        ->header(trans('admin.administrator'))
        ->description(trans('admin.create'))
        ->body($this->form());
    }
    public function form()
    {
      $form = parent::form();
      return $form;
    }
}