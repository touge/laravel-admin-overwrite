<?php

namespace Touge\AdminOverwrite\Grid\Displayers\Actions;


/**
 *  查看详情，用于课程，或者其它通过详情页面展示列表的地方
 *
 * Class Details
 * @package Touge\AdminOverwrite\Grid\Displayers\Actions
 */
class Details
{
    protected $name = '详情';
    protected $resource_url;

    /**
     * Details constructor.
     * @param string $resource_url
     */
    public function __construct($resource_url='')
    {
        $this->resource_url = $resource_url;
    }

    protected function render()
    {
        $view = trans('admin.view');
        return <<<EOT
<a href="{$this->resource_url}" class="btn btn-warning btn-details">
    <i class="fa fa-info-circle"></i> $this->name
</a>
EOT;
    }

    public function __toString()
    {
        return $this->render();
    }

}
