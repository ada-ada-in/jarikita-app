<?php
namespace App\Controllers\Api\v1;

use App\Services\ChatServices;
use CodeIgniter\RESTful\ResourceController;

class ChatController extends ResourceController
{
    protected $chatServices;

    public function __construct()
    {
        $this->chatServices = new ChatServices();
    }

    public function startConversation()
    {
        try {
            $senderId = session()->get('id');
            $receiverId = $this->request->getPost('receiver_id');
            $layananId = $this->request->getPost('layanan_id');

            if (!$senderId) {
                return $this->fail(['status' => false, 'message' => 'Not authenticated'], 401);
            }

            if (!$receiverId) {
                return $this->fail(['status' => false, 'message' => 'Receiver ID is required'], 400);
            }

            $conversation = $this->chatServices->createConversation($senderId, $receiverId, $layananId);

            return $this->respond([
                'status' => true,
                'data' => $conversation,
                'message' => 'Conversation started',
            ], 200);
        } catch (\Exception $e) {
            log_message('error', '[Chat] startConversation: ' . $e->getMessage());
            return $this->fail(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function sendMessage()
    {
        try {
            $senderId = session()->get('id');
            $conversationId = $this->request->getPost('conversation_id');
            $message = $this->request->getPost('message');

            if (!$senderId) {
                return $this->fail(['status' => false, 'message' => 'Not authenticated'], 401);
            }

            $result = $this->chatServices->sendMessage($conversationId, $senderId, $message);

            if (!$result['status']) {
                return $this->fail($result, 400);
            }

            return $this->respondCreated([
                'status' => true,
                'data' => $result['data'],
                'message' => 'Message sent',
            ]);
        } catch (\Exception $e) {
            log_message('error', '[Chat] sendMessage: ' . $e->getMessage());
            return $this->fail(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getMessages($conversationId)
    {
        try {
            $userId = session()->get('id');

            if (!$userId) {
                return $this->fail(['status' => false, 'message' => 'Not authenticated'], 401);
            }

            $result = $this->chatServices->getMessages($conversationId, $userId);

            if (!$result['status']) {
                return $this->fail($result, 403);
            }

            return $this->respond([
                'status' => true,
                'data' => $result['data'],
            ], 200);
        } catch (\Exception $e) {
            return $this->fail(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getConversations()
    {
        try {
            $userId = session()->get('id');
            $role = session()->get('role');

            if (!$userId) {
                return $this->fail(['status' => false, 'message' => 'Not authenticated'], 401);
            }

            if ($role === 'admin') {
                $data = $this->chatServices->getAllConversations();
            } else {
                $data = $this->chatServices->getUserConversations($userId);
            }

            return $this->respond([
                'status' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return $this->fail(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function closeConversation($conversationId)
    {
        try {
            $userId = session()->get('id');

            if (!$userId) {
                return $this->fail(['status' => false, 'message' => 'Not authenticated'], 401);
            }

            $result = $this->chatServices->closeConversation($conversationId, $userId);

            if (!$result['status']) {
                return $this->fail($result, 403);
            }

            return $this->respond([
                'status' => true,
                'message' => $result['message'],
            ], 200);
        } catch (\Exception $e) {
            return $this->fail(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function unreadCount()
    {
        try {
            $userId = session()->get('id');

            if (!$userId) {
                return $this->fail(['status' => false, 'message' => 'Not authenticated'], 401);
            }

            $count = $this->chatServices->getUnreadCount($userId);

            return $this->respond([
                'status' => true,
                'data' => $count,
            ], 200);
        } catch (\Exception $e) {
            return $this->fail(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
