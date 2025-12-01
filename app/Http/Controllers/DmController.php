<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Follow;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DmController extends Controller
{
    private $message;

    private $conversation;

    private $follow;

    public function __construct(Conversation $conversation, Message $message, Follow $follow)
    {
        $this->conversation = $conversation;
        $this->message = $message;
        $this->follow = $follow;
    }

    public function show()
    {

        $user_id = Auth::id();

        $existingConversationUserIds = $this->conversation
            ->where('user1_id', $user_id)
            ->pluck('user2_id')
            ->toArray();

        $existingConversationUserIds2 = $this->conversation
            ->where('user2_id', $user_id)
            ->pluck('user1_id')
            ->toArray();

        $excludeUserIds = array_merge($existingConversationUserIds, $existingConversationUserIds2);

        $followings = $this->follow
            ->where('follower_id', $user_id)
            ->whereNotIn('following_id', $excludeUserIds)
            ->with('following')
            ->get();

        $conversations = $this->conversation
            ->where('user1_id', $user_id)
            ->orWhere('user2_id', $user_id)
            ->with(['user1', 'user2', 'lastMessage'])
            ->latest('updated_at')
            ->get();

        // when conversation in not started yet
        $conversation = null;
        $partner = null;

        return view('messages.message', [
            'followings' => $followings,
            'conversations' => $conversations,
            'user_id' => $user_id,
            'conversation' => $conversation,
            'partner' => $partner,
        ]);

    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'content' => 'nullable|string|max:1000',
            'media' => 'nullable|file|max:51200',
        ]);

        // if there is no content and image, return error
        if (empty($validated['content']) && ! $request->hasFile('media')) {
            return response()->json([
                'success' => false,
                'error' => 'Please enter a message or attach media.',
            ], 422);
        }

        // check author
        if (! Auth::check()) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
        }

        // login userID
        $user_id = Auth::id();

        // get the conversation
        $conversation = $this->conversation->findOrFail($validated['conversation_id']);

        // judge  partnerID
        $receiver_id = $conversation->user1_id == $user_id
            ? $conversation->user2_id
            : $conversation->user1_id;

        $messageData = [
            'conversation_id' => $conversation->id,
            'sender_id' => $user_id,
            'receiver_id' => $receiver_id,
            'content' => $validated['content'] ?? null,
        ];

        if ($request->hasFile('media')) {

            $file = $request->file('media');
            $mime = $file->getMimeType();

            // image
            if (str_starts_with($mime, 'image/')) {
                $path = $file->store('chat_images', 'public');
                $messageData['image_path'] = $path;
            }
            // video
            elseif(str_starts_with($mime, 'video/')){
                // get the duration of video
                $duration = $this->getVideoDuration($file->getPathname());

                if ($duration > 30) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Video must be 30 seconds or shorter.',
                    ], 422);
                }

                $path = $file->store('chat_videos', 'public');
                $messageData['video_path'] = $path;
            }
        }

        // create message
        $message = $this->message->create($messageData);

        // update last message in the conversation
        $conversation->update(['last_message_id' => $message->id]);

        // in case Ajax
        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'content' => $message->content,
                'image_url' => $message->image_path ? asset('storage/'.$message->image_path) : null,
                'video_url' => $message->video_path ? asset('storage/'.$message->video_path) : null,
                'sender_id' => $message->sender_id,
                'created_at' => $message->created_at->format('m/d H:i'),
            ],
        ]);
    }

    private function getVideoDuration($filePath)
    {
        // get the duration of video by ffprobe
        $cmd = "ffprobe -v error -show_entries format=duration -of csv=p=0 \"$filePath\"";

        $duration = shell_exec($cmd);

        return floatval($duration);
    }

    public function destroy($id)
    {

        if (! Auth::check()) {
            abort(403, 'Unauthorized action.');
        }

        $user_id = Auth::id();

        $message = $this->message->findOrFail($id);
        $conversation = $message->conversation;

        if ($message->sender_id != $user_id) {
            abort(403, 'Unauthorized action.');
        }

        // remove image
        if ($message->image_path) {
            $imagePath = storage_path('app/public/'.$message->image_path);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // remove video
        if (!empty($message->video_path)) {
            $videoPath = storage_path('app/public/' . $message->video_path);
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }
        }

        $message->delete();

        // last_message caliculation again
        if ($conversation->last_message_id == $id) {

            $newLast = $this->message
                ->where('conversation_id', $conversation->id)
                ->orderBy('created_at', 'desc')
                ->first();

            $conversation->last_message_id = $newLast ? $newLast->id : null;
            $conversation->save();
        }

        return response()->json(['success' => true]);

    }
}
