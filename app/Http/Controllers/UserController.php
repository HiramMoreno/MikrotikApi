<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\MikrotikService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $mikrotikService;

    public function __construct(MikrotikService $mikrotikService)
    {
        $this->mikrotikService = $mikrotikService;
    }

    public function getUsers()
    {
        $query = '/user/print';
        $data = $this->mikrotikService->getData($query);
        $userName = env('MIKROTIK_USER');
        $entity = 'user';

        return view('Control', ['datas' => $data, 'userName' => $userName, 'action' => 'list', 'entity' => $entity]);
    }

    public function create()
    {
        // Retorna la vista del formulario de creación de usuario
        $relations = [
            'group' => $this->mikrotikService->getData('/user/group/print'),
        ];
        $fields = [
            'write_fields' => ['name', 'password', 'comment'],
            'option_fields' => ['group'],
        ];
        return view(
            'Control',
            [
                'entity' => 'user',
                'action' => 'create',
                'fields' => $fields,
                'relations' => $relations,
            ]
        );
    }

    public function add(Request $request)
    {
         
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:5',
            'group' => 'required|string',
            'comment' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['name','password','group','comment']);

        $response = $this->mikrotikService->create($data, '/user/add');

        if (isset($response['after']['ret'])) {
            return redirect()->route('mikrotik.user.list')->with('mensaje', 'Usuario creado exitosamente');
        }
         else {
            return redirect()->route('mikrotik.user.create')->with('mensaje', 'Error al crear el usuario: ');
        }
    }

    public function delete($id)
    {
        $response = $this->mikrotikService->deleteById($id, '/user/remove');

        return redirect()->route('mikrotik.user.list', $id)->with('status', 'Usuario actualizado correctamente');
    }
}
