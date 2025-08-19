<?php
namespace App\Services;
use App\Models\UsersModel;

class UsersServices {
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
    }


    public function getUserDataServices()
    {
        
        $userData = new UsersModel();
        $data = $userData->orderBy('created_at', 'DESC')->findAll();

        if(empty($data)){
            return [
                'status'  => true,
                'message' => 'data is empty'
            ];
        }

        return $data;
    }

    public function getUserProfileDataServices()
    {
        
        $userData = new UsersModel();
        $data = $userData->orderBy('created_at', 'DESC')
        ->where('id', session()->get('id'))
        ->find();

        if(empty($data)){
            return [
                'status'  => true,
                'message' => 'data is empty'
            ];
        }

        return $data;
    }
    

    public function getDataUserByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $userData = new UsersModel();
    
        $data = $userData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
    }

    public function getDataUserProfileByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $userData = new UsersModel();
    
        $data = $userData->find(session()->get('id'));
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
    }

    public function deleteDataUserByIdServices($id){
   
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $userData = new UsersModel();

        $user = $userData->find($id);

        $imagePath = FCPATH . $user['avatar_url']; 
         if (file_exists($imagePath) && is_file($imagePath)) {
             unlink($imagePath);
         }
    
        $data = $userData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;

    }

    public function updateDataByUserIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $userModel = new UsersModel();
    
        $existingUser = $userModel->find($id);
        if (!$existingUser) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }

    
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            $data['password'] = $existingUser['password'];
        }
    
        $updateData = [
            'username'    => $data['username'] ?? $existingUser['username'],
            'email'   => $data['email'] ?? $existingUser['email'],
            'no_handphone'   => $data['no_handphone'] ?? $existingUser['no_handphone'],
            'avatar_url' => $data['avatar_url'] ?? $existingUser['avatar_url'],
            'role'    => $data['role'] ?? $existingUser['role'],
            'alamat'    => $data['alamat'] ?? $existingUser['alamat'],
            'password'=> $data['password'] ?? $existingUser['password'],
        ];

    
        $userModel->update($id, $updateData);
    
        $updatedUser = $userModel->find($id);
    
        return $updatedUser;
    }

    public function countUserServices(){
        $userData = new UsersModel();

        $count = $userData->countAllResults();

        return $count;
    
    }


    public function exportPdfUsers()
    {
        $userData = new UsersModel();
        return $userData->orderBy('created_at', 'DESC')->findAll();
    } 

    public function exportExcelUsers()
    {
        $userData = new UsersModel();
        return $userData->orderBy('created_at', 'DESC')->findAll();
    }  
    
}

?>