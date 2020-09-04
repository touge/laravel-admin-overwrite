<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 2019-03-05
 * Time: 17:36
 */

namespace Touge\AdminOverwrite\Grid\Tools;


use Touge\AdminOverwrite\Grid\Grid;

class CreateButton extends \Encore\Admin\Grid\Tools\CreateButton
{
    /**
     * @var Grid
     */
    protected $grid;

    /**
     * Create a new CreateButton instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    /**
     * Render CreateButton.
     *
     * @return string
     */
    public function render()
    {
        if (!$this->grid->showCreateBtn()) {
            return '';
        }

        $new = trans('admin.new');

        return <<<EOT

<div class="btn-group pull-right grid-create-btn" style="margin-right: 10px">
    <a href="{$this->grid->getCreateUrl()}" class="btn btn-sm btn-success btn-create" title="{$new}">
        <i class="fa fa-plus"></i><span class="hidden-xs">&nbsp;&nbsp;{$new}</span>
    </a>
</div>

EOT;
    }
}