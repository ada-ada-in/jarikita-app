<?php
namespace App\Services;
use App\Models\UsersModel;



class AuthServices {
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
    }

    public function registerServices(array $data){

    $rules = [
            'username'    => [
                'label' => 'username',
                'rules' => 'required|min_length[2]'
            ],
            'email'       => [
                'label' => 'email',
                'rules' => 'required|valid_email|is_unique[users.email]'
            ],
            'alamat' => [
                'label' => 'alamat',
                'rules' => 'required|min_length[3]'
            ],
            'no_handphone'   => [
                'label' => 'no_handphone',
                'rules' => 'required|min_length[12]'
            ],
            'role'   => [
                'label' => 'role',
                'rules' => 'permit_empty|min_length[2]'
            ],
            'password'    => [
                'label' => 'password',
                'rules' => 'required|min_length[6]'
                ],
                'confirm_password' => [
                'label' => 'confirm_password',
                'rules' => 'required|matches[password]'
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

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        if(empty($data['role'])){
            $data['role'] = 'user';
        }

        $this->userModel->insert([
            'username'    => $data['username'],
            'email'       => $data['email'],
            'alamat'    => $data['alamat'],
            'no_handphone' => $data['no_handphone'],
            'avatar_url'   => $data['avatar_url'],
            'role'   => $data['role'],
            'password'   => $data['password'],
        ]);


        return [
            'status' => true,
            'message' => 'user register success'
        ];

     }


     public function loginServices(array $data){

        $email = $data['email'] ;
        $password = $data['password'];

        if(empty($email) || empty($password)){
            return [
                'status'  => false,
                'message' => 'Email or password cannot be empty'
            ];
        }

        $userModel = new UsersModel();
        $user = $userModel->where('email', $email)->first();

        if(!$user){
            return [
                'status' => false,
                'message' => 'user not found'
            ];
        }

        if (password_verify($password, $user['password'])) {
            session()->set([
                'id' => $user['id'],
                'role' => $user['role'],
                'email' => $user['email'],
                'no_handphone' => $user['no_handphone'],
                'isLoggedIn' => true
            ]); 

            return [
                'status'  => true,
                'message' => 'Login successful',
                'role' => $user['role'],
                'id' => $user['id'],
                'email' => $user['email'],
                'no_handphone' => $user['no_handphone']
            ];
            
        } else {
            return [
                'status' => false,
                'message' => 'email or password incorrect'
            ];
        } 


     }

     

}


?>