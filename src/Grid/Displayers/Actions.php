<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 2019/1/10
 * Time: 11:57 AM
 */
namespace Touge\AdminOverwrite\Grid\Displayers;

use Encore\Admin\Admin;

class Actions extends \Encore\Admin\Grid\Displayers\Actions
{

    /**
     * {@inheritdoc}
     */
    public function display($callback = null)
    {
        if ($callback instanceof \Closure) {
            $callback->call($this, $this);
        }

        $actions = $this->prepends;

        foreach ($this->actions as $action) {
            $method = 'render'.ucfirst($action);
            array_push($actions, $this->{$method}());
        }

        $actions = array_merge($actions, $this->appends);

        $_actions = "<div class='btn-group btn-group-xs'>";
        $_actions.= implode('', $actions);
        $_actions.= "</div>";
//        dd($_actions);
        return $_actions;
    }

    /**
     * ajax删除按钮
     * @return string
     */
    public function ajaxDeleteButton(){
        $deleteConfirm = trans('admin.delete_confirm');
        $confirm = trans('admin.confirm');
        $cancel = trans('admin.cancel');
        $delete = trans('admin.delete');

        $script = <<<SCRIPT

$('.{$this->grid->getGridRowName()}-delete').unbind('click').click(function() {

    var id = $(this).data('id');
    return console.log('{$this->getResource()}/' + id)
    swal({
        title: "$deleteConfirm",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "$confirm",
        showLoaderOnConfirm: true,
        cancelButtonText: "$cancel",
        preConfirm: function() {
            return new Promise(function(resolve) {
                $.ajax({
                    method: 'post',
                    url: '{$this->getResource()}/' + id,
                    data: {
                        _method:'delete',
                        _token:LA.token,
                    },
                    success: function (data) {
                        
                        return false
                        $.pjax.reload('#pjax-container');
                        resolve(data);
                    }
                });
            });
        }
    }).then(function(result) {
        var data = result.value;
        if (typeof data === 'object') {
            if (data.status) {
                swal(data.message, '', 'success');
            } else {
                swal(data.message, '', 'error');
            }
        }
    });
});

SCRIPT;

        Admin::script($script);

        return <<<EOT
<a href="javascript:void(0);" data-id="{$this->getKey()}" class="{$this->grid->getGridRowName()}-delete btn btn-danger btn-destroy">
    <i class="fa fa-trash"></i> $delete
</a>
EOT;
    }

    /**
     * Render view action.
     *
     * @return string
     */
    protected function renderView()
    {
        $view = trans('admin.view');
        return <<<EOT
<a href="{$this->getResource()}/{$this->getKey()}" class="btn btn-info btn-view">
    <i class="fa fa-eye"></i> $view
</a>
EOT;
    }

    /**
     * Render edit action.
     *
     * @return string
     */
    protected function renderEdit()
    {
        $edit = trans('admin.edit');
        return <<<EOT
<a href="{$this->getResource()}/{$this->getKey()}/edit" class="btn btn-success btn-edit">
    <i class="fa fa-edit"></i> $edit
</a>
EOT;
    }


    /**
     * Render delete action.
     *
     * @return string
     */
    protected function renderDelete()
    {
        $deleteConfirm = trans('admin.delete_confirm');
        $confirm = trans('admin.confirm');
        $cancel = trans('admin.cancel');
        $delete = trans('admin.delete');

        $script = <<<SCRIPT

$('.{$this->grid->getGridRowName()}-delete').unbind('click').click(function() {

    var id = $(this).data('id');

    swal({
        title: "$deleteConfirm",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "$confirm",
        showLoaderOnConfirm: true,
        cancelButtonText: "$cancel",
        preConfirm: function() {
            return new Promise(function(resolve) {
                $.ajax({
                    method: 'post',
                    url: '{$this->getResource()}/' + id,
                    data: {
                        _method:'delete',
                        _token:LA.token,
                    },
                    success: function (data) {
                        $.pjax.reload('#pjax-container');

                        resolve(data);
                    }
                });
            });
        }
    }).then(function(result) {
        var data = result.value;
        if (typeof data === 'object') {
            if (data.status) {
                swal(data.message, '', 'success');
            } else {
                swal(data.message, '', 'error');
            }
        }
    });
});

SCRIPT;

        Admin::script($script);

        return <<<EOT
<a href="javascript:void(0);" data-id="{$this->getKey()}" class="{$this->grid->getGridRowName()}-delete btn btn-danger btn-destroy">
    <i class="fa fa-trash"></i> $delete
</a>
EOT;
    }
}