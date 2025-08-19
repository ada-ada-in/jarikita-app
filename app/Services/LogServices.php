<?php
namespace App\Services;
use App\Models\LogModel;

class LogServices {
    protected $logModel;

    public function __construct()
    {
        $this->logModel = new LogModel();
    }



    public function createLogServices(array $data){

    $rules = [
            'deskripsi'    => [
                'label' => 'deskripsi',
                'rules' => 'required'
            ],
            'no_handphone'   => [
                'label' => 'no_handphone',
                'rules' => 'required'
            ],
            'email'   => [
                'label' => 'email',
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

        $this->logModel->insert([
            'deskripsi'    => $data['deskripsi'],
            'email'       => $data['email'],
            'no_handphone' => $data['no_handphone']
        ]);


        return [
            'status' => true,
            'message' => 'Insert data success'
        ];

     }


    public function getLogDataServices()
    {
        
        $LogData = new LogModel();
        $data = $LogData->orderBy('created_at', 'DESC')->findAll();

        if(empty($data)){
            return [
                'status'  => true,
                'message' => 'data is empty'
            ];
        }

        return $data;
    }

    public function getDataLogByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $LogData = new LogModel();
    
        $data = $LogData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'Log not found'
            ];
        }
    
        return $data;
    }

    public function deleteDataLogByIdServices($id){
   
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $LogData = new LogModel();
    
        $data = $LogData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'Log not found'
            ];
        }
    
        return $data;

    }

    public function updateDataByLogIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $logModel = new LogModel();
    
        $existingLog = $logModel->find($id);
        if (!$existingLog) {
            return [
                'status'  => false,
                'message' => 'Log not found'
            ];
        }

        $updateData = [
            'deskripsi'    => $data['deskripsi'] ?? $existingLog['deskripsi'],
            'email'   => $data['email'] ?? $existingLog['email'],
            'no_handphone'   => $data['no_handphone'] ?? $existingLog['no_handphone']
        ];

    
        $logModel->update($id, $updateData);
    
        $updatedLog = $logModel->find($id);
    
        return $updatedLog;
    }

    public function countLogServices(){
        $LogData = new LogModel();

        $count = $LogData->countAllResults();

        return $count;
    
    }

    public function exportPdfLogs()
    {
        $LogData = new LogModel();
        return $LogData->orderBy('created_at', 'DESC')->findAll();
    } 

    public function exportExcelLogs()
    {
        $LogData = new LogModel();
        return $LogData->orderBy('created_at', 'DESC')->findAll();
    }  
    
}

?>