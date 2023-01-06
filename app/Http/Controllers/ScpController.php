<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScpStoreRequest;
use App\Http\Requests\ScpUpdateRequest;
use App\Models\Scp;
use Illuminate\Http\Request;

class ScpController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $scps = Scp::all();

        return view('scp.index', compact('scps'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('scp.create');
    }

    /**
     * @param \App\Http\Requests\ScpStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScpStoreRequest $request)
    {
        $scp = Scp::create($request->validated());

        $this->$request->session()->flash('scp.id', $scp->id);

        return redirect()->route('scp.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Scp $scp
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Scp $scp)
    {
        return view('scp.show', compact('scp'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Scp $scp
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Scp $scp)
    {
        return view('scp.edit', compact('scp'));
    }

    /**
     * @param \App\Http\Requests\ScpUpdateRequest $request
     * @param \App\Models\Scp $scp
     * @return \Illuminate\Http\Response
     */
    public function update(ScpUpdateRequest $request, Scp $scp)
    {
        $scp->update($request->validated());

        $this->$request->session()->flash('scp.id', $scp->id);

        return redirect()->route('scp.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Scp $scp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Scp $scp)
    {
        $scp->delete();

        return redirect()->route('scp.index');
    }
}
