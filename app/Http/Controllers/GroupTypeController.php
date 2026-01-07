<?php

namespace App\Http\Controllers;

use App\Http\Requests\grouptype\AssignGroupTypeRequest;
use App\Models\AreaGroupType;
use App\Models\Group;
use App\Repositories\AreaRepository;
use App\Repositories\GroupTypeRepository;
use Illuminate\Http\Request;

class GroupTypeController extends Controller
{
    protected GroupTypeRepository $groupTypeRepository;
    protected AreaRepository $areaRepository;

    public function __construct(GroupTypeRepository $groupTypeRepository, AreaRepository $areaRepository)
    {
        $this->groupTypeRepository = $groupTypeRepository;
        $this->areaRepository = $areaRepository;
    }

    public function index()
    {
        $group_types = $this->groupTypeRepository->getAll();
        return view('grouptypes.index-grouptype', compact('group_types')); 
    }

    public function create()
    {
        return view('grouptypes.create-grouptype');
    }

    public function store(Request $request)
    {
        $this->groupTypeRepository->create($request->all());
        return redirect()->route('grouptype')->with('success','Tipo de Grupo creado exitosamente.');
    }

    public function assignGroupType(AssignGroupTypeRequest $request)
    {
        $area = $this->areaRepository->getById($request->area_id);

        if ($area->groupTypes()->where('group_type_id', $request->group_type_id)->exists()) {
            return redirect()->back()->with('error', 'Este tipo de grupo ya está asociado a esta área.');
        }

        $area->groupTypes()->attach($request->group_type_id);

        return redirect()->back()->with('success', 'Tipo de grupo asociado exitosamente.');
    }

    public function unassignGroupType(Request $request)
    {
        $areaId = $request->area_id;
        $groupTypeId = $request->group_type_id;

        $areaGroupType = AreaGroupType::where('area_id', $areaId)
            ->where('group_type_id', $groupTypeId)
            ->first();

        if (!$areaGroupType) {
            return redirect()->back()->with('error', 'El tipo de grupo no está asociado al área.');
        }

        $hasGroups = Group::where('area_group_type_id', $areaGroupType->id)->exists();

        if ($hasGroups) {
            return redirect()->back()->with('error', 'No se puede eliminar este tipo de grupo porque tiene grupos asociados.');
        }

        $areaGroupType->delete();

        return redirect()->back()->with('success', 'Tipo de grupo eliminado exitosamente.');
    }



    public function show(string $id)
    {
        //
    }

    public function edit(int $id)
    {
        $group_type = $this->groupTypeRepository->getById($id);

        if (!$group_type) {
            return redirect()->route('grouptype')->with('error', 'El tipo de grupo no existe.');
        }

        return view('grouptypes.edit-grouptype', compact('group_type'));
    }

    public function update(Request $request, int $id)
    {
        $group_type = $this->groupTypeRepository->getById($id);

        if($group_type){
            $group_type->update([
                'abbreviation' => $request->input('abbreviation'),
                'description' => $request->input('description'),
                'active' => $request->has('active') ? 1 : 0
            ]);
            return redirect()->route('grouptype')->with('success', 'Tipo de Grupo actualizado exitosamente.');
        }

        return redirect()->route('grouptype')->with('error', 'Tipo de Grupo no encontrado.');
    }

    public function destroy(int $id)
    {
        $group_type = $this->groupTypeRepository->getById($id);
        if ($group_type) {
            $group_type->delete();
            return redirect()->route('grouptype')->with('success', 'Tipo de Grupo eliminado exitosamente.');
        } else {
            return redirect()->route('grouptype')->with('error', 'Tipo de Grupo no encontrado.');
        }
    }
}
