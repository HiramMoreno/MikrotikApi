<?php

namespace App\Http\Controllers;

use App\Services\MikrotikService;
use Illuminate\Http\Request;

class BandwidthController extends Controller
{
    protected $mikrotikService;

    public function __construct(MikrotikService $mikrotikService)
    {
        $this->mikrotikService = $mikrotikService;
    }

    public function get()
    {
        $query = '/queue/simple/print';
        $data = $this->mikrotikService->getData($query);
        $userName = env('MIKROTIK_USER');
        $entity = 'bandwidth';

        return view('Control', ['datas' => $data, 'userName' => $userName, 'action' => 'list', 'entity' => $entity]);
    }

    public function create()
    {
        // Retorna la vista del formulario de creación de usuario
        $relations = [
            'target' => $this->mikrotikService->getData('/interface/print'),
        ];
        $fields = [
            'write_fields' => ['name', 'comment', 'max-limit'],
            'option_fields' => ['target'],
            'boolean_fields' => ['disabled']
        ];
        return view(
            'Control',
            [
                'entity' => 'bandwidth',
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
            'name' => 'required|string|max:255',
            'comment' => 'required|string|',
            'max-limit' => 'required|string',
/*             'max-limit-download' =>'required|string', */
            'target' => 'required|string',
            'disable' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['name', 'comment', 'max-limit', 'target', 'disable']);

        $response = $this->mikrotikService->create($data, '/queue/simple/add');

        if (isset($response['after']['ret'])) {
            return redirect()->route('mikrotik.bandwidth.list')->with('mensaje', 'Usuario creado exitosamente');
        } else {
            return redirect()->route('mikrotik.bandwidth.create')->with('mensaje', 'Error al crear el usuario: ');
        }
    }

    public function delete($id)
    {
        $response = $this->mikrotikService->deleteById($id, '/queue/simple/remove');

        return redirect()->route('mikrotik.bandwidth.list', $id)->with('status', 'Usuario actualizado correctamente');
    }
}
