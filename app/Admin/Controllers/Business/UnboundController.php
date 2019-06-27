<?php

namespace App\Admin\Controllers\Business;

use App\Admin\Models\Business\CustomerModel;
use App\Admin\Models\Hr\DepartmentModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Widgets\Table;

class UnboundController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('客户信息')
            ->description('客户未绑定业务员')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('客户详情')
            ->description('客户信息详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CustomerModel);
        $grid->disableFilter();
        

        $grid->model()->where('salesman_id','=',Null)->orwhere('salesman_id','=',0);
        $grid->id('序号');
        $grid->name('用户名');
        $grid->email('邮箱');
        $grid->nickname('昵称');
        $grid->money('余额');
        $grid->salesman_id('业务员')->display(function(){
            $salesman_id = [
                Null=>'佚名',
                0=>'佚名'
            ];
            return $salesman_id[$this->salesman_id];
        });
        $grid->column('status','状态')->display(function(){
            $status = [
                0=>'<span class="badge bg-red">拉黑</span>',
                1=>'<span class="badge bg-yellow">未验证</span>',
                2=>'<span class="badge bg-green">正常</span>'
            ];
            return $status[$this->status];
        });
        $grid->msg_phone('联系方式');
        $grid->msg_qq('QQ');
        $grid->remarks('备注');
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();

        });  
        $grid->disableCreateButton();
        $grid->disableRowSelector();
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('name', '用户名');
            $filter->like('email', '邮箱');
            $filter->like('nickname', '昵称');
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(CustomerModel::findOrFail($id));

        $show->id('序号');
        $show->name('用户名');
        $show->email('邮箱');
        $show->nickname('昵称');
        $show->money('余额');
        $show->salesman_id('业务员')->as(function($salesman_id){
            $salesman = [Null=>'佚名', 0=>'佚名'];
            return $salesman[$salesman_id];
        });
        $show->status('状态')->using([0=>'拉黑',1=>'未验证',2=>'正常']);
        $show->msg_phone('联系方式');
        $show->msg_qq('QQ');
        $show->remarks('备注');
        $show->created_at('创建时间');
        $show->updated_at('更新时间');
        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
            $tools->disableDelete();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CustomerModel);

        $form->switch('status', 'Status')->default(1);
        $form->text('name', 'Name');
        $form->email('email', 'Email');
        $form->password('password', 'Password');
        $form->text('remember_token', 'Remember token');
        $form->decimal('money', 'Money')->default(0.00);
        $form->number('salesman_id', 'Salesman id');
        $form->text('nickname', 'Nickname');
        $form->switch('pwd_ver', 'Pwd ver');
        $form->text('msg_phone', 'Msg phone');
        $form->text('msg_qq', 'Msg qq');
        $form->text('remarks', 'Remarks');

        return $form;
    }
}
