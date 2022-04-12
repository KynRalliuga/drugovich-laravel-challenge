<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    private $request;
    private $group;

    public function __construct(Request $request, Group $group) {
        $this->request = $request;
        $this->group = $group;
    }

    public function store(){
        // Check the manager level
        if(!$this->request->manager->isLevel2()){
            return response()->json([
                'error' => 'Você não tem permissões suficientes para criar um grupo.'
            ], 401);
        }

        $validator = Validator::make($this->request->all(), [
            'name' => 'required',
        ]);

        // Validates the required fields
        if ($validator->fails()){
            return response()->json([
                'error' => $validator->messages()
            ], 400);
        }

        $this->group->store($this->request->name);
        
        return response()->json([
            'success' => 'Você criou o grupo.'
        ], 201);
    }

    public function update($id){
        // Check the manager level
        if(!$this->request->manager->isLevel2()){
            return response()->json([
                'error' => 'Você não tem permissões suficientes para editar um grupo.'
            ], 401);
        }

        $validator = Validator::make($this->request->all(), [
            'name' => 'required',
        ]);

        // Validates the required fields
        if ($validator->fails()){
            return response()->json([
                'error' => $validator->messages()
            ], 400);
        }

        $this->group->updateById($id, $this->request->name);
        
        return response()->json([
            'success' => 'Você editou o grupo.'
        ], 202);
    }

    public function delete($id){
        // Check the manager level
        if(!$this->request->manager->isLevel2()){
            return response()->json([
                'error' => 'Você não tem permissões suficientes para excluir um grupo.'
            ], 401);
        }

        $this->group->find($id)->delete();
        
        return response()->json([
            'success' => 'Você excluiu o grupo.'
        ], 202);
    }

    public function get(){
        return response()->json([
            'data' => Group::paginate(10)
        ], 200);
    }

    public function getById($id){
        return response()->json([
            'data' => Group::find($id)
        ], 200);
    }
}
