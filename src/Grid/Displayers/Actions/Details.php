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

    protected $params= [
        'name'=> '详情',
        'url'=> '#',
        'icon'=> 'fa-info-circle', //fa
        'style'=> 'warning',
    ];

    /**
     * Details constructor.
     * @param array $params [name,url,icon]
     */
    public function __construct(Array $params= [])
    {
        $this->params = array_merge($this->params, $params);
    }

    protected function render()
    {
        $view = $this->params['name'];
        return <<<EOT
<a href="{$this->params['url']}" class="btn btn-{$this->params['style']} btn-details">
    <i class="fa {$this->params['icon']}"></i> $view
</a>
EOT;
    }

    public function __toString()
    {
        return $this->render();
    }

}
