<?php

namespace App\Http\Controllers;

use App\Models\Chatroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ChatroomController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $chatroom = Chatroom::create(['name' => $request->name]);
            return response()->json($chatroom, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create chatroom.'], 500);
        }
    }

    public function list()
    {
        try {
            $chatrooms = Chatroom::all();
            return response()->json($chatrooms, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve chatrooms.'], 500);
        }
    }

    public function enter($id)
    {
        try {
            $chatroom = Chatroom::findOrFail($id);
            $chatroom->users()->attach(auth()->user()->id);

            return response()->json(['message' => 'Entered chatroom successfully.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Chatroom not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to enter chatroom.'], 500);
        }
    }

    public function leave($id)
    {
        try {
            $chatroom = Chatroom::findOrFail($id);
            $chatroom->users()->detach(auth()->user()->id);

            return response()->json(['message' => 'Left chatroom successfully.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Chatroom not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to leave chatroom.'], 500);
        }
    }
}
