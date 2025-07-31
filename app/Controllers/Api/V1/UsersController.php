<?php
namespace App\Controllers\Api\v1;
use App\Services\UsersServices;
use CodeIgniter\RESTful\ResourceController;

class UsersController extends ResourceController {
    protected $userServices;

    public function __construct() {
        $this->userServices = new UsersServices();
    }

        public function getDataUser(){

            try {
                $data = $this->userServices->getUserDataServices();
        
                return $this->respond([
                    'data' => $data,
                    'message' => 'Data retrieved successfully'
                ], 200);
        
            } catch (\Exception $e) {
                return $this->fail([
                    $e->getMessage()
                ]);
            }
        }

    public function getDataUserProfile(){

        try {
            $data = $this->userServices->getUserProfileDataServices();
    
            return $this->respond([
                'data' => $data,
                'message' => 'Data retrieved successfully'
            ], 200);
    
        } catch (\Exception $e) {
            return $this->fail([
                 $e->getMessage()
            ]);
        }
    } 
    

    public function getDataUserById($id){
        try {
    
            $data = $this->userServices->getDataUserByIdServices($id);
    
            return $this->respond([
                'status'  => true,
                'data'    => $data,
                'message' => 'Data retrieved successfully'
            ], 200);
    
        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getDataUserProfileById($id){
        try {
    
            $data = $this->userServices->getDataUserProfileByIdServices($id);
    
            return $this->respond([
                'status'  => true,
                'data'    => $data,
                'message' => 'Data retrieved successfully'
            ], 200);
    
        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteDataUserById($id){

        try {
    
            $deletedData = $this->userServices->deleteDataUserByIdServices($id);

            session()->setFlashdata('success', 'User berhasil dihapus!');
    
            return $this->respondDeleted([
                'status'  => true,
                'data'    => $deletedData,
                'message' => 'Data deleted successfully'
            ]);
    
        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
        
    }
    
    public function updateDataUserById($id)
    {
        try {
            $data = $this->request->getJSON(true);
    
            if (!$data || empty($data)) {
                return $this->fail([
                    'status'  => false,
                    'message' => 'No data provided for update'
                ], 400);
            }

        
    
            $updatedData = $this->userServices->updateDataByUserIdServices($id, $data);

            session()->setFlashdata('success', 'User berhasil diupdate!');
    
            return $this->respondUpdated([
                'status'  => true,
                'data'    => $updatedData,
                'message' => 'Data updated successfully'
            ]);
    
        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function countUser(){
        try{
            $countData = $this->userServices->countUserServices();

            return $this->respondCreated([
                'status' => true,
                'data' => $countData,
                'message' => 'Data retrieved succesfully'
            ]);

        }catch(\Exception $e){
            return $this->fail([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }
    
}
?>