<?php
namespace App\Services;
use App\Models\BannerPromoModel;

class BannerPromoServices {
    protected $bannerPromoModel;

    public function __construct()
    {
        $this->bannerPromoModel = new BannerPromoModel();
    }



    public function createBannerPromoServices(array $data){

    $rules = [
            'image_link'    => [
                'label' => 'image_link',
                'rules' => 'required'
            ]
        ];

        $validation = \Config\Services::validation();
        $validation->setRules($rules);

        if(!$validation->run($data)){
            return [
                'status' => false,
                'errors' => $validation->getErrors()
            ];
        }

        $this->bannerPromoModel->insert([
            'image_link'    => $data['image_link']
        ]);


        return [
            'status' => true,
            'message' => 'Insert data success'
        ];

     }


    public function getBannerPromoDataServices()
    {
        
        $BannerPromoData = new BannerPromoModel();
        $data = $BannerPromoData
        ->orderBy('created_at', 'DESC')->findAll();

        if(empty($data)){
            return [
                'status'  => true,
                'message' => 'data is empty'
            ];
        }

        return $data;
    }



    

    public function getDataBannerPromoByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $BannerPromoData = new BannerPromoModel();
    
        $data = $BannerPromoData
        ->orderBy('created_at', 'DESC')
        ->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'BannerPromo not found'
            ];
        }
    
        return $data;
    }

    public function deleteDataBannerPromoByIdServices($id){
   
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $BannerPromoData = new BannerPromoModel();

        $layanan = $BannerPromoData->find($id);

        $imagePath = FCPATH . $layanan['image_link']; 
         if (file_exists($imagePath) && is_file($imagePath)) {
             unlink($imagePath);
         }
    
        $data = $BannerPromoData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'BannerPromo not found'
            ];
        }
    
        return $data;

    }

    public function updateDataByBannerPromoIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $bannerPromoModel = new BannerPromoModel();
    
        $existingBannerPromo = $bannerPromoModel->find($id);
        if (!$existingBannerPromo) {
            return [
                'status'  => false,
                'message' => 'BannerPromo not found'
            ];
        }

        $updateData = [
            'image_link'    => $data['image_link'] ?? $existingBannerPromo['image_link'],
        ];

    
        $bannerPromoModel->update($id, $updateData);
    
        $updatedBannerPromo = $bannerPromoModel->find($id);
    
        return $updatedBannerPromo;
    }
    
}

?>