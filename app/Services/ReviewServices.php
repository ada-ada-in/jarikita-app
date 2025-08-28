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
            'user_id'    => [
                'label' => 'user_id',
                'rules' => 'required'
            ],
            'layanan_id'       => [
                'label' => 'layanan_id',
                'rules' => 'required'
            ],
            'komentar'   => [
                'label' => 'komentar',
                'rules' => 'required'
            ],
            'rating'   => [
                'label' => 'rating',
                'rules' => 'required|in_list[1,2,3,4,5]'
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
            'user_id'    => $data['user_id'],
            'layanan_id'       => $data['layanan_id'],
            'komentar' => $data['komentar'],
            'rating' => $data['rating']
        ]);


        return [
            'status' => true,
            'message' => 'Insert data success'
        ];

     }


    public function getReviewDataServices()
    {
        
        $ReviewData = new ReviewModel();
        $data = $ReviewData
        ->select('review.*, users.username as username, users.email as email, users.alamat as alamat, users.no_handphone as no_handphone, users.avatar_url as upload_url')
        ->join('users', 'users.id = review.user_id', 'left')
        ->orderBy('created_at', 'DESC')->findAll();

        if(empty($data)){
            return [
                'status'  => true,
                'message' => 'data is empty'
            ];
        }

        return $data;
    }

    public function getRatingDataServices($layanan_id)
    {
        
        $ReviewData = new ReviewModel();
        $data = $ReviewData
        ->select('AVG(rating) as average_rating, COUNT(*) as total_reviews')
        ->where('layanan_id', $layanan_id)
        ->first();


        if(empty($data)){
            return [
                'status'  => true,
                'message' => 'data is empty'
            ];
        }

        return $data;
    }

    public function getReviewDataLayananServices($id)
    {
        
        $ReviewData = new ReviewModel();
        $data = $ReviewData
        ->select('review.*, users.username as username, users.email as email, users.alamat as alamat, users.no_handphone as no_handphone, users.avatar_url as upload_url')
        ->join('users', 'users.id = review.user_id', 'left')
        ->where('layanan_id', $id)
        ->orderBy('created_at', 'DESC')->findAll();

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