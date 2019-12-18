<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 2019-03-06
 * Time: 15:36
 */

namespace Touge\AdminOverwrite\Grid\Tools;

use Encore\Admin\Admin;

class CustomToolButton
{

    protected $options = [];
    public function __construct(Array $params=[])
    {
        $this->options = array_merge([
            'class'=> 'btn-success grid-setting pull-left',
            'icon'=> 'fa-user',
            'title'=> trans('admin.refresh'),
            'id'=> 0,
        ],$params);
    }

    public function refresh_script($element){
        $script = <<<EOF
$("{$element}").on('click', function(e) {
    e.preventDefault()
    $.pjax.reload('#pjax-container');
    toastr.success('刷新成功 !');
});
EOF;
        Admin::script($script);
        return $this;
    }

    /**
     * Render refresh button of grid.
     *
     * @return string
     */
    public function render()
    {
        return <<<EOT

<a data-id="{$this->options['id']}" class="btn btn-sm {$this->options['class']}" title="{$this->options['title']}" style="margin: 0 3px;">
    <i class="fa {$this->options['icon']}"></i>
    <span class="hidden-xs"> {$this->options['title']}</span>
</a>
EOT;
    }
}