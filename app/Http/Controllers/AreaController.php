<?php

namespace App\Http\Controllers;

use App\Http\Requests\area\CreateAreaRequest;
use App\Http\Requests\area\EditAreaRequest;
use App\Repositories\AreaRepository;
use App\Repositories\GroupTypeRepository;
use Illuminate\View\View;

class AreaController extends Controller
{

    protected AreaRepository $areaRepository;
    protected GroupTypeRepository $groupTypeRepository;

    public function __construct(AreaRepository $areaRepository, GroupTypeRepository $groupTypeRepository)
    {
        $this->areaRepository = $areaRepository;
        $this->groupTypeRepository = $groupTypeRepository;
    }
    
    public function index(): View
    {
        $areas = $this->areaRepository->getAll();
        return view('areas.index-area', compact('areas'));
    }

    public function create(): View
    {
        return view('areas.create-area');
    }

    public function store(CreateAreaRequest $request)
    {
        $this->areaRepository->create($request->all());
        return redirect()->route('area')->with('success', 'Área creada exitosamente.');
    }


    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $area = $this->areaRepository->getById($id);

        if (!$area) {
            return redirect()->route('area')->with('error', 'El área no existe.');
        }

        return view('areas.edit-area', compact('area'));
    }


    public function update(EditAreaRequest $request, $id)
    {

        $area = $this->areaRepository->getById($id);
        
        if($area){
            $area->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'boss' => $request->input('boss'),
                'active' => $request->has('active') ? 1 : 0
            ]);
            return redirect()->route('area')->with('success', 'Área actualizada exitosamente.');
        }
        return redirect()->route('area')->with('error'. 'Área no encontrada');
    }

    public function destroy($id)
    {
        $area = $this->areaRepository->getById($id);

        if ($area) {
            $area->delete();
            return redirect()->route('area')->with('success', 'Área eliminada exitosamente.');
        } else {
            return redirect()->route('area')->with('error', 'Área no encontrada.');
        }
    }

    public function groups(int $id)
    {
        $area = $this->areaRepository->getAreaRelations($id);
        $availableGroupTypes = $this->groupTypeRepository->getActives();
        return view('areas.groups-area', compact('area', 'availableGroupTypes'));
    }
}
