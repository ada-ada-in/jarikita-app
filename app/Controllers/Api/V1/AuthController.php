<?php
namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;
use App\Services\AuthServices;

class AuthController extends ResourceController {

    
    protected $registerServices;

    public function __construct()
    {
        $this->registerServices = new AuthServices();
    }

    public function register(){
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

            $data['avatar_url'] = 'uploads/' . $imageName;            
            $result = $this->registerServices->registerServices($data);
        
            if ($result['status'] == false) {
                return $this->fail(
                    $result['errors']
                );
            }

            session()->setFlashdata('success', 'User berhasil ditambahkan!');

    
            return $this->respondCreated([
                'data' => $data,
                'file_name' => $imageName,
                'message' => $result['message']
            ]);
    
        } catch (\Exception $e) {
            return $this->fail([
                 $e->getMessage()
            ]);
        }
    }


    public function login() {
        try {
            
            $data = $this->request->getJSON(true);

    
            if (empty($data)) {
                return $this->fail([
                    'error' => 'No data received.', 'debug' => $this->request->getBody()
                ]);
            }

            $result = $this->registerServices->loginServices($data);

            

            if ($result['status'] == false) {
                return $this->fail(
                    $result['message']
                );
            }

            session()->setFlashdata('success', 'Login berhasil!');
            
    
            return $this->respondCreated([
                'data' => $data,
                'message' => $result['message'],
                'role' => $result['role'],
                'id' => $result['id']
            ]);

        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());

            return $this->failServerError($e->getMessage());
        }
    }

    public function logout() {
        session()->destroy();
        return $this->respond([
            'status' => 'success',
            'message' => 'Logout berhasil'
        ]);
        return redirect()->to('/');
    }
}
?>
