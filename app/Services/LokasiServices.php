<?php
namespace App\Services;
use App\Models\LokasiModel;

class LokasiServices {
    protected $lokasiModel;

    public function __construct()
    {
        $this->lokasiModel = new LokasiModel();
    }



    public function createLokasiServices(array $data){

    $rules = [
            'lokasi'    => [
                'label' => 'lokasi',
                'rules' => 'required|min_length[2]'
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

        $this->lokasiModel->insert([
            'lokasi'    => $data['lokasi']
        ]);


        return [
            'status' => true,
            'message' => 'Insert data success'
        ];

     }


    public function getLokasiDataServices()
    {
        
        $LokasiData = new LokasiModel();
        $data = $LokasiData->orderBy('created_at', 'DESC')->findAll();

        if(empty($data)){
            return [
                'status'  => true,
                'message' => 'data is empty'
            ];
        }

        return $data;
    }

    public function getDataLokasiByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $LokasiData = new LokasiModel();
    
        $data = $LokasiData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'Lokasi not found'
            ];
        }
    
        return $data;
    }

    public function deleteDataLokasiByIdServices($id){
   
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $LokasiData = new LokasiModel();
    
        $data = $LokasiData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'Lokasi not found'
            ];
        }
    
        return $data;

    }

    public function updateDataByLokasiIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $lokasiModel = new LokasiModel();
    
        $existingLokasi = $lokasiModel->find($id);
        if (!$existingLokasi) {
            return [
                'status'  => false,
                'message' => 'Lokasi not found'
            ];
        }

        $updateData = [
            'lokasi'    => $data['lokasi'] ?? $existingLokasi['lokasi'] 
        ];

    
        $lokasiModel->update($id, $updateData);
    
        $updatedLokasi = $lokasiModel->find($id);
    
        return $updatedLokasi;
    }

    public function countLokasiServices(){
        $LokasiData = new LokasiModel();

        $count = $LokasiData->countAllResults();

        return $count;
    
    }

    public function exportPdfLokasis()
    {
        $LokasiData = new LokasiModel();
        return $LokasiData->orderBy('created_at', 'DESC')->findAll();
    } 

    public function exportExcelLokasis()
    {
        $LokasiData = new LokasiModel();
        return $LokasiData->orderBy('created_at', 'DESC')->findAll();
    }  
    
}

?>