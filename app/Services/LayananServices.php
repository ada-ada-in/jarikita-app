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
            'user_id'    => [
                'label' => 'user_id',
                'rules' => 'required'
            ],
            'lokasi_id'    => [
                'label' => 'lokasi_id',
                'rules' => 'required'
            ],
            'nama_jasa'   => [
                'label' => 'nama_jasa',
                'rules' => 'required'
            ],
            'bidang_jasa'   => [
                'label' => 'bidang_jasa',
                'rules' => 'required'
            ],
            'alamat'   => [
                'label' => 'alamat',
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
            'user_id'    => $data['user_id'],
            'lokasi_id'       => $data['lokasi_id'],
            'nama_jasa' => $data['nama_jasa'],
            'bidang_jasa' => $data['bidang_jasa'],
            'alamat' => $data['alamat'],
            'image_url' => $data['image_url'],
            'deskripsi' => $data['deskripsi'],
            'discount' => $data['discount']
        ]);


        return [
            'status' => true,
            'message' => 'Insert data success'
        ];

     }


    public function getLayananDataServices()
    {
        
        $LayananData = new LayananJasaModel();
        $data = $LayananData
        ->select('layanan_jasa.*, users.username as username_user, users.email as email_user, users.alamat as alamat_user, users.no_handphone as no_handphone_user, users.nopp as nopp_user, users.bpjs_status_pembayaran as bpjs_status_pembayaran_user, users.bpjs_pembayaran as bpjs_pembayaran_user')
        ->join('users', 'users.id = layanan_jasa.user_id', 'left')
        ->select('layanan_jasa.*, lokasi.lokasi as nama_lokasi')
        ->join('lokasi', 'lokasi.id = layanan_jasa.lokasi_id', 'left')
        ->orderBy('created_at', 'DESC')->findAll();

        if(empty($data)){
            return [
                'status'  => true,
                'message' => 'data is empty'
            ];
        }

        return $data;
    }


    public function getLayananDataByUsersServices()
    {
        
        $LayananData = new LayananJasaModel();
        $data = $LayananData
        ->select('layanan_jasa.*, users.username as username_user, users.email as email_user, users.alamat as alamat_user, users.no_handphone as no_handphone_user')
        ->join('users', 'users.id = layanan_jasa.user_id', 'left')
        ->select('layanan_jasa.*, lokasi.lokasi as nama_lokasi')
        ->join('lokasi', 'lokasi.id = layanan_jasa.lokasi_id', 'left')
        ->orderBy('created_at', 'DESC')
        ->where('layanan_jasa.user_id', session()->get('id'))
        ->findAll();

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
    
        $data = $LayananData
        ->select('layanan_jasa.*, users.username as username_user, users.email as email_user, users.alamat as alamat_user, users.no_handphone as no_handphone_user')
        ->join('users', 'users.id = layanan_jasa.user_id', 'left')
        ->select('layanan_jasa.*, lokasi.lokasi as nama_lokasi')
        ->join('lokasi', 'lokasi.id = layanan_jasa.lokasi_id', 'left')
        ->orderBy('created_at', 'DESC')
        ->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'Layanan not found'
            ];
        }
    
        return $data;
    }

    public function getDataLayananByLokasiIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $LayananData = new LayananJasaModel();
    
        $data = $LayananData
        ->select('layanan_jasa.*, users.username as username_user, users.email as email_user, users.alamat as alamat_user, users.no_handphone as no_handphone_user')
        ->join('users', 'users.id = layanan_jasa.user_id', 'left')
        ->select('layanan_jasa.*, lokasi.lokasi as nama_lokasi')
        ->join('lokasi', 'lokasi.id = layanan_jasa.lokasi_id', 'left')
        ->orderBy('created_at', 'DESC')
        ->where('lokasi_id', $id)
        ->findAll();
    
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

        $layanan = $LayananData->find($id);

        $imagePath = FCPATH . $layanan['image_url']; 
         if (file_exists($imagePath) && is_file($imagePath)) {
             unlink($imagePath);
         }
    
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
            'user_id'    => $data['user_id'] ?? $existingLayanan['user_id'],
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

        $count = $LayananData->countAllResults();

        return $count;
    
    }

    public function countLayananByUsersServices(){
        $LayananData = new LayananJasaModel();

        $count = $LayananData
        ->where('user_id', session()->get('id'))
        ->countAllResults();

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