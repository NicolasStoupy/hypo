<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        $config = Config::all()->mapWithKeys(function ($item) {
            return [$item->key => ['value' => $item->value, 'type' => $item->type]];
        });

        return view('config.index', compact('config'));
    }
    public function update(Request $request)
    {
        $configData = $request->input('config');

        foreach ($configData as $key => $data) {
            $value = $data['value'];
            $type = $data['type'];

            // Convertir la valeur selon le type
            if ($type == 'integer') {
                $value = (int) $value;
            } elseif ($type == 'boolean') {
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }

            Config::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => $type]
            );
        }

        return response()->json(["message" => "Configuration mise à jour avec succès !"]);
    }

}
