<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    private $request;
    private $customer;

    public function __construct(Request $request, Customer $customer) {
        $this->request = $request;
        $this->customer = $customer;
    }

    public function store(){
        $validator = Validator::make($this->request->all(), [
            'group_id' => 'required',
            'cnpj' => 'required|size:14',
            'name' => 'required',
            'foundation_date' => 'required',
        ]);

        // Validates the required fields
        if ($validator->fails()){
            return response()->json([
                'error' => $validator->messages()
            ], 400);
        }

        $this->customer->store($this->request->all());
        
        return response()->json([
            'success' => 'Você criou o cliente.'
        ], 201);
    }

    public function update($id){
        $validator = Validator::make($this->request->all(), [
            'group_id' => 'required',
            'cnpj' => 'required|size:14',
            'name' => 'required',
            'foundation_date' => 'required',
        ]);

        // Validates the required fields
        if ($validator->fails()){
            return response()->json([
                'error' => $validator->messages()
            ], 400);
        }

        $this->customer->updateById($id, $this->request->all());
        
        return response()->json([
            'success' => 'Você editou o cliente.'
        ], 202);
    }

    public function get(){
        return response()->json([
            'data' => Customer::with('group')->paginate(10)
        ], 200);
    }

    public function getById($id){
        return response()->json([
            'data' => Customer::with('group')->find($id)
        ], 200);
    }
}
