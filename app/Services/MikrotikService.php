<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;


class MikrotikService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'host' => env('MIKROTIK_HOST'),
            'user' => env('MIKROTIK_USER'),
            'pass' => env('MIKROTIK_PASSWORD'),
        ]);
    }

    public function getData($query)
    {
        $query = new Query($query);
        return $this->client->query($query)->read();
    }

    public function getById($id, $query)
    {
        $query = (new Query($query))
            ->where('.id', $id);

        return $this->client->query($query)->read()[0];
    }

    public function create(array $data, $query)
    {
        // Aquí puedes ajustar el comando según los requisitos de la API de MikroTik
        $query = (new Query($query));

        foreach ($data as $field => $value) {
            if ($value !== null) {
                $query->equal($field, $value);
            }
        }

        return $this->client->query($query)->read();
    }

    public function deleteById($id, $query)
    {
        $query = (new Query($query))
            ->equal('.id', $id);

        return $this->client->query($query)->read();
    }
}
