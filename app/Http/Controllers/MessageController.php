<?php

namespace App\Http\Controllers;

use App\Http\Helper\Response;
use App\Models\Message;
use App\Models\UsersMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index()
    {
        $result = UsersMessage::with(["user", "message"])->get();
        return Response::success($result);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id"   => "required|exists:users,id",
            "message"   => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $message = new Message([
            "message"   => $request->message
        ]);
        $message->save();

        $userMessage = new UsersMessage([
            "user_id"       => $request->user_id,
            "message_id"    => $message->id
        ]);
        $userMessage->save();

        return Response::message("Pesan terkirim!", 200);
    }
}
