<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\User;
use App\Models\Worker;
use App\Repositories\AreaRepository;
use App\Services\ProntuarioService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */

     protected AreaRepository $areaRepository;

     public function __construct(AreaRepository $areaRepository)
    {
        $this->areaRepository = $areaRepository;
    }

    public function create(): View
    {
        $areas = $this->areaRepository->getWithRelations();
        return view('auth.register', compact('areas'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //dd($request);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'string', 'max:8'],
            'position' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'area' => ['required', 'string'],
            'tipo_grupo' => ['required', 'string'],
            'grupo' => ['required', 'string'],
        ]);

        

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Worker::create([
            'name'=> $request->name.' '.$request->lastname,
            'dni'=> $request->dni,
            'user_id'=> $user->id,
            'group_id' => $request->grupo,
            'subgroup_id' => $request->subgrupo?: null,
            'position' => $request->position
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard.user', absolute: false));
    }
}
