<?php
namespace App\Services;
use App\Models\ReviewModel;

class ReviewServices {
    protected $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
    }



    public function createReviewServices(array $data){

    $rules = [
            'users_id'    => [
                'label' => 'users_id',
                'rules' => 'required'
            ],
            'layanan_id'       => [
                'label' => 'layanan_id',
                'rules' => 'required'
            ],
            'komentar'   => [
                'label' => 'komentar',
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

        $this->reviewModel->insert([
            'users_id'    => $data['users_id'],
            'layanan_id'       => $data['layanan_id'],
            'komentar' => $data['komentar']
        ]);


        return [
            'status' => true,
            'message' => 'Insert data success'
        ];

     }


    public function getReviewDataServices()
    {
        
        $ReviewData = new ReviewModel();
        $data = $ReviewData->orderBy('created_at', 'DESC')->findAll();

        if(empty($data)){
            return [
                'status'  => true,
                'message' => 'data is empty'
            ];
        }

        return $data;
    }

    public function getDataReviewByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $ReviewData = new ReviewModel();
    
        $data = $ReviewData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'Review not found'
            ];
        }
    
        return $data;
    }

    public function deleteDataReviewByIdServices($id){
   
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $ReviewData = new ReviewModel();
    
        $data = $ReviewData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'Review not found'
            ];
        }
    
        return $data;

    }

    public function updateDataByReviewIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $reviewModel = new ReviewModel();
    
        $existingReview = $reviewModel->find($id);
        if (!$existingReview) {
            return [
                'status'  => false,
                'message' => 'Review not found'
            ];
        }

        $updateData = [
            'users_id'    => $data['users_id'] ?? $existingReview['users_id'],
            'layanan_id'   => $data['layanan_id'] ?? $existingReview['layanan_id'],
            'komentar'   => $data['komentar'] ?? $existingReview['komentar']
        ];

    
        $reviewModel->update($id, $updateData);
    
        $updatedReview = $reviewModel->find($id);
    
        return $updatedReview;
    }

    public function countReviewServices(){
        $ReviewData = new ReviewModel();

        $count = $ReviewData->where('role', 'Review')->countAllResults();

        return $count;
    
    }

    public function exportPdfReviews()
    {
        $ReviewData = new ReviewModel();
        return $ReviewData->orderBy('created_at', 'DESC')->findAll();
    } 

    public function exportExcelReviews()
    {
        $ReviewData = new ReviewModel();
        return $ReviewData->orderBy('created_at', 'DESC')->findAll();
    }  
    
}

?>