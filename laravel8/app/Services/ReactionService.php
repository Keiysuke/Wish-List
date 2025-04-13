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
            $emojiId = $reaction->emoji->id;
            $userDatas = $reaction->user;
            if (array_key_exists($emojiId, $this->reactions)) {
                $this->reactions[$emojiId]['users'][] = $userDatas;
            } else {
                $this->reactions[$emojiId] = [
                    'message_id' => $message->id,
                    'emoji' => $reaction->emoji,
                    'users' => [$userDatas],
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
        $html = view('components.Tchat.ReactionsLine')->with(['reactions' => $this->reactions])->render();
        return response()->json(['success' => true, 'html' => $html]);
    }
}
