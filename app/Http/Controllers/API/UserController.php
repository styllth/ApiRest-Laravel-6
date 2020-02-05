<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return $this->sendResponse(UserResource::collection($users), 'Usuários recuperados com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('Usuário não encontrado.');
        }

        return $this->sendResponse(new UserResource($user), 'Usuário recuperado com sucesso.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Dados inválidos.', $validator->errors());
        }

        $user = User::create($input);

        return $this->sendResponse(new UserResource($user), 'Usuário criado com sucesso.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Dados inválidos.', $validator->errors());
        }

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->save();

        return $this->sendResponse(new UserResource($user), 'Usuário atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->sendResponse([], 'Usuário excluído com sucesso.');
    }
}
