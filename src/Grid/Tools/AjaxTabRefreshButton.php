<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 2019-03-05
 * Time: 17:22
 */

namespace Touge\AdminOverwrite\Grid\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;

/**
 * tab局部刷新
 *
 * Class TabRefreshButton
 * @package App\Admin\Development\Grid\Tools
 */
class AjaxTabRefreshButton extends AbstractTool
{
    protected $refresh_url;

    public function __construct($refresh_url = '')
    {
        $this->refresh_url = $refresh_url;
        return $this;
    }

    public function setResource($url){
        $this->refresh_url = $url;
        return $this;
    }
    /**
     * Script for this tool.
     *
     * @return string
     */
    protected function script()
    {
        $message = trans('admin.refresh_succeeded');

        return <<<EOT

$('.grid-refresh').on('click', function(e) {
    e.preventDefault()
    var action_url = $(this).attr('href')
    var container_element = $(this).parents('div.box').parent()
    
    $.ajax({
        url: action_url,
        success: function(response){
            $("div#tab_courses").empty().append(response)
            toastr.success('{$message}');
        }
    })
    
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

        $refresh_url = $this->refresh_url;

        $refresh = trans('admin.refresh');
//<a href="{$this->getResource()}/{$this->getKey()}" class="btn btn-info btn-view">
        return <<<EOT
<a class="btn btn-sm btn-primary grid-refresh" href="{$refresh_url}" title="$refresh"><i class="fa fa-refresh"></i><span class="hidden-xs"> $refresh</span></a>
EOT;
    }
}