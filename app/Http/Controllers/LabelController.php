<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::orderBy('id', 'asc')->get();
        $labelModel = new Label();
        return view('labels.index', compact('labels', 'labelModel'));
    }

    public function create()
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized action');
        }

        $label = new Label();
        return view('labels.create', compact('label'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:labels',
            'description' => 'nullable',
        ]);

        $label = new Label();
        $label->fill($data);
        $label->save();

        Session::flash('flash_message', __('app.flash.label.created'));

        return redirect()->route('labels.index');
    }

    public function show(Label $label)
    {
        //
    }

    public function edit(Label $label)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized action');
        }

        return view('labels.edit', compact('label'));
    }

    public function update(Request $request, Label $label)
    {
        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('labels')->ignore($label),
            ],
            'description' => 'nullable',
        ]);

        $label->update($data);

        Session::flash('flash_message', __('app.flash.label.updated'));

        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            Session::flash('flash_message_error', __('app.flash.label.deleteFailed'));
            return redirect()->route('labels.index');
        }

        $label->delete();

        Session::flash('flash_message', __('app.flash.label.deleted'));

        return redirect()->route('labels.index');
    }
}
