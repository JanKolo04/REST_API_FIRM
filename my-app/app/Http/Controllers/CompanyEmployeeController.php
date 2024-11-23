<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CompanyEmployee;
use App\Models\Company;
use App\Models\Employee;

class CompanyEmployeeController extends Controller
{
    /**
     * Add employee to company
     * 
     * @param int $id_company
     * @param int $id_employee
     */
    public function add(int $id_company, int $id_employee)
    {
        // validate required fields
        if (empty($id_company) || empty($id_employee)) {
            return response()->json([
                'error' => [
                    'message' => 'All required fields must be filled: id_company, id_employee.',
                ],
            ], 400);
        }

        // check exist of employee in company
        if (CompanyEmployee::checkExist(
            $id_company,
            $id_employee
        )) {
            return response()->json([
                'error' => [
                    'message' => "Employee with id {$id_employee} exist in company with id {$id_company}.",
                ],
            ], 400);
        }

        // check exist of employee in company
        $companyEmployee = CompanyEmployee::where('id_company', $id_company)
            ->where('id_employee', $id_employee)
            ->first();
        
        if (!empty($companyEmployee)) {
            return response()->json([
                'error' => [
                    'message' => "Employee with id {$id_employee} already exist in company with id {$id_company}.",
                ],
            ], 400);
        } elseif (empty(Company::find($id_company))) {
            return response()->json([
                'error' => [
                    'message' => "Company with id {$id_company} doesnt exist.",
                ],
            ], 400);
        } elseif (empty(Employee::find($id_employee))) {
            return response()->json([
                'error' => [
                    'message' => "Employee with id {$id_employee} doesnt exist.",
                ],
            ], 400);
        }

        $companyEmployee = new CompanyEmployee();
        $companyEmployee->id_company = $id_company;
        $companyEmployee->id_employee = $id_employee;
        
        if ($companyEmployee->save()) {
            return response()->json([
                'success' => [
                    'message' => 'Employee added successfully.',
                    'company' => $companyEmployee,
                ],
            ], 201);
        }

        return response()->json([
            'error' => [
                'message' => 'An error occurred while adding employee into company. Please try again later.',
            ],
        ], 500);
    }

    /**
     * Delete employee from company
     * 
     * @param int $id_company
     * @param int $id_employee
     */
    public function delete(int $id_company, int $id_employee)
    {
        // validate required fields
        if (empty($id_company) || empty($id_employee)) {
            return response()->json([
                'error' => [
                    'message' => 'All required fields must be filled: id_company, id_employee.',
                ],
            ], 400);
        }

        // check exist of employee in company
        $companyEmployee = CompanyEmployee::where('id_company', $id_company)
            ->where('id_employee', $id_employee)
            ->first();
        
        if (empty($companyEmployee)) {
            return response()->json([
                'error' => [
                    'message' => "Employee with id {$id_employee} doesnt exist in company with id {$id_company}.",
                ],
            ], 400);
        } elseif ($companyEmployee->delete()) {
            return response()->json([
                'success' => [
                    'message' => 'Employee deleted successfully form company.',
                ],
            ], 201);
        }

        return response()->json([
            'error' => [
                'message' => 'An error occurred while deleteing employee from company. Please try again later.',
            ],
        ], 500);
    }
}
