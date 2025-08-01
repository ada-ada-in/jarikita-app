<?php
namespace App\Services;
use App\Models\LayananJasaModel;

class LayananServices {
    protected $layananJasaModel;

    public function __construct()
    {
        $this->layananJasaModel = new LayananJasaModel();
    }



    public function createLayananServices(array $data){

    $rules = [
            'users_id'    => [
                'label' => 'users_id',
                'rules' => 'required|min_length[11]'
            ],
            'lokasi_id'    => [
                'label' => 'lokasi_id',
                'rules' => 'required|min_length[11]'
            ],
            'nama_jasa'   => [
                'label' => 'nama_jasa',
                'rules' => 'required'
            ],
            'alamat'   => [
                'label' => 'alamat',
                'rules' => 'required'
            ],
            'image_url'   => [
                'label' => 'image_url',
                'rules' => 'required'
            ],
            'deskripsi'   => [
                'label' => 'deskripsi',
                'rules' => 'required'
            ],
        ];

        $validation = \Config\Services::validation();
        $validation->setRules($rules);

        if(!$validation->run($data)){
            return [
                'status' => false,
                'errors' => $validation->getErrors()
            ];
        }

        $this->layananJasaModel->insert([
            'users_id'    => $data['users_id'],
            'lokasi_id'       => $data['lokasi_id'],
            'nama_jasa' => $data['nama_jasa'],
            'alamat' => $data['alamat'],
            'image_url' => $data['image_url'],
            'deskripsi' => $data['deskripsi']
        ]);


        return [
            'status' => true,
            'message' => 'Insert data success'
        ];

     }


    public function getLayananDataServices()
    {
        
        $LayananData = new LayananJasaModel();
        $data = $LayananData->orderBy('created_at', 'DESC')->findAll();

        if(empty($data)){
            return [
                'status'  => true,
                'message' => 'data is empty'
            ];
        }

        return $data;
    }

    public function getDataLayananByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $LayananData = new LayananJasaModel();
    
        $data = $LayananData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'Layanan not found'
            ];
        }
    
        return $data;
    }

    public function deleteDataLayananByIdServices($id){
   
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $LayananData = new LayananJasaModel();
    
        $data = $LayananData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'Layanan not found'
            ];
        }
    
        return $data;

    }

    public function updateDataByLayananIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $layananJasaModel = new LayananJasaModel();
    
        $existingLayanan = $layananJasaModel->find($id);
        if (!$existingLayanan) {
            return [
                'status'  => false,
                'message' => 'Layanan not found'
            ];
        }

        $updateData = [
            'users_id'    => $data['users_id'] ?? $existingLayanan['users_id'],
            'lokasi_id'   => $data['lokasi_id'] ?? $existingLayanan['lokasi_id'],
            'nama_jasa'   => $data['nama_jasa'] ?? $existingLayanan['nama_jasa'],
            'alamat'   => $data['alamat'] ?? $existingLayanan['alamat'],
            'image_url'   => $data['image_url'] ?? $existingLayanan['image_url'],
            'deskripsi'   => $data['deskripsi'] ?? $existingLayanan['deskripsi']
        ];

    
        $layananJasaModel->update($id, $updateData);
    
        $updatedLayanan = $layananJasaModel->find($id);
    
        return $updatedLayanan;
    }

    public function countLayananServices(){
        $LayananData = new LayananJasaModel();

        $count = $LayananData->where('role', 'Layanan')->countAllResults();

        return $count;
    
    }

    public function exportPdfLayanans()
    {
        $LayananData = new LayananJasaModel();
        return $LayananData->orderBy('created_at', 'DESC')->findAll();
    } 

    public function exportExcelLayanans()
    {
        $LayananData = new LayananJasaModel();
        return $LayananData->orderBy('created_at', 'DESC')->findAll();
    }  
    
}

?>