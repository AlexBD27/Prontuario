<?php

namespace App\Http\Controllers;

use App\Http\Requests\subgroup\CreateSubgroupRequest;
use App\Http\Requests\subgroup\EditSubgroupRequest;
use App\Models\Subgroup;
use App\Repositories\SubgroupRepository;

class SubgroupController extends Controller
{

    protected SubgroupRepository  $subgroupRepository;

    public function __construct(SubgroupRepository $subgroupRepository)
    {
        $this->subgroupRepository = $subgroupRepository;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(CreateSubgroupRequest $request)
    {
        $subgroup = new Subgroup();
        $subgroup->group_id = $request->group_id;
        $subgroup->abbreviation = $request->subgroup_abbreviation;
        $subgroup->description = $request->subgroup_name;
        $subgroup->active = true;
        $subgroup->save();

        return back()->with('success', 'Subgrupo añadido exitosamente.');
    }

    public function show(int $id)
    {
        //
    }

   
    public function edit(int $id)
    {
        $subgroup = $this->subgroupRepository->getById($id);

        if (!$subgroup) {
            return redirect()->route('subgroup')->with('error', 'El subgrupo no existe.');
        }

        return view('subgroups.edit-subgroup', compact('subgroup'));
    }

    public function update(EditSubgroupRequest $request, int $id)
    {    
        $subgroup = $this->subgroupRepository->getById($id);
        if($subgroup){
            $subgroup->update([
                'abbreviation' => $request->input('abbreviation'),
                'description' => $request->input('description'),
                'active' => $request->has('active') ? 1 : 0
            ]);
            return redirect()->route('area.groups', $subgroup->group->area->id)->with('success', 'Subgrupo actualizado exitosamente.');
        }    
    }

    public function destroy($id)
    {
        $subgroup = $this->subgroupRepository->getById($id);

        $subgroup->delete();

        return back()->with('success', 'Subgrupo eliminado exitosamente.');
    }

}
