<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;

class CompanyController extends Controller
{
    const FIELDS = ['name', 'nip', 'address', 'city', 'post_code'];

    /**
     * Create company
     * 
     * @param Request $request
     */
    public function create(Request $request)
    {
        // validate required fields
        foreach (self::FIELDS as $field) {
            if (empty($request->$field)) {
                return response()->json([
                    'error' => [
                        'message' => 'All required fields must be filled: name, NIP, address, city, and post_code.',
                    ],
                ], 400);
            } elseif ($field == 'nip' && !Company::validateNip($request->nip)) {
                return response()->json([
                    'error' => [
                        'message' => 'You enter wrong value into nip field.',
                    ],
                ], 400);
            }
        }

        // validate exist of company by nip
        if (Company::checkExistByNip($request->nip)) {
            return response()->json([
                'error' => [
                    'message' => "Company already exist with this nip: {$request->nip}.",
                ],
            ], 400);
        }

        // create new
        $company = new Company();
        $company->name = $request->name;
        $company->nip = $request->nip;
        $company->address = $request->address;
        $company->city = $request->city;
        $company->post_code = $request->post_code;
        
        if ($company->save()) {
            return response()->json([
                'success' => [
                    'message' => 'Company created successfully.',
                    'company' => $company,
                ],
            ], 201);
        }

        // when something is wrong with saving company throw error
        return response()->json([
            'error' => [
                'message' => 'An error occurred while creating the company. Please try again later.',
            ],
        ], 500);
    }

    /**
     * Show list of companies
     */
    public function list()
    {
        return Company::all();
    }

    /**
     * Show specific company by id
     * 
     * @param int $id_company
     */
    public function showSpecific(int $id_company)
    {
        if (empty($id_company)) {
            return response()->json([
                'error' => [
                    'message' => 'Id is a required param.',
                ],
            ], 500);
        }

        // try to find company
        $company = Company::find($id_company);
        if (!empty($company)) {
            return $company;
        }

        return response()->json([
            'error' => [
                'message' => "Compnay with id_company {$id_company} not exists.",
            ],
        ], 400);
    }

    /**
     * Delete company
     * 
     * @param int $id_company
     */
    public function delete(int $id_company)
    {
        if (empty($id_company)) {
            return response()->json([
                'error' => [
                    'message' => 'Id is a required param.',
                ],
            ], 500);
        }

        $company = Company::find($id_company);
        if (empty($company)) {
            return response()->json([
                'error' => [
                    'message' => "Compnay with id_company {$id_company} not exists.",
                ],
            ], 400);
        } elseif ($company->delete()) {
            return response()->json([
                'success' => [
                    'message' => 'Company deleted successfully.',
                    'company' => $company,
                ],
            ], 201);
        }

        // when something is wrong with saving company throw error
        return response()->json([
            'error' => [
                'message' => 'An error occurred while deleteing the company. Please try again later.',
            ],
        ], 500);
    }

    /**
     * Update company
     * 
     * @param int $id_company
     * @param Request $request
     */
    public function update(int $id_company, Request $request)
    {
        // validate required fields
        foreach (self::FIELDS as $field) {
            if (empty($request->$field)) {
                return response()->json([
                    'error' => [
                        'message' => 'All required fields must be filled: name, address, city, and post_code.',
                    ],
                ], 400);
            }
        }

        // update
        $company = Company::find($id_company);

        // check exist of comapny
        if (empty($company)) {
            return response()->json([
                'error' => [
                    'message' => "Company dont exist with id {$id_company}",
                ],
            ], 400);
        } elseif ($company->getCompanyByNip($request->nip)) {
            
        }

        $company->name = $request->name;
        $company->address = $request->address;
        $company->city = $request->city;
        $company->post_code = $request->post_code;
        
        if ($company->update()) {
            return response()->json([
                'success' => [
                    'message' => 'Company updated successfully.',
                    'company' => $company,
                ],
            ], 201);
        }

        // when something is wrong with saving company throw error
        return response()->json([
            'error' => [
                'message' => 'An error occurred while updateing the company. Please try again later.',
            ],
        ], 500);
    }

    /**
     * Show list of company employees
     * 
     * @param int $id_company
     */
    public function employees(int $id_company)
    {
        $company = Company::find($id_company);
        if (empty($company)) {
            return response()->json([
                'error' => [
                    'message' => "Company dont exist with id_company {$id_company}",
                ],
            ], 400);
        }
        
        // list of employees
        $employees = $company->getEmployees();
        if (count($employees) > 0) {
            return $employees;
        }

        return response()->json([
            'error' => [
                'message' => "There is no employee in the company with id_company {$id_company}",
            ],
        ], 400);
    }
}
