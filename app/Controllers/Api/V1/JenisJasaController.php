<?php
namespace App\Controllers\Api\v1;
use App\Services\JenisJasaServices;
use CodeIgniter\RESTful\ResourceController;

class JenisJasaController extends ResourceController {
    protected $jenisjasaservices;

    public function __construct() {
        $this->jenisjasaservices = new JenisJasaServices();
    }

    public function createJenisJasa(){

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

            $data['icon'] = 'uploads/' . $imageName;            
            $result = $this->jenisjasaservices->createJenisJasaServices($data);

            if ($result['status'] == false) {
                return $this->fail(
                    $result['errors']
                );
            }

            session()->setFlashdata('success', 'JenisJasa berhasil ditambahkan!');

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

    public function getDataJenisJasa(){

            try {
                $data = $this->jenisjasaservices->getJenisJasaDataServices();
        
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

    public function getDataJenisJasaById($id){
        try {
    
            $data = $this->jenisjasaservices->getDataJenisJasaByIdServices($id);
    
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

    public function deleteDataJenisJasaById($id){

        try {
    
            $deletedData = $this->jenisjasaservices->deleteDataJenisJasaByIdServices($id);

            session()->setFlashdata('success', 'JenisJasa berhasil dihapus!');
    
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
    
    public function updateDataJenisJasaById($id)
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
            $updatedData = $this->jenisjasaservices->updateDataByJenisJasaIdServices($id, $data);

            session()->setFlashdata('success', 'JenisJasa berhasil diupdate!');
    
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

    public function countJenisJasa(){
        try{
            $countData = $this->jenisjasaservices->countJenisJasaServices();

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

    public function countJenisJasaByUsers(){
        try{
            $countData = $this->jenisjasaservices->countJenisJasaByUsersServices();

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