<?php

namespace App\Http\Controllers;

use App\Services\MikrotikService;
use Illuminate\Http\Request;

class IpAddressController extends Controller
{
    protected $mikrotikService;

    public function __construct(MikrotikService $mikrotikService)
    {
        $this->mikrotikService = $mikrotikService;
    }

    public function get()
    {
        $query = '/ip/address/print';
        $data = $this->mikrotikService->getData($query);
        $userName = env('MIKROTIK_USER');
        $entity = 'ipaddress';

        return view('Control', ['datas' => $data, 'userName' => $userName, 'action' => 'list', 'entity' => $entity]);
    }

    public function create()
    {
        // Retorna la vista del formulario de creación de usuario
        $relations = [
            'interface' => $this->mikrotikService->getData('/interface/print'),
        ];
        $fields = [
            'write_fields' => ['address', 'network'],
            'option_fields' => ['interface'],
            'boolean_fields' => ['disabled']
        ];
        return view(
            'Control',
            [
                'entity' => 'ipaddress',
                'action' => 'create',
                'fields' => $fields,
                'relations' => $relations,
            ]
        );
    }

    public function add(Request $request)
    {
        // Validación de datos
        $request->validate([
            'address' => 'required|string|max:255',
            'interface' => 'required|string|',
            'disable' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['address', 'interface', 'disable', 'network']);

        $response = $this->mikrotikService->create($data, '/ip/address/add');

        if (isset($response['after']['ret'])) {
            return redirect()->route('mikrotik.ipaddress.list')->with('mensaje', 'Usuario creado exitosamente');
        } else {
            return redirect()->route('mikrotik.ipaddress.create')->with('mensaje', 'Error al crear el usuario: ');
        }
    }

    public function delete($id)
    {
        $response = $this->mikrotikService->deleteById($id, '/ip/address/remove');

        return redirect()->route('mikrotik.ipaddress.list', $id)->with('status', 'Usuario actualizado correctamente');
    }
}
 