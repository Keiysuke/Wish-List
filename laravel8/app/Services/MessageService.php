<?php

namespace App\Services;

use App\Models\ListingMessage;

class MessageService
{
    public function show(int $list_id){
        $messages = ListingMessage::where('listing_id', '=', $list_id)
            ->get();
        MessageService::setReactions($messages);

        return view('partials.lists.messages')->with(compact('messages'))->render();
    }

    public static function setReactions($messages){
        foreach ($messages as $message) {
            ReactionService::setReactions($message);
        }
    }
}
