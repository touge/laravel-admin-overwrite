<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 2019-03-03
 * Time: 13:49
 */

namespace Touge\AdminOverwrite;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Response;

class Form extends \Encore\Admin\Form
{
    /**
     * Store a new record.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $data = Input::all();

        // Handle validation errors.
        if ($validationMessages = $this->validationMessages($data)) {

            /**
             * 是否为ajax提交
             */
            $this->ajaxRequestFailedCheck($validationMessages);

            return back()->withInput()->withErrors($validationMessages);
        }

        if (($response = $this->prepare($data)) instanceof Response) {
            return $response;
        }

        DB::transaction(function () {
            $inserts = $this->prepareInsert($this->updates);

            foreach ($inserts as $column => $value) {
                $this->model->setAttribute($column, $value);
            }

            $this->model->save();

            $this->updateRelation($this->relations);
        });

        if (($response = $this->callSaved()) instanceof Response) {
            return $response;
        }

        if ($response = $this->ajaxResponse(trans('admin.save_succeeded'))) {
            return $response;
        }

        return $this->redirectAfterStore();
    }

    /**
     * Handle update.
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update($id, $data = null)
    {
        $data = ($data) ?: Input::all();
        $isEditable = $this->isEditable($data);
        $data = $this->handleEditable($data);
        $data = $this->handleFileDelete($data);

        if ($this->handleOrderable($id, $data)) {
            return response([
                'status'  => true,
                'message' => trans('admin.update_succeeded'),
            ]);
        }

        /* @var Model $this->model */
        $this->model = $this->model->with($this->getRelations())->findOrFail($id);

        $this->setFieldOriginalValue();

        // Handle validation errors.
        if ($validationMessages = $this->validationMessages($data)) {

            /**
             * 是否为ajax提交
             */
            $this->ajaxRequestFailedCheck($validationMessages);

            if (!$isEditable) {
                return back()->withInput()->withErrors($validationMessages);
            } else {
                return response()->json(['errors' => array_dot($validationMessages->getMessages())], 422);
            }
        }

        if (($response = $this->prepare($data)) instanceof Response) {
            return $response;
        }

        DB::transaction(function () {
            $updates = $this->prepareUpdate($this->updates);

            foreach ($updates as $column => $value) {
                /* @var Model $this->model */
                $this->model->setAttribute($column, $value);
            }

            $this->model->save();

            $this->updateRelation($this->relations);
        });

        if (($result = $this->callSaved()) instanceof Response) {
            return $result;
        }

        if ($response = $this->ajaxResponse(trans('admin.update_succeeded'))) {
            return $response;
        }

        return $this->redirectAfterUpdate($id);
    }

    /**
     * 当为ajax，且不为pjax 提交时，错误使用json抛出
     * @param $message
     */
    protected function ajaxRequestFailedCheck($message)
    {
        $request = Request::capture();

        // ajax but not pjax
        if ($request->ajax() && !$request->pjax()) {
            throw new HttpResponseException(response()->json([
                'status'  => false,
                'errors' => $message,
            ]));
        }
    }

}