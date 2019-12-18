<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 2019-03-05
 * Time: 16:44
 */

namespace Touge\AdminOverwrite\Widgets;


use Encore\Admin\Admin;

class Tab extends \Encore\Admin\Widgets\Tab
{
    protected $view = 'admin::custom.widgets.tab';

    public function add_ajax(Array $params=[])
    {
        $options = array_merge([
            'id'=> mt_rand(),
            'url'=> '',
            'title'=>'Tab title',
            'content'=> '',
            'active'=>false
        ],$params);

        $this->data['tabs'][] = [
            'id' => $options['id'],
            'url' => admin_url($options['url']),
            'title' => $options['title'],
            'content' => $options['content'],
        ];

        if ($options['active']) {
            $this->data['active'] = count($this->data['tabs']) - 1;
        }

        $script = <<<EOF

function show_tab(element) {
    var url = element.data('url')
    if(!url) return false
    var append_element = $(".tab-content" + " div" + element.attr('href'))
    $.ajax({
        url: url,
        dataType: "html",
        success: function (response) {
            $(append_element).empty().html(response)
            $("a[href='" + element.attr('href') + "']").tab('show');
        }
    })
}

var hash = document.location.hash ,tab_element;
if (hash) {
    tab_element = $('.nav-tabs a[href="' + hash + '"]')//.attr('href').replace("#", '')
}else{
    tab_element = $('.nav-tabs a:first')
    history.pushState(null, null, $(tab_element).attr('href'));
}

show_tab(tab_element)

$("ul.nav.nav-tabs>li>a").off('click').on('click',function(e){
    e.preventDefault();    
    if ($(this).parent('li').hasClass('active') === false) {
        history.pushState(null, null, e.target.hash);               
    }
    show_tab($(this))
})
EOF;

        Admin::script($script);
        return $this;
    }
}