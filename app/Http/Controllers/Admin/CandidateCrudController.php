<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CandidateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CandidateCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CandidateCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Candidate::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/candidate');
        CRUD::setEntityNameStrings('candidate', 'candidates');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('company');
        CRUD::column([
            'name' => 'position',
            'type' => 'text',
            'label' => 'Position in the BOD &/or Committee'
        ]);

        CRUD::column([
            'name' => 'image',
            'type' => 'image',
            'label' => 'Image',
            'disk' => 'public',
        ]);

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CandidateRequest::class);
        CRUD::field('name');
        CRUD::field('company');
        CRUD::field([
            'name' => 'position',
            'type' => 'text',
            'label' => 'Position in the BOD &/or Committee'
        ]);

        CRUD::field('image')
            ->type('upload')
            ->withFiles([
                'disk' => 'public', // the disk where file will be stored
                'path' => 'uploads', // the path inside the disk where file will be stored
        ]);
        
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */

    protected function setupShowOperation()
    {
        CRUD::column('name');
        CRUD::column('company');
        CRUD::column([
            'name' => 'position',
            'type' => 'text',
            'label' => 'Position in the BOD &/or Committee'
        ]);

        CRUD::column([
            'name' => 'image',
            'type' => 'image',
            'label' => 'Image',
            'disk' => 'public',
        ]);

    }
    
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
