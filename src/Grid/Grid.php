<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 2019-11-20
 * Time: 13:40
 */

namespace Touge\AdminOverwrite\Grid;

use Touge\AdminOverwrite\Grid\Displayers\Actions;
use Touge\AdminOverwrite\Grid\Tools\CreateButton;

class Grid extends \Encore\Admin\Grid
{
    /**
     * Actions column display class.
     *
     * @var string
     */
    protected $actionsClass = Actions::class;

    /**
     * Add `actions` column for grid.
     *
     * @return void
     */
    protected function appendActionsColumn()
    {
        if (!$this->option('show_actions')) {
            return;
        }

        $this->addColumn('__actions__', trans('admin.action'))
            ->displayUsing($this->actionsClass, [$this->actionsCallback]);
    }

    /**
     * 重写 grid 中的新增表单，添加btn.create标识
     * @return string
     */
    public function renderCreateButton()
    {
        return (new CreateButton($this))->render();
    }

}