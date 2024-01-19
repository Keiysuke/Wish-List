<?php

namespace App\Services;

use App\Models\ListingMessage;

class ReactionService
{
    private $reactions;
    private $message;

    public function __construct(ListingMessage $message){
        $this->reactions = [];
        $this->message = $message;
        foreach($message->reactions as $reaction) {
            $emoji_id = $reaction->emoji->id;
            $user_datas = $reaction->user;
            if (array_key_exists($emoji_id, $this->reactions)) {
                $this->reactions[$emoji_id]['users'][] = $user_datas;
            } else {
                $this->reactions[$emoji_id] = [
                    'message_id' => $message->id,
                    'emoji' => $reaction->emoji,
                    'users' => [$user_datas],
                ];
            }
        }
    }

    public static function setReactions(&$msg) {
        $msg->allReactions = new ReactionService($msg);
    }

    public function getReactions() {
        return ArrayService::toObject($this->reactions);
    }

    public function show() {
        $returnHTML = view('components.messages.reactions')->with(['reactions' => $this->reactions])->render();
        return response()->json(['success' => true, 'html' => $returnHTML]);
    }
}
