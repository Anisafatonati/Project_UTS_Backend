<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $employees = Employees::all();

        if ($employees->isEmpty()) {
            return response()->json(['message' => 'Resource is empty'], 204);
        }

        $data = [
            "message" => "Get all Employees",
            "data" => $employees
        ];

        return response()->json($data, 200);
    }

    public function show($id)
    {
        $employees = Employees::find($id);

        if (!$employees) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json(['message' => 'Show detail resource', 'data' => $employees], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'phone' => 'numeric|required',
            'address' => 'required|string',
            'email' => 'email|required',
            'status' => 'required',
            'hired_on' => 'date|required',
        ]);

        $employees = Employees::create($validatedData);

        return response()->json(['message' => 'Employee is created successfully', 'data' => $employees], 201);
    }

    public function update($id, Request $request)
    {
        $employees = Employees::find($id);

        if ($employees) {
            $input = [
                'name' => $request->name ?? $employees->name,
                'gender' => $request->gender ?? $employees->gender,
                'phone' => $request->phone ?? $employees->phone,
                'address' => $request->address ?? $employees->address,
                'email' => $request->email ?? $employees->email,
                'status' => $request->status ?? $employees->status,
                'hired_on' => $request->hired_on ?? $employees->hired_on
            ];

            $employees->update($input);

            $data = [
                'message' => "Employees is updated",
                'data' => $employees
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Employees not found'
            ];
            return response()->json($data, 404);
        }
    }

    public function destroy($id)
    {
        $employees = Employees::find($id);

        if (!$employees) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employees->delete();

        return response()->json(['message' => 'Employee is deleted'], 200);
    }

    // Function untuk pencarian berdasarkan nama
    public function search($name)
{
    $employees = Employees::where('name', 'like', '%' . $name . '%')->get();

    if ($employees->isEmpty()) {
        return response()->json(['message' => 'No employees found with the given name'], 404);
    }

    $data = [
        'message' => 'Search results for employees with name: ' . $name,
        'data' => $employees
    ];

    return response()->json($data, 200);
}


    // Function untuk mendapatkan employees dengan status aktif
    public function getActive()
    {
        $employees = Employees::where('status', 'active')->get();

        if ($employees->isEmpty()) {
            return response()->json(['message' => 'No active employees found'], 404);
        }

        $data = [
            'message' => 'Get active employees',
            'data' => $employees
        ];

        return response()->json($data, 200);
    }

    // Function untuk mendapatkan employees dengan status tidak aktif
    public function getInactive()
    {
        $employees = Employees::where('status', 'inactive')->get();

        if ($employees->isEmpty()) {
            return response()->json(['message' => 'No inactive employees found'], 404);
        }

        $data = [
            'message' => 'Get inactive employees',
            'data' => $employees
        ];

        return response()->json($data, 200);
    }

    // Function untuk mendapatkan employees dengan status terminated
    public function getTerminated()
    {
        $employees = Employees::where('status', 'terminated')->get();

        if ($employees->isEmpty()) {
            return response()->json(['message' => 'No terminated employees found'], 404);
        }

        $data = [
            'message' => 'Get terminated employees',
            'data' => $employees
        ];

        return response()->json($data, 200);
    }
}
