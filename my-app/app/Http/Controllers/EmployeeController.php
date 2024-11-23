<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;

class EmployeeController extends Controller
{
    const FIELDS = ['name', 'surname', 'email', 'phone'];

    /**
     * Create employee
     * 
     * @param Request $request
     */
    public function create(Request $request)
    {
        // validate required fields
        foreach (self::FIELDS as $field) {
            if (empty($request->$field) && $field != 'phone') {
                return response()->json([
                    'error' => [
                        'message' => 'All required fields must be filled: name, surname, email, phone (optional).',
                    ],
                ], 400);
            } elseif ($field == 'phone' && !Employee::validatePhone($request->phone)) {
                return response()->json([
                    'error' => [
                        'message' => 'You enter wrong value into phone field.',
                    ],
                ], 400);
            }
        }

        // validate exist of employee by email
        if (Employee::checkExistByEmail($request->email)) {
            return response()->json([
                'error' => [
                    'message' => "Employee already exist with this email: {$request->email}.",
                ],
            ], 400);
        }

        // create new
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->surname = $request->surname;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        
        if ($employee->save()) {
            return response()->json([
                'success' => [
                    'message' => 'Employee created successfully.',
                    'employee' => $employee,
                ],
            ], 201);
        }

        // when something is wrong with saving employee throw error
        return response()->json([
            'error' => [
                'message' => 'An error occurred while creating the employee. Please try again later.',
            ],
        ], 500);
    }

    /**
     * Show list of employees
     */
    public function list()
    {
        $employees = Employee::all();
        if (!empty($employees)) {
            return $employees;
        }

        return response()->json([
            'error' => [
                'message' => "Employee dont exists.",
            ],
        ], 400);
    }

    /**
     * Show specific employee by id
     * 
     * @param int $id_employee
     */
    public function showSpecific(int $id_employee)
    {
        if (empty($id_employee)) {
            return response()->json([
                'error' => [
                    'message' => 'Id is a required param.',
                ],
            ], 500);
        }

        // try to find employee
        $employee = Employee::find($id_employee);
        if (!empty($employee)) {
            return $employee;
        }

        return response()->json([
            'error' => [
                'message' => "Employee with id {$id_employee} not exists.",
            ],
        ], 400);
    }

    /**
     * Delete employee
     * 
     * @param int $id_employee
     */
    public function delete(int $id_employee)
    {
        if (empty($id_employee)) {
            return response()->json([
                'error' => [
                    'message' => 'Id is a required param.',
                ],
            ], 500);
        }

        $employee = Employee::find($id_employee);
        if (!empty($employee) && $employee->delete()) {
            return response()->json([
                'success' => [
                    'message' => 'Employee deleted successfully.',
                    'employee' => $employee,
                ],
            ], 201);
        }

        // when something is wrong with saving employee throw error
        return response()->json([
            'error' => [
                'message' => 'An error occurred while deleteing the employee. Please try again later.',
            ],
        ], 500);
    }

    /**
     * Update employee
     * 
     * @param int $id_employee
     * @param Request $request
     */
    public function update(int $id_employee, Request $request)
    {
        // validate required fields
        foreach (self::FIELDS as $field) {
            if (empty($request->$field) && $field != 'phone') {
                return response()->json([
                    'error' => [
                        'message' => 'All required fields must be filled: name, surname, email, phone (optional).',
                    ],
                ], 400);
            }
        }

        // update
        $employee = Employee::find($id_employee);

        // check exist of employee
        if (empty($employee)) {
            return response()->json([
                'error' => [
                    'message' => "Employee dont exist with id {$id_employee}",
                ],
            ], 400);
        } elseif ($employee->getEmployeeByEmail($request->email)) {
            return response()->json([
                'error' => [
                    'message' => "Employee allready exist with this email {$request->email}.",
                ],
            ], 400);
        }

        $employee->name = $request->name;
        $employee->surname = $request->surname;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        
        if ($employee->update()) {
            return response()->json([
                'success' => [
                    'message' => 'Employee updated successfully.',
                    'employee' => $employee,
                ],
            ], 201);
        }

        // when something is wrong with updateing employee throw error
        return response()->json([
            'error' => [
                'message' => 'An error occurred while updateing the employee. Please try again later.',
            ],
        ], 500);
    }
}
