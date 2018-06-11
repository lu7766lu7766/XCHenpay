<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Http\Controllers\JoshController;
use App\Http\Requests\UserRequest;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use function compact;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function md5;
use Redirect;
use Sentinel;
use function str_random;
use URL;
use View;
use Yajra\DataTables\DataTables;
use Validator;
Use App\Mail\Restore;
use stdClass;

class CompanyController extends JoshController
{
    /**
     * Show a list of all the users.
     *
     * @return View
     */

    public function index()
    {
        // Show the page
        return view('admin.companies.index');
    }

    /*
     * Pass data through ajax call
     */
    /**
     * @return mixed
     */
    public function data()
    {
        $companies = Company::get(['id', 'name', 'service_id', 'sceret_key','created_at']);

        return DataTables::of($companies)
            ->editColumn('created_at',function(Company $company) {
                return $company->created_at->diffForHumans();
            })
            ->addColumn('actions',function($company) {
                $actions = '<a href='. route('admin.companies.show', $company->id) .'><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('companies/CompanyList/form.view_company') . '></i></a>
                            <a href='. route('admin.companies.edit', $company->id) .'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('companies/CompanyList/form.update_company') . '></i></a>';
                if ($company->id != 1) {
                    $actions .= '<a href='. route('admin.companies.confirm-delete', $company->id) .' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="user-remove" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title=' . trans('companies/CompanyList/form.delete_company') . '></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Create new user
     *
     * @return View
     */
    public function create()
    {
        // Show the page
        return view('admin.companies.create');
    }

    /**
     * User create form processing.
     *
     * @return Redirect
     */
    public function store()
    {
        try {

            $data = request()->all();
            $data['sceret_key'] = md5(str_random(32));

            $company = Company::create($data);

            // Activity log for New user create
            activity($company->name)
                ->performedOn($company)
                ->causedBy($company)
                ->log('New Company Created by '.Sentinel::getUser()->full_name);
            // Redirect to the home page with success menu
            return Redirect::route('admin.companies.show', compact('company'))->with('success', trans('companies/message.success.create'));
        } catch (LoginRequiredException $e) {
            $error = trans('admin/companies/message.user_login_required');
        } catch (UserExistsException $e) {
            $error = trans('admin/companies/message.user_exists');
        }

        // Redirect to the user creation page
        return Redirect::back()->withInput()->with('error', $error);
    }

    public function show($id)
    {
        try {
            // Get the user information
            $company = Company::find($id);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('companies/message.company_not_found', compact('id'));
            // Redirect to the user management page
            return Redirect::route('admin.companies.index')->with('error', $error);
        }
        // Show the page
        return view('admin.companies.show', compact('company'));

    }

    /**
     * Show a list of all the deleted users.
     *
     * @return View
     */
    public function getDeletedCompanies()
    {
        // Grab deleted users
        $companies = Company::onlyTrashed()->get();
        // Show the page
        return view('admin.companies.deleted_companies', compact('companies'));
    }

    public function edit(Company $company)
    {
        // Show the page
//        return view('admin.users.edit', compact('company', 'roles', 'userRoles', 'countries', 'status'));
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * User update form processing page.
     *
     * @param  User $user
     * @param UserRequest $request
     * @return Redirect
     */
    public function update(Company $company)
    {
        try {
            $company->update(request()->only(['name','service_id']));

            // Was the user updated?
            if ($company->save()) {
                // Prepare the success message
                $success = trans('companies/message.success.update');
                //Activity log for user update
                activity($company->name)
                    ->performedOn($company)
                    ->causedBy($company)
                    ->log('Company Updated by '.Sentinel::getUser()->full_name);
                // Redirect to the user page
                return Redirect::route('admin.companies.edit', $company)->with('success', $success);
            }

            // Prepare the error message
            $error = trans('companies/message.error.update');
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('companies/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('admin.companies.index')->with('error', $error);
        }

        // Redirect to the user page
        return Redirect::route('admin.companies.edit', $company)->withInput()->with('error', $error);
    }

    /**
     * Delete Confirm
     *
     * @param   int $id
     * @return  View
     */
    public function getModalDelete($id)
    {
        $model = 'companies';
        $confirm_route = $error = null;

        $confirm_route = route('admin.companies.delete', ['id' => $id]);
        return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    /**
     * Delete the given group.
     *
     * @param  int $id
     * @return Redirect
     */
    public function destroy(Company $company)
    {
        try {
            // Delete the group
            $company->delete();

            //Activity log for user update
            activity($company->name)
                ->performedOn($company)
                ->causedBy($company)
                ->log('Company deleted by '.Sentinel::getUser()->full_name);

            // Redirect to the group management page
            return Redirect::route('admin.companies.index')->with('success', trans('companies/message.success.delete'));
        } catch (GroupNotFoundException $e) {
            // Redirect to the group management page
            return Redirect::route('admin.companies.index')->with('error', trans('companies/message.company_not_found', compact('company')));
        }
    }

    /**
     * Restore a deleted user.
     *
     * @param  int $id
     * @return Redirect
     */
    public function getRestore($id)
    {
        try {
            // Get user information
            $company = Company::withTrashed()->find($id);
            info($company);
            // Restore the user
            $company->restore();

            // Prepare the success message
            $success = trans('companies/message.success.restored');
            activity($company->name)
                ->performedOn($company)
                ->causedBy($company)
                ->log('Company restored by '.Sentinel::getUser()->full_name);
            // Redirect to the user management page
            return Redirect::route('admin.deleted_companies')->with('success', $success);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('companies/message.company_not_found', compact('company'));

            // Redirect to the user management page
            return Redirect::route('admin.deleted_companies')->with('error', $error);
        }
    }

}
