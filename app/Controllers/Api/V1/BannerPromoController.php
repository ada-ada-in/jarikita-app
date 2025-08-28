<?php
namespace App\Controllers\Api\v1;
use App\Services\BannerPromoServices;
use CodeIgniter\RESTful\ResourceController;

class BannerPromoController extends ResourceController {
    protected $bannerpromoServices;

    public function __construct() {
        $this->bannerpromoServices = new BannerPromoServices();
    }

    public function createBannerPromo(){

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

            if (!$image) {
                return $this->fail([
                    'error' => 'No image uploaded.'
                ], 400);
            }


            $data['image_link'] = 'uploads/' . $imageName;            
            $result = $this->bannerpromoServices->createBannerPromoServices($data);

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

    public function getDataBannerPromo(){

            try {
                $data = $this->bannerpromoServices->getBannerPromoDataServices();
        
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


    public function getDataBannerPromoById($id){
        try {
    
            $data = $this->bannerpromoServices->getDataBannerPromoByIdServices($id);
    
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

    public function deleteDataBannerPromoById($id){

        try {
    
            $deletedData = $this->bannerpromoServices->deleteDataBannerPromoByIdServices($id);

            session()->setFlashdata('success', 'BannerPromo berhasil dihapus!');
    
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
    
    public function updateDataBannerPromoById($id)
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

            $data['image_link'] = 'uploads/' . $imageName;           
            $updatedData = $this->bannerpromoServices->updateDataByBannerPromoIdServices($id, $data);

            session()->setFlashdata('success', 'BannerPromo berhasil diupdate!');
    
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

}
?>