<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 2019-03-06
 * Time: 15:36
 */

namespace Touge\AdminOverwrite\Grid\Displayers\Actions;


class CustomActionButton
{

    protected $options = [];
    public function __construct(Array $params=[])
    {
        $this->options = array_merge([
            'class'=> 'btn-success grid-setting',
            'icon'=> 'fa-user',
            'title'=> trans('admin.refresh'),
            'url'=> admin_url(''),
            'id'=> 0,
        ],$params);
    }


    /**
     * Render refresh button of grid.
     *
     * @return string
     */
    public function render()
    {
//        dd($this->options);
        return <<<EOT
<a href="{$this->options['url']}" data-id="{$this->options['id']}" class="btn {$this->options['class']}" title="{$this->options['title']}">
    <i class="fa {$this->options['icon']}"></i>
    <span class="hidden-xs"> {$this->options['title']}</span>
</a>
EOT;
    }
}