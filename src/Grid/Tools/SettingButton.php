<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 2019-03-06
 * Time: 15:36
 */

namespace Touge\AdminOverwrite\Grid\Tools;


use Encore\Admin\Grid\Tools\AbstractTool;
use Encore\Admin\Admin;

class SettingButton extends AbstractTool
{
    /**
     * Script for this tool.
     *
     * @return string
     */
    protected function script()
    {
        $message = trans('admin.refresh_succeeded');

        return <<<EOT

$('.grid-refresh').on('click', function() {
    $.pjax.reload('#pjax-container');
    toastr.success('{$message}');
});

EOT;
    }

    /**
     * Render refresh button of grid.
     *
     * @return string
     */
    public function render()
    {
        Admin::script($this->script());

        $setting = trans('admin.setting');

        return <<<EOT
        
<div class="pull-right">
<a href="{$this->grid->resource()}/setting" class="btn btn-sm btn-success grid-setting" title="$setting"><i class="fa fa-gear"></i><span class="hidden-xs"> $setting</span></a>
</div>
EOT;
    }
}