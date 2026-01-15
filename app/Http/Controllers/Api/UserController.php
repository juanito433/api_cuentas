<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getUser($id)
    {
        $id_user = User::find($id);

        if (!$id_user) {
            return response()->json(
                [
                    'message' => 'usuario no encontrado'
                ],
                404
            );
        }
        return response()->json([
            'user' => $id_user
        ], 200);
    }

    /* Actualizar nombre de usuario, telefono y foto */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'menssage' => 'Usuario no encontrado'
            ]);
        }
        $request->validate([
            'username' => 'string',
            'phone' => 'string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);
        /* Actualizamos lo basico */
        $user->username = $request->input('username', $user->username);
        $user->phone->$request->input('phone', $user->photo);
        /* Procesamos la photo */

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists(str_replace('storage/', '', $user->photo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $user->photo));
            }
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = Storage::url($path);
        }
        $user->save();
        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'status' => 200,
            'user' => $user
        ], 200);
    }
}
