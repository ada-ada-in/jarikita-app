<?php
namespace App\Controllers\Api\v1;
use App\Services\LokasiServices;
use CodeIgniter\RESTful\ResourceController;

class LokasiController extends ResourceController {
    protected $lokasiServices;

    public function __construct() {
        $this->lokasiServices = new LokasiServices();
    }

    public function createLokasi(){

        try {
            $data = $this->request->getJSON(true);

            if (empty($data)) {
                return $this->fail([
                    'error' => 'No data received.', 'debug' => $this->request->getBody()
                ]);
            }

            $result = $this->lokasiServices->createLokasiServices($data);

            if ($result['status'] == false) {
                return $this->fail(
                    $result['errors']
                );
            }

            session()->setFlashdata('success', 'Lokasi berhasil ditambahkan!');

            return $this->respondCreated([
                'data' => $data,
                'message' => $result['message']
            ]);

        } catch (\Exception $e) {
            return $this->fail([
                 $e->getMessage()
            ]);
        }
    }

    public function getDataLokasi(){

            try {
                $data = $this->lokasiServices->getLokasiDataServices();
        
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

    public function getDataLokasiById($id){
        try {
    
            $data = $this->lokasiServices->getDataLokasiByIdServices($id);
    
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

    public function deleteDataLokasiById($id){

        try {
    
            $deletedData = $this->lokasiServices->deleteDataLokasiByIdServices($id);

            session()->setFlashdata('success', 'Lokasi berhasil dihapus!');
    
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
    
    public function updateDataLokasiById($id)
    {
        try {
            $data = $this->request->getJSON(true);
    
            if (!$data || empty($data)) {
                return $this->fail([
                    'status'  => false,
                    'message' => 'No data provided for update'
                ], 400);
            }

        
    
            $updatedData = $this->lokasiServices->updateDataByLokasiIdServices($id, $data);

            session()->setFlashdata('success', 'Lokasi berhasil diupdate!');
    
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

    public function countLokasi(){
        try{
            $countData = $this->lokasiServices->countLokasiServices();

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