<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClasseStoreRequest;
use App\Http\Requests\ClasseUpdateRequest;
use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $classes = Classe::all();

        return view('classe.index', compact('classes'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('classe.create');
    }

    /**
     * @param \App\Http\Requests\ClasseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClasseStoreRequest $request)
    {
        $classe = Classe::create($request->validated());

        $this->$request->session()->flash('classe.id', $classe->id);

        return redirect()->route('classe.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Classe $classe
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Classe $classe)
    {
        return view('classe.show', compact('classe'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Classe $classe
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Classe $classe)
    {
        return view('classe.edit', compact('classe'));
    }

    /**
     * @param \App\Http\Requests\ClasseUpdateRequest $request
     * @param \App\Models\Classe $classe
     * @return \Illuminate\Http\Response
     */
    public function update(ClasseUpdateRequest $request, Classe $classe)
    {
        $classe->update($request->validated());

        $this->$request->session()->flash('classe.id', $classe->id);

        return redirect()->route('classe.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Classe $classe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Classe $classe)
    {
        $classe->delete();

        return redirect()->route('classe.index');
    }
}
