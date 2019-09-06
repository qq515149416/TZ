<?php

namespace App\Admin\Controllers\Business;

use Encore\Admin\Admin;

class DelInvoice
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;

    }

    protected function script()
    {
        return <<<SCRIPT

$('.grid-check-row').on('click', function () {
    if(confirm( '是否删除？ '))  location.href='delete?invoice_id='+$(this).data('id');
    // Your code.
    //console.log($(this).data('id'));
    //alert('666');
    //  $.ajax({
    //     type : "POST",
    //     url : "../api/drawMoney/check",
    //     dataType : "json",
    //     data : {
    //         'draw_money_id':$(this).data('id'),
    //         'type':'check'
    //     },
    //     success : function(test) {
    //         window.location.reload();
    //     },
    // });
});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());
      
        return "<a  class='fa fa-trash grid-check-row' data-id='{$this->id}'></a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}