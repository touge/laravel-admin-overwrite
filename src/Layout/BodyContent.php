<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 2019-02-26
 * Time: 09:18
 */

namespace Touge\AdminOverwrite\Layout;

use Encore\Admin\Layout\Content as EncoreContent;

class BodyContent extends EncoreContent
{
    public function render()
    {
        $items = [
            'content'     => $this->build(),
        ];
        return view('admin::custom.content', $items)->render();
    }
}