<?php

use Addons\Employee\Controllers\Admin\DepartmentController;
use Addons\Employee\Controllers\Admin\DesignationController;
use Addons\Employee\Controllers\Admin\EmployeeAddonUpdateController;
use Addons\Employee\Controllers\Admin\EmployeeContactController;
use Addons\Employee\Controllers\Admin\EmployeeController;
use Addons\Employee\Controllers\Admin\EmployeeDocumentController;
use Addons\Employee\Controllers\Admin\EmployeeExportImportController;
use Addons\Employee\Controllers\Admin\EmployeeQualificationController;
use Addons\Employee\Controllers\Admin\IdTypeController;
use Addons\Employee\Controllers\Admin\JobCategoryController;
use Addons\Employee\Controllers\Admin\JobTypeController;
use Addons\Employee\Controllers\Admin\LeaveTableController;
use Addons\Employee\Controllers\Admin\LeaveTypeController;
use Addons\Employee\Controllers\Admin\ProvidentFundController;
use Addons\Employee\Controllers\Admin\RaceController;
use Addons\Employee\Controllers\Admin\RelationshipController;
use Addons\Employee\Controllers\Admin\WorkTableController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */;

Route::middleware( ['web', 'auth'] )->group( function () {

    Route::prefix( 'admin' )->group( function () {

        // ------ Department -----
        Route::prefix( 'department' )->group( function () {
            Route::get( '/', [DepartmentController::class, 'index'] )->name( 'department.index' );
            Route::post( '/store', [DepartmentController::class, 'store'] )->name( 'department.store' );
            Route::get( '/edit/{id}', [DepartmentController::class, 'edit'] )->name( 'department.edit' );
            Route::post( '/update/{id}', [DepartmentController::class, 'update'] )->name( 'department.update' );
            Route::delete( '/delete/{id}', [DepartmentController::class, 'destroy'] )->name( 'department.destroy' );

            Route::get( '/trash', [DepartmentController::class, 'indexTrash'] )->name( 'department.trash' );
            Route::get( '/restore/{id}', [DepartmentController::class, 'restore'] )->name( 'department.restore' );
            Route::delete( '/force-delete/{id}', [DepartmentController::class, 'forceDelete'] )->name( 'department.forceDelete' );
            Route::delete( '/delete-all', [DepartmentController::class, 'deleteAll'] )->name( 'department.delete.all' );
        } );

        // ------ Desaignation -----
        Route::prefix( 'designation' )->group( function () {
            Route::get( '/', [DesignationController::class, 'index'] )->name( 'designation.index' );
            Route::post( '/store', [DesignationController::class, 'store'] )->name( 'designation.store' );
            Route::get( '/edit/{id}', [DesignationController::class, 'edit'] )->name( 'designation.edit' );
            Route::post( '/update/{id}', [DesignationController::class, 'update'] )->name( 'designation.update' );
            Route::delete( '/delete/{id}', [DesignationController::class, 'destroy'] )->name( 'designation.destroy' );

            Route::get( '/trash', [DesignationController::class, 'indexTrash'] )->name( 'designation.trash' );
            Route::get( '/restore/{id}', [DesignationController::class, 'restore'] )->name( 'designation.restore' );
            Route::delete( '/force-delete/{id}', [DesignationController::class, 'forceDelete'] )->name( 'designation.forceDelete' );
            Route::delete( '/delete-all', [DesignationController::class, 'deleteAll'] )->name( 'designation.delete.all' );
        } );

        // ------ Job type -----
        Route::prefix( 'job-type' )->group( function () {
            Route::get( '/', [JobTypeController::class, 'index'] )->name( 'job.type.index' );
            Route::post( '/store', [JobTypeController::class, 'store'] )->name( 'job.type.store' );
            Route::get( '/edit/{id}', [JobTypeController::class, 'edit'] )->name( 'job.type.edit' );
            Route::post( '/update/{id}', [JobTypeController::class, 'update'] )->name( 'job.type.update' );
            Route::delete( '/delete/{id}', [JobTypeController::class, 'destroy'] )->name( 'job.type.destroy' );

            Route::get( '/trash', [JobTypeController::class, 'indexTrash'] )->name( 'job.type.trash' );
            Route::get( '/restore/{id}', [JobTypeController::class, 'restore'] )->name( 'job.type.restore' );
            Route::delete( '/force-delete/{id}', [JobTypeController::class, 'forceDelete'] )->name( 'job.type.forceDelete' );
            Route::delete( '/delete-all', [JobTypeController::class, 'deleteAll'] )->name( 'job.type.delete.all' );
        } );

        // ------ job category -----
        Route::prefix( 'job-category' )->group( function () {
            Route::get( '/', [JobCategoryController::class, 'index'] )->name( 'job.category.index' );
            Route::post( '/store', [JobCategoryController::class, 'store'] )->name( 'job.category.store' );
            Route::get( '/edit/{id}', [JobCategoryController::class, 'edit'] )->name( 'job.category.edit' );
            Route::post( '/update/{id}', [JobCategoryController::class, 'update'] )->name( 'job.category.update' );
            Route::delete( '/delete/{id}', [JobCategoryController::class, 'destroy'] )->name( 'job.category.destroy' );

            Route::get( '/trash', [JobCategoryController::class, 'indexTrash'] )->name( 'job.category.trash' );
            Route::get( '/restore/{id}', [JobCategoryController::class, 'restore'] )->name( 'job.category.restore' );
            Route::delete( '/force-delete/{id}', [JobCategoryController::class, 'forceDelete'] )->name( 'job.category.forceDelete' );
            Route::delete( '/delete-all', [JobCategoryController::class, 'deleteAll'] )->name( 'job.category.delete.all' );
        } );

        // ------ Leave Type -------
        Route::prefix( 'leave-type' )->group( function () {
            Route::get( '/', [LeaveTypeController::class, 'index'] )->name( 'leave.type.index' );
            Route::post( '/store', [LeaveTypeController::class, 'store'] )->name( 'leave.type.store' );
            Route::get( '/edit/{id}', [LeaveTypeController::class, 'edit'] )->name( 'leave.type.edit' );
            Route::post( '/update/{id}', [LeaveTypeController::class, 'update'] )->name( 'leave.type.update' );
            Route::delete( '/delete/{id}', [LeaveTypeController::class, 'destroy'] )->name( 'leave.type.destroy' );

            Route::get( '/trash', [LeaveTypeController::class, 'indexTrash'] )->name( 'leave.type.trash' );
            Route::get( '/restore/{id}', [LeaveTypeController::class, 'restore'] )->name( 'leave.type.restore' );
            Route::delete( '/force-delete/{id}', [LeaveTypeController::class, 'forceDelete'] )->name( 'leave.type.forceDelete' );
            Route::delete( '/delete-all', [LeaveTypeController::class, 'deleteAll'] )->name( 'leave.type.delete.all' );
        } );

        // ------ Leave Table -------
        Route::prefix( 'leave-table' )->group( function () {
            Route::get( '/', [LeaveTableController::class, 'index'] )->name( 'leave.table.index' );
            Route::get( '/create', [LeaveTableController::class, 'create'] )->name( 'leave.table.create' );
            Route::post( '/store', [LeaveTableController::class, 'store'] )->name( 'leave.table.store' );
            Route::get( '/edit/{id}', [LeaveTableController::class, 'edit'] )->name( 'leave.table.edit' );
            Route::post( '/update/{id}', [LeaveTableController::class, 'update'] )->name( 'leave.table.update' );
            Route::delete( '/delete/{id}', [LeaveTableController::class, 'destroy'] )->name( 'leave.table.destroy' );

            Route::get( '/trash', [LeaveTableController::class, 'indexTrash'] )->name( 'leave.table.trash' );
            Route::get( '/restore/{id}', [LeaveTableController::class, 'restore'] )->name( 'leave.table.restore' );
            Route::delete( '/force-delete/{id}', [LeaveTableController::class, 'forceDelete'] )->name( 'leave.table.forceDelete' );
            Route::delete( '/delete-all', [LeaveTableController::class, 'deleteAll'] )->name( 'leave.table.delete.all' );
        } );

        // ------ Wark table Table -------
        Route::prefix( 'work-table' )->group( function () {
            Route::get( '/', [WorkTableController::class, 'index'] )->name( 'work.table.index' );
            Route::get( '/create', [WorkTableController::class, 'create'] )->name( 'work.table.create' );
            Route::post( '/store', [WorkTableController::class, 'store'] )->name( 'work.table.store' );
            Route::get( '/edit/{id}', [WorkTableController::class, 'edit'] )->name( 'work.table.edit' );
            Route::post( '/update/{id}', [WorkTableController::class, 'update'] )->name( 'work.table.update' );
            Route::delete( '/delete/{id}', [WorkTableController::class, 'destroy'] )->name( 'work.table.destroy' );

            Route::get( '/trash', [WorkTableController::class, 'indexTrash'] )->name( 'work.table.trash' );
            Route::get( '/restore/{id}', [WorkTableController::class, 'restore'] )->name( 'work.table.restore' );
            Route::delete( '/force-delete/{id}', [WorkTableController::class, 'forceDelete'] )->name( 'work.table.forceDelete' );
            Route::delete( '/delete-all', [WorkTableController::class, 'deleteAll'] )->name( 'work.table.delete.all' );
        } );

        // ------ Relationship -----
        Route::prefix( 'relationship' )->group( function () {
            Route::get( '/', [RelationshipController::class, 'index'] )->name( 'relationship.index' );
            Route::post( '/store', [RelationshipController::class, 'store'] )->name( 'relationship.store' );
            Route::get( '/edit/{id}', [RelationshipController::class, 'edit'] )->name( 'relationship.edit' );
            Route::post( '/update/{id}', [RelationshipController::class, 'update'] )->name( 'relationship.update' );
            Route::delete( '/delete/{id}', [RelationshipController::class, 'destroy'] )->name( 'relationship.destroy' );

            Route::get( '/trash', [RelationshipController::class, 'indexTrash'] )->name( 'relationship.trash' );
            Route::get( '/restore/{id}', [RelationshipController::class, 'restore'] )->name( 'relationship.restore' );
            Route::delete( '/force-delete/{id}', [RelationshipController::class, 'forceDelete'] )->name( 'relationship.forceDelete' );
            Route::delete( '/delete-all', [RelationshipController::class, 'deleteAll'] )->name( 'relationship.delete.all' );
        } );

        // ------ Identification type -----
        Route::prefix( 'id-type' )->group( function () {
            Route::get( '/', [IdTypeController::class, 'index'] )->name( 'idType.index' );
            Route::post( '/store', [IdTypeController::class, 'store'] )->name( 'idType.store' );
            Route::get( '/edit/{id}', [IdTypeController::class, 'edit'] )->name( 'idType.edit' );
            Route::post( '/update/{id}', [IdTypeController::class, 'update'] )->name( 'idType.update' );
            Route::delete( '/delete/{id}', [IdTypeController::class, 'destroy'] )->name( 'idType.destroy' );

            Route::get( '/trash', [IdTypeController::class, 'indexTrash'] )->name( 'idType.trash' );
            Route::get( '/restore/{id}', [IdTypeController::class, 'restore'] )->name( 'idType.restore' );
            Route::delete( '/force-delete/{id}', [IdTypeController::class, 'forceDelete'] )->name( 'idType.forceDelete' );
            Route::delete( '/delete-all', [IdTypeController::class, 'deleteAll'] )->name( 'idType.delete.all' );
        } );

        // ------ Race  -----
        Route::prefix( 'race' )->group( function () {
            Route::get( '/', [RaceController::class, 'index'] )->name( 'race.index' );
            Route::post( '/store', [RaceController::class, 'store'] )->name( 'race.store' );
            Route::get( '/edit/{id}', [RaceController::class, 'edit'] )->name( 'race.edit' );
            Route::post( '/update/{id}', [RaceController::class, 'update'] )->name( 'race.update' );
            Route::delete( '/delete/{id}', [RaceController::class, 'destroy'] )->name( 'race.destroy' );

            Route::get( '/trash', [RaceController::class, 'indexTrash'] )->name( 'race.trash' );
            Route::get( '/restore/{id}', [RaceController::class, 'restore'] )->name( 'race.restore' );
            Route::delete( '/force-delete/{id}', [RaceController::class, 'forceDelete'] )->name( 'race.forceDelete' );
            Route::delete( '/delete-all', [RaceController::class, 'deleteAll'] )->name( 'race.delete.all' );
        } );

        // ------ Provident fund  -----
        Route::prefix( 'provident-fund' )->group( function () {
            Route::get( '/', [ProvidentFundController::class, 'index'] )->name( 'provident.fund.index' );
            Route::post( '/store', [ProvidentFundController::class, 'store'] )->name( 'provident.fund.store' );
            Route::get( '/edit/{id}', [ProvidentFundController::class, 'edit'] )->name( 'provident.fund.edit' );
            Route::post( '/update/{id}', [ProvidentFundController::class, 'update'] )->name( 'provident.fund.update' );
            Route::delete( '/delete/{id}', [ProvidentFundController::class, 'destroy'] )->name( 'provident.fund.destroy' );

            Route::get( '/trash', [ProvidentFundController::class, 'indexTrash'] )->name( 'provident.fund.trash' );
            Route::get( '/restore/{id}', [ProvidentFundController::class, 'restore'] )->name( 'provident.fund.restore' );
            Route::delete( '/force-delete/{id}', [ProvidentFundController::class, 'forceDelete'] )->name( 'provident.fund.forceDelete' );
            Route::delete( '/delete-all', [ProvidentFundController::class, 'deleteAll'] )->name( 'provident.fund.delete.all' );
        } );

        // ------ Employee -----
        Route::prefix( 'employee' )->group( function () {
            Route::get( '/', [EmployeeController::class, 'index'] )->name( 'employee.index' );
            Route::get( '/create', [EmployeeController::class, 'create'] )->name( 'employee.create' );
            Route::post( '/store', [EmployeeController::class, 'store'] )->name( 'employee.store' );
            Route::get( '/edit/{id}', [EmployeeController::class, 'edit'] )->name( 'employee.edit' );
            Route::post( '/update/{id}', [EmployeeController::class, 'update'] )->name( 'employee.update' );
            Route::delete( '/delete/{id}', [EmployeeController::class, 'destroy'] )->name( 'employee.destroy' );
            Route::post( '/change/password/{id}', [EmployeeController::class, 'changePassword'] )->name( 'employee.change.password' );
            Route::post( '/change/email/{id}', [EmployeeController::class, 'changeEmail'] )->name( 'employee.change.email' );

            Route::get( '/trash', [EmployeeController::class, 'indexTrash'] )->name( 'employee.trash' );
            Route::get( '/restore/{id}', [EmployeeController::class, 'restore'] )->name( 'employee.restore' );
            Route::delete( '/force-delete/{id}', [EmployeeController::class, 'forceDelete'] )->name( 'employee.forceDelete' );
            Route::delete( '/delete-all', [EmployeeController::class, 'deleteAll'] )->name( 'employee.delete.all' );

            // ------ Employee additional route -----
            Route::get( '/qualification/{id}', [EmployeeController::class, 'getQualificationData'] )->name( 'employee.edit.qualification.index' );
            Route::get( '/contact/{id}', [EmployeeController::class, 'getContactData'] )->name( 'employee.edit.contact.index' );
            Route::get( '/document/{id}', [EmployeeController::class, 'getDocumentData'] )->name( 'employee.edit.document.index' );
        } );

        // ------ Employee qualification -----
        Route::prefix( 'employee-qualification' )->group( function () {
            Route::get( '/', [EmployeeQualificationController::class, 'index'] )->name( 'employee.qualification.index' );
            Route::post( '/store', [EmployeeQualificationController::class, 'store'] )->name( 'employee.qualification.store' );
            Route::get( '/edit/{id}', [EmployeeQualificationController::class, 'edit'] )->name( 'employee.qualification.edit' );
            Route::post( '/update/{id}', [EmployeeQualificationController::class, 'update'] )->name( 'employee.qualification.update' );
            Route::delete( '/delete/{id}', [EmployeeQualificationController::class, 'destroy'] )->name( 'employee.qualification.destroy' );
        } );

        // ------ Employee contact -----
        Route::prefix( 'employee-contact' )->group( function () {
            Route::get( '/', [EmployeeContactController::class, 'index'] )->name( 'employee.contact.index' );
            Route::post( '/store', [EmployeeContactController::class, 'store'] )->name( 'employee.contact.store' );
            Route::get( '/edit/{id}', [EmployeeContactController::class, 'edit'] )->name( 'employee.contact.edit' );
            Route::post( '/update/{id}', [EmployeeContactController::class, 'update'] )->name( 'employee.contact.update' );
            Route::delete( '/delete/{id}', [EmployeeContactController::class, 'destroy'] )->name( 'employee.contact.destroy' );
        } );

        // ------ Employee document -----
        Route::prefix( 'employee-document' )->group( function () {
            Route::get( '/', [EmployeeDocumentController::class, 'index'] )->name( 'employee.document.index' );
            Route::post( '/store', [EmployeeDocumentController::class, 'store'] )->name( 'employee.document.store' );
            Route::get( '/edit/{id}', [EmployeeDocumentController::class, 'edit'] )->name( 'employee.document.edit' );
            Route::post( '/update/{id}', [EmployeeDocumentController::class, 'update'] )->name( 'employee.document.update' );
            Route::delete( '/delete/{id}', [EmployeeDocumentController::class, 'destroy'] )->name( 'employee.document.destroy' );
        } );

        // ------ Employee export import -----
        Route::prefix( 'employee' )->group( function () {
            Route::get( '/import', [EmployeeExportImportController::class, 'importForm'] )->name( 'employee.import.form' );
            Route::post( '/import/data', [EmployeeExportImportController::class, 'importData'] )->name( 'employee.import.data' );
            Route::get( '/import/sample', [EmployeeExportImportController::class, 'importSample'] )->name( 'employee.import.sample' );
            Route::get( '/export', [EmployeeExportImportController::class, 'export'] )->name( 'employee.export' );
        } );

        //----Addons Route
        Route::get( '/addon/update', [EmployeeAddonUpdateController::class, 'downloadAndUpdate'] )->name( 'employee.addon.update' );

    } );

} );
