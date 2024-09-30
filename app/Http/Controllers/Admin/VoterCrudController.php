<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VoterRequest;
use App\Models\Voter;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * Class VoterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VoterCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {store as traitStore;}
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
        CRUD::setModel(\App\Models\Voter::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/voter');
        CRUD::setEntityNameStrings('voter', 'voters');


        //CRUD::addButtonFromView('line', 'approve', 'voters.approve', 'beginning');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::removeButtons(['update']);
        CRUD::column('name');

        CRUD::column([
            'label' => 'Voting Credits',
            'name' => 'voting_credits',
            'type' => 'text',
        ]);


        CRUD::column([
            'label' => 'QR Code',
            'name' => 'qr_code',
            'type' => 'image',
            'disk' => 'public', 
            'height' => '50px', // Adjust height as needed
            'width' => '50px',  // Adjust width as needed
        ]);


        // CRUD::setFromDb(); 

    }

    protected function setupShowOperation()
    {

        CRUD::removeButtons(['update']);
        CRUD::column('name');

        CRUD::column([
            'label' => 'Voting Credits',
            'name' => 'voting_credits',
            'type' => 'text',
        ]);


        CRUD::column([
            'label' => 'QR Code',
            'name' => 'qr_code',
            'type' => 'image',
            'disk' => 'public', 
            'height' => '200px', // Adjust height as needed
            'width' => '200px',  // Adjust width as needed
        ]);


        // CRUD::setFromDb(); 

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(VoterRequest::class);
        // CRUD::setFromDb(); // set fields from db columns.

        CRUD::field('name');


    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function requestAccountActivation(Request $request)
    {
        $user = auth()->user();

        try {
            $voter = Voter::create([
                'user_id' => $user->id,
                'voting_credits' => env('VOTING_CREDITS')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Voter record created successfully',
                'voter' => $voter,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create voter record.',
                'error' => $th->getMessage(), // You might want to log this instead of returning it in production
            ], 500);
        }


        return response($user);

    }

    public function activateVoter($voterId)
    {   
        $voter = Voter::findOrFail($voterId);

        if($voter) {

            $qrCodeContent = QrCode::size(500)->generate(route('pamcham.voting-ballot', ['uuid' => $voter->uuid]));
            $filePath = "qrcodes/user-{$voter->id}.svg";

            \Storage::disk('public')->put($filePath, $qrCodeContent);

            $voter->update([
                'is_activated' => 1,
                'qr_code' => $filePath
            ]);

            \Alert::success("Successfully Approved")->flash();
            return back();
        }

        \Alert::error("Error Approving")->flash();
        return back();
        
    }
    public function store()
    {
        $this->crud->validateRequest();
        $response = $this->traitStore();
        
        $voter = $this->crud->entry;
        $qrCodeContent = \QrCode::size(500)->generate(route('pamcham.voting-ballot', ['uuid' => $voter->uuid]));
        
        $filePath = "qrcodes/user-{$voter->id}.svg";
        
        \Storage::disk('public')->put($filePath, $qrCodeContent);
    
        // Update the voter with the QR code path
        $voter->update([
            'qr_code' => $filePath,
            'voting_credits' => env('VOTING_CREDITS')
        ]);
    
        // Return the original response
        return $response;
    }
    
    
    


}
