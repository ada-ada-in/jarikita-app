<?php
namespace App\Controllers\Api\v1;
use App\Services\LayananServices;
use CodeIgniter\RESTful\ResourceController;

class LayananController extends ResourceController {
    protected $layananServices;

    public function __construct() {
        $this->layananServices = new LayananServices();
    }

    public function createLayanan(){

        try {

            $image = $this->request->getFile('image');
            $data = $this->request->getPost();

            if (!$image->isValid()) {
                return $this->fail([
                    'error' => 'Invalid file.',
                    'debug' => $image->getError()
                ], 400);
            }

            if (!file_exists($image->getTempName())) {
                return $this->fail([
                    'error' => 'Temporary file missing.',
                    'debug' => $image->getTempName()
                ], 400);
            }

            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/', $imageName);

            if (empty($data)) {
                return $this->fail([
                    'error' => 'No data received.', 'debug' => $this->request->getBody()
                ]);
            }

            $data['image_url'] = 'uploads/' . $imageName;            
            $result = $this->layananServices->createLayananServices($data);

            if ($result['status'] == false) {
                return $this->fail(
                    $result['errors']
                );
            }

            session()->setFlashdata('success', 'Layanan berhasil ditambahkan!');

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

    public function getDataLayanan(){

            try {
                $data = $this->layananServices->getLayananDataServices();
        
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

    public function getDataLayananById($id){
        try {
    
            $data = $this->layananServices->getDataLayananByIdServices($id);
    
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

    public function deleteDataLayananById($id){

        try {
    
            $deletedData = $this->layananServices->deleteDataLayananByIdServices($id);

            session()->setFlashdata('success', 'Layanan berhasil dihapus!');
    
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
    
    public function updateDataLayananById($id)
    {
        try {
            $image = $this->request->getFile('image');
            $data = $this->request->getPost();

            if (!$image->isValid()) {
                return $this->fail([
                    'error' => 'Invalid file.',
                    'debug' => $image->getError()
                ], 400);
            }

            if (!file_exists($image->getTempName())) {
                return $this->fail([
                    'error' => 'Temporary file missing.',
                    'debug' => $image->getTempName()
                ], 400);
            }

            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/', $imageName);

            if (empty($data)) {
                return $this->fail([
                    'error' => 'No data received.', 'debug' => $this->request->getBody()
                ]);
            }

            $data['image_url'] = 'uploads/' . $imageName;           
            $updatedData = $this->layananServices->updateDataByLayananIdServices($id, $data);

            session()->setFlashdata('success', 'Layanan berhasil diupdate!');
    
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

    public function countLayanan(){
        try{
            $countData = $this->layananServices->countLayananServices();

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