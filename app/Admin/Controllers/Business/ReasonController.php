<?php

namespace App\Admin\Controllers\Business;

use App\Admin\Models\Business\ReasonModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ReasonController extends Controller
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
            ->header('原因分类')
            ->description('下架/更换原因分类')
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
            ->header('原因分类详情')
            ->description('下架/更换原因分类详情')
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
            ->header('编辑原因分类')
            ->description('编辑下架/更换原因分类')
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
            ->header('创建原因分类')
            ->description('创建下架/更换原因分类')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ReasonModel);

        $grid->id('序号');
        $grid->reason('原因');
        $grid->note('备注');
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');

        $grid->filter(function($filter){
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                $filter->like('reason', '原因');
                $filter->like('note', '备注');
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
        $show = new Show(ReasonModel::findOrFail($id));

        $show->id('序号');
        $show->reason('原因');
        $show->note('备注');
        $show->created_at('创建时间');
        $show->updated_at('更新时间');
        

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ReasonModel);

        $form->text('reason', '原因');
        $form->text('note', '备注');

        return $form;
    }
}
