<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Jobs\MessageMailJob;
use App\Mail\MessageMail;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MessageResource::collection(
            Message::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request)
    {
        $message = Message::create($request->validated());
        MessageMailJob::dispatch($message);
        return MessageResource::make($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        return MessageResource::make($message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MessageRequest $request , Message $message)
    {
        $message->update($request->validated());
        return MessageResource::make(
            $message->refresh()
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        return $message->delete();
    }
}
