<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait WithStatus
{
    public function inactiveMultiple(Request $request)
    {
        if (!$request->has('strIds') || empty($request->strIds)) {
            session()->flash('error', 'You did not select any data.');
            return response()->json(['error' => 1]);
        }

        $this->model::whereIn('id', $request->strIds)->get()->each(function ($model) {
            $model->status = ($model->status == 0) ? 1 : 0;
            $model->save();
        });

        session()->flash('success', basename(get_class($this->model)).' status changed successfully');

        return response()->json(['success' => 1]);
    }
}
