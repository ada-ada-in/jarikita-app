<?php
namespace App\Services;

use App\Models\ChatModel;
use App\Models\MessageModel;
use App\Models\LayananJasaModel;
use App\Models\UsersModel;

class ChatServices
{
    protected $chatModel;
    protected $messageModel;
    protected $layananModel;
    protected $userModel;

    public function __construct()
    {
        $this->chatModel = new ChatModel();
        $this->messageModel = new MessageModel();
        $this->layananModel = new LayananJasaModel();
        $this->userModel = new UsersModel();
    }

    public function createConversation($senderId, $receiverId, $layananId = null)
    {
        $existing = $this->chatModel
            ->groupStart()
                ->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId)
            ->groupEnd()
            ->orGroupStart()
                ->where('sender_id', $receiverId)
                ->where('receiver_id', $senderId)
            ->groupEnd()
            ->where('layanan_id', $layananId)
            ->where('status', 'active')
            ->find();

        if (!empty($existing)) {
            return $existing[0];
        }

        $data = [
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'layanan_id' => $layananId,
            'status' => 'active',
        ];

        $this->chatModel->save($data);
        return $this->chatModel->find($this->chatModel->getInsertID());
    }

    public function sendMessage($conversationId, $senderId, $message)
    {
        if (!$conversationId) {
            return ['status' => false, 'message' => 'Conversation ID is required'];
        }

        $message = trim((string) $message);
        if ($message === '') {
            return ['status' => false, 'message' => 'Message cannot be empty'];
        }

        $message = strip_tags($message);

        $data = [
            'conversation_id' => $conversationId,
            'sender_id' => $senderId,
            'message' => $message,
            'is_read' => 0,
        ];

        $this->messageModel->save($data);

        $this->chatModel->update($conversationId, ['updated_at' => date('Y-m-d H:i:s')]);

        return [
            'status' => true,
            'data' => $this->messageModel->find($this->messageModel->getInsertID()),
        ];
    }

    public function getMessages($conversationId, $userId)
    {
        $conversation = $this->chatModel->find($conversationId);
        if (!$conversation) {
            return ['status' => false, 'message' => 'Conversation not found'];
        }

        if ($conversation['sender_id'] != $userId && $conversation['receiver_id'] != $userId) {
            $session = session();
            if ($session->get('role') !== 'admin') {
                return ['status' => false, 'message' => 'Unauthorized'];
            }
        }

        $this->messageModel
            ->where('conversation_id', $conversationId)
            ->where('sender_id !=', $userId)
            ->where('is_read', 0)
            ->set(['is_read' => 1])
            ->update();

        $messages = $this->messageModel
            ->where('conversation_id', $conversationId)
            ->orderBy('created_at', 'ASC')
            ->findAll();

        return ['status' => true, 'data' => $messages];
    }

    public function getUserConversations($userId)
    {
        $conversations = $this->chatModel
            ->groupStart()
                ->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId)
            ->groupEnd()
            ->where('status', 'active')
            ->orderBy('updated_at', 'DESC')
            ->findAll();

        $result = [];
        foreach ($conversations as $conv) {
            $otherId = ($conv['sender_id'] == $userId) ? $conv['receiver_id'] : $conv['sender_id'];
            $otherUser = $this->userModel->select('id, username, avatar_url, role')->find($otherId);

            $lastMessage = $this->messageModel
                ->where('conversation_id', $conv['id'])
                ->orderBy('created_at', 'DESC')
                ->first();

            $unreadCount = $this->messageModel
                ->where('conversation_id', $conv['id'])
                ->where('sender_id !=', $userId)
                ->where('is_read', 0)
                ->countAllResults();

            $layanan = null;
            if ($conv['layanan_id']) {
                $layanan = $this->layananModel->select('id, nama_jasa')->find($conv['layanan_id']);
            }

            $result[] = [
                'conversation' => $conv,
                'other_user' => $otherUser,
                'last_message' => $lastMessage,
                'unread_count' => $unreadCount,
                'layanan' => $layanan,
            ];
        }

        return $result;
    }

    public function getAllConversations()
    {
        $conversations = $this->chatModel
            ->where('status', 'active')
            ->orderBy('updated_at', 'DESC')
            ->findAll();

        $result = [];
        foreach ($conversations as $conv) {
            $sender = $this->userModel->select('id, username, avatar_url, role')->find($conv['sender_id']);
            $receiver = $this->userModel->select('id, username, avatar_url, role')->find($conv['receiver_id']);

            $lastMessage = $this->messageModel
                ->where('conversation_id', $conv['id'])
                ->orderBy('created_at', 'DESC')
                ->first();

            $messageCount = $this->messageModel
                ->where('conversation_id', $conv['id'])
                ->countAllResults();

            $layanan = null;
            if ($conv['layanan_id']) {
                $layanan = $this->layananModel->select('id, nama_jasa')->find($conv['layanan_id']);
            }

            $result[] = [
                'conversation' => $conv,
                'sender' => $sender,
                'receiver' => $receiver,
                'last_message' => $lastMessage,
                'message_count' => $messageCount,
                'layanan' => $layanan,
            ];
        }

        return $result;
    }

    public function getConversationById($conversationId)
    {
        return $this->chatModel->find($conversationId);
    }

    public function closeConversation($conversationId, $userId)
    {
        $conv = $this->chatModel->find($conversationId);
        if (!$conv) {
            return ['status' => false, 'message' => 'Conversation not found'];
        }

        $session = session();
        if ($conv['sender_id'] != $userId && $conv['receiver_id'] != $userId && $session->get('role') !== 'admin') {
            return ['status' => false, 'message' => 'Unauthorized'];
        }

        $this->chatModel->update($conversationId, ['status' => 'closed']);
        return ['status' => true, 'message' => 'Conversation closed'];
    }

    public function getUnreadCount($userId)
    {
        $conversations = $this->chatModel
            ->groupStart()
                ->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId)
            ->groupEnd()
            ->where('status', 'active')
            ->findAll();

        $totalUnread = 0;
        foreach ($conversations as $conv) {
            $count = $this->messageModel
                ->where('conversation_id', $conv['id'])
                ->where('sender_id !=', $userId)
                ->where('is_read', 0)
                ->countAllResults();
            $totalUnread += $count;
        }

        return $totalUnread;
    }
}
