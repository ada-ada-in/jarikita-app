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

            $imageName = null;
            if ($image !== null && $image->isValid() && file_exists($image->getTempName())) {
                $imageName = $image->getRandomName();
                $image->move(FCPATH . 'uploads/', $imageName);
            }

            if (empty($data)) {
                return $this->fail([
                    'error' => 'No data received.', 'debug' => $this->request->getBody()
                ]);
            }

            $data['avatar_url'] = $imageName ? 'uploads/' . $imageName : null;
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
            
    
            return $this->respondCreated([
                'data' => $data,
                'message' => $result['message'],
                'role' => $result['role'],
                'id' => $result['id'],
                'username' => $result['username'],
                'avatar_url' => $result['avatar_url'],
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
