<?php
namespace App\Services;
use App\Models\JenisJasaModel;

class JenisJasaServices {
    protected $jenisjasamodel;

    public function __construct()
    {
        $this->jenisjasamodel = new JenisJasaModel();
    }



    public function createJenisJasaServices(array $data){

    $rules = [
            'nama_jenisjasa'   => [
                'label' => 'nama_jenisjasa',
                'rules' => 'required'
            ],
            'icon'   => [
                'label' => 'icon',
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

        $this->jenisjasamodel->insert([
            'nama_jenisjasa'    => $data['nama_jenisjasa'],
            'icon'       => $data['icon']
        ]);


        return [
            'status' => true,
            'message' => 'Insert data success'
        ];

     }


    public function getJenisJasaDataServices()
    {
        
        $JenisJasaData = new JenisJasaModel();
        $data = $JenisJasaData
        ->orderBy('created_at', 'DESC')->findAll();

        if(empty($data)){
            return [
                'status'  => true,
                'message' => 'data is empty'
            ];
        }

        return $data;
    }

    

    public function getDataJenisJasaByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $JenisJasaData = new JenisJasaModel();
    
        $data = $JenisJasaData
        ->orderBy('created_at', 'DESC')
        ->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'JenisJasa not found'
            ];
        }
    
        return $data;
    }

    public function deleteDataJenisJasaByIdServices($id){
   
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $JenisJasaData = new JenisJasaModel();

        $layanan = $JenisJasaData->find($id);

        $imagePath = FCPATH . $layanan['icon']; 
         if (file_exists($imagePath) && is_file($imagePath)) {
             unlink($imagePath);
         }
    
        $data = $JenisJasaData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'JenisJasa not found'
            ];
        }
    
        return $data;

    }

    public function updateDataByJenisJasaIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $jenisjasamodel = new JenisJasaModel();
    
        $existingJenisJasa = $jenisjasamodel->find($id);
        if (!$existingJenisJasa) {
            return [
                'status'  => false,
                'message' => 'JenisJasa not found'
            ];
        }

        $updateData = [
            'nama_jenisjasa'    => $data['nama_jenisjasa'] ?? $existingJenisJasa['nama_jenisjasa'],
            'icon'   => $data['icon'] ?? $existingJenisJasa['icon']
        ];

    
        $jenisjasamodel->update($id, $updateData);
    
        $updatedJenisJasa = $jenisjasamodel->find($id);
    
        return $updatedJenisJasa;
    }

    public function countJenisJasaServices(){
        $JenisJasaData = new JenisJasaModel();

        $count = $JenisJasaData->countAllResults();

        return $count;
    
    }

    public function countJenisJasaByUsersServices(){
        $JenisJasaData = new JenisJasaModel();

        $count = $JenisJasaData
        ->where('user_id', session()->get('id'))
        ->countAllResults();

        return $count;
    
    }

    public function exportPdfJenisJasas()
    {
        $JenisJasaData = new JenisJasaModel();
        return $JenisJasaData->orderBy('created_at', 'DESC')->findAll();
    } 

    public function exportExcelJenisJasas()
    {
        $JenisJasaData = new JenisJasaModel();
        return $JenisJasaData->orderBy('created_at', 'DESC')->findAll();
    }  
    
}

?>