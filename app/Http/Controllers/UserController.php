<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function profile()
    {
        return view('user.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'password' => ['nullable', 'string', 'min:6'],
            'image' => ['nullable', 'image']
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors($validator);
        }

        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($user->image) {
                $name = $user->image;
                #unlink(storage_path('app/public/users/'.$name));
            } else {
                $name = 'user'.$user->id;
            }

            $extension = $request->image->extension();

            $nameFile = "{$name}.{$extension}";

            $data['image'] = $nameFile;

            $upload = $request->image->storeAs('users', $nameFile);

            if (!$upload) {
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao carregar a imagem do perfil');
            }
        }

        $updated = $user->update($data);

        if ($updated) {
            return redirect()
                ->route('profile')
                ->with('success', 'Perfil atualizado com sucesso');
            }
            return redirect()
                ->back()
                ->with('error', 'Falha ao atualizar o perfil');
    }
}
