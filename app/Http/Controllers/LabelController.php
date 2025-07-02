<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelStoreRequest;
use App\Http\Requests\LabelUpdateRequest;
use App\Models\Label;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;

class LabelController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $labels = Label::orderBy('id', 'asc')->get();
        $labelModel = new Label();
        return view('labels.index', compact('labels', 'labelModel'));
    }

    public function create()
    {
        $this->authorize('create', Label::class);

        $label = new Label();
        return view('labels.create', compact('label'));
    }

    public function store(LabelStoreRequest $request)
    {
        $data = $request->validated();

        $label = new Label();
        $label->fill($data);
        $label->save();

        Session::flash('success', __('app.flash.label.created'));

        return redirect()->route('labels.index');
    }

    public function show(Label $label)
    {
        $this->authorize('view', $label);
    }

    public function edit(Label $label)
    {
        $this->authorize('update', $label);

        return view('labels.edit', compact('label'));
    }

    public function update(LabelUpdateRequest $request, Label $label)
    {
        $data = $request->validated();

        $label->update($data);

        Session::flash('success', __('app.flash.label.updated'));

        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        $this->authorize('delete', $label);

        if ($label->tasks()->exists()) {
            Session::flash('error', __('app.flash.label.deleteFailed'));
            return redirect()->route('labels.index');
        }

        $label->delete();

        Session::flash('success', __('app.flash.label.deleted'));

        return redirect()->route('labels.index');
    }
}
