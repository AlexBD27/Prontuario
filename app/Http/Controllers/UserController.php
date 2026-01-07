<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\CreateUserRequest;
use App\Http\Requests\user\EditUserRequest;
use App\Repositories\AreaRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkerRepository;
use Hash;


class UserController extends Controller
{

    private UserRepository $userRepository;
    private AreaRepository $areaRepository;
    private WorkerRepository $workerRepository;

    public function __construct(UserRepository $userRepository, AreaRepository $areaRepository, WorkerRepository $workerRepository)
    {
        $this->userRepository = $userRepository;
        $this->areaRepository = $areaRepository;
        $this->workerRepository = $workerRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getUsers();
        return view('user.index-user', compact('users'));
    }

    public function create()
    {
        $areas = $this->areaRepository->getWithRelations();
        return view('user.create-user', compact('areas'));
    }

    public function store(CreateUserRequest $request)
    {
        try{
            $this->validate($request);

            $user = $this->userRepository->create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $worker = $this->workerRepository->create([
                'name'=> $request->name,
                'dni'=> $request->dni,
                'user_id'=> $user->id,
                'group_id' => $request->grupo,
                'subgroup_id' => $request->subgrupo?: null,
                'position' => $request->position
            ]);
    
            return redirect()->route('user')->with('success', 'Usuario creado exitosamente.');
        }catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(int $id)
    {
        
    }

    public function edit(int $id)
    {
        $user = $this->userRepository->getById($id);

        if (!$user) {
            return redirect()->route('user')->with('error', 'El usuario no existe.');
        }

        $areas = $this->areaRepository->getWithRelations();
        $selectedAreaId = optional($user->worker->group->area)->id;
        $selectedTipoGrupoId = optional($user->worker->group->areaGroupType->groupType)->id;
        $selectedGrupoId = optional($user->worker->group)->id;
        $selectedSubgrupoId = optional($user->worker->subgroup)->id;
        return view('user.edit-user', compact('user', 'areas', 'selectedAreaId', 'selectedTipoGrupoId', 'selectedGrupoId', 'selectedSubgrupoId'));
    }

    public function update(EditUserRequest $request, int $id)
    {
        try{
            $this->validate($request);

            $user = $this->userRepository->getById($id);
            $worker = $user->worker;
            
            if($user)
            {
                $user->update([
                    'email' => $request->email,
                    'password' => $request->password ? Hash::make($request->password) : $user->password,
                ]);
        
                $worker->update([
                    'name' => $request->name,
                    'dni' => $request->dni,
                    'group_id' => $request->grupo,
                    'subgroup_id' => $request->subgrupo ?: null,
                    'position' => $request->position,
                ]);

                return redirect()->route('user')->with('success', 'Usuario actualizado exitosamente.');
            }else{
                return redirect()->route('user')->with('error', 'Usuario no encontrado.');
            }

        }catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        $user = $this->userRepository->getById($id);
        $worker = $user->worker;
        if($worker)
        {
            $this->workerRepository->delete($worker->id);
            $this->userRepository->delete($id);
            return redirect()->route('user')->with('success', 'Usuario eliminado exitosamente.');
        }
        return redirect()->route('user')->with('error', 'Usuario no encontrado.');
    }

    public function validate($data)
    {
        if (empty($data->input('area'))) {
            throw new \InvalidArgumentException("Debe seleccionar una área para el trabajador.");
        }
        if (empty($data->input('tipo_grupo'))) {
            throw new \InvalidArgumentException("Debe seleccionar un tipo de grupo para el trabajador.");
        }
        if (empty($data->input('grupo'))) {
            throw new \InvalidArgumentException("Debe seleccionar un grupo para el trabajador.");
        }
    }
}
