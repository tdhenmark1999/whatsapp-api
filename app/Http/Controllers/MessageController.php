<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Chatroom;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MessageController extends Controller
{
    public function send(Request $request, $id)
    {
        $request->validate([
            'content' => 'required_without:attachment|string',
            'attachment' => 'nullable|file'
        ]);

        try {
            $chatroom = Chatroom::findOrFail($id);

            $message = new Message();
            $message->chatroom_id = $chatroom->id;
            $message->user_id = auth()->user()->id;
            $message->content = $request->input('content');

            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('attachments');
                $message->attachment = $path;
            }

            $message->save();

            return response()->json([
                'message' => 'Message sent successfully.',
                'data' => $message
            ], 201);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Chatroom not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send message.'], 500);
        }
    }

    public function list($id)
    {
        try {
            $chatroom = Chatroom::findOrFail($id);

            $messages = $chatroom->messages()->orderBy('created_at', 'desc')->get();

            return response()->json($messages, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Chatroom not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve messages.'], 500);
        }
    }
}
