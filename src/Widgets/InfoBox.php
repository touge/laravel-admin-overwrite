<?php

namespace Touge\AdminOverwrite\Widgets;


class InfoBox extends \Encore\Admin\Widgets\InfoBox
{
    /**
     * @var string
     */
    protected $view = 'admin::custom.widgets.info-box';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * InfoBox constructor.
     *
     * @param array $params
     *  color:aqua,green,yellow,red
     *
     */
    public function __construct(Array $params)
    {
        $options = array_merge([
            'name'=>'name',
            'icon'=>'icon',
            'color'=>'color',
            'link'=>'link',
            'info'=>'info'
        ],$params);

//        parent::__construct($options['name'],$options['icon'],$options['link'],$options['info'],$options['color']);

        $this->data = [
            'name' => $options['name'],
            'icon' => $options['icon'],
            'link' => $options['link'],
            'info' => $options['info'],
        ];

        $this->class("small-box bg-{$options['color']}");
    }
}
