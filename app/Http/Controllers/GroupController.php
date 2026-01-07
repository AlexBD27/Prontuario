<?php

namespace App\Http\Controllers;

use App\Http\Requests\group\CreateGroupRequest;
use App\Http\Requests\group\EditGroupRequest;
use App\Models\AreaGroupType;
use App\Models\Group;
use App\Repositories\AreaRepository;
use App\Repositories\GroupRepository;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    protected AreaRepository $areaRepository;
    protected GroupRepository $groupRepository;
    

    public function __construct(AreaRepository $areaRepository, GroupRepository $groupRepository){
        $this->areaRepository = $areaRepository;
        $this->groupRepository = $groupRepository;
    }
    
    public function index(Request $request)
{
        $query = Group::query();

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('area')) {
            $query->whereHas('area', function($q) use ($request) {
                $q->where('description', $request->area);
            });
        }

        if ($request->filled('is_active')) {
            $query->where('active', $request->is_active);
        }

        $groups = $query->get();        
        $areas = $this->areaRepository->getAll();

    return view('subareas.index-subarea', compact(['groups', 'areas']));
}

    public function create(): void
    {
        //
    }

    public function store(CreateGroupRequest $request)
    {
        $areaGroupType = AreaGroupType::where('area_id', $request->area_id)
                                    ->where('group_type_id', $request->group_type_id)
                                    ->first();

        if (!$areaGroupType) {
            return back()->with('error', 'No se encontró la relación de área y tipo de grupo.');
        }

        $group = new Group();
        $group->area_group_type_id = $areaGroupType->id;
        $group->abbreviation = $request->abbreviation;
        $group->description = $request->group_name;
        $group->active = true;
        $group->save();

        return back()->with('success', 'Grupo añadido exitosamente.');
    }

    public function show(int $id)
    {
        //
    }

    public function edit(int $id)
    {
        $group = $this->groupRepository->getById($id);

        if (!$group) {
            return redirect()->route('group')->with('error', 'El grupo no existe.');
        }

        return view('groups.edit-group', compact('group'));
    }

    public function update(EditGroupRequest $request, int $id)
    {   
        $group = $this->groupRepository->getById($id);
        if($group){
            $group->update([
                'abbreviation' => $request->input('abbreviation'),
                'description' => $request->input('description'),
                'active' => $request->has('active') ? 1 : 0
            ]);
            return redirect()->route('area.groups', $group->area->id)->with('success', 'Grupo actualizado exitosamente.');
        }    
    }

    public function destroy($id)
    {
        $group = $this->groupRepository->getById($id);

        if ($group->subgroups()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el grupo porque tiene subgrupos asociados.');
        }

        $group->delete();
        return back()->with('success', 'Grupo eliminado exitosamente.');
    }


}
