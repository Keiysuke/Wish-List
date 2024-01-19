<?php

namespace App\Http\Controllers;

use App\Models\Emoji;
use App\Models\ListingMessage;
use App\Models\ListMsgReaction;
use App\Models\Notyf;
use App\Services\ReactionService;

class ListMsgReactionsController extends Controller
{
    /**
     * Change emoji on a listing message
     * @param int $msg_id Id of the listing_message
     * @param int $emoji_id Id of the Emoji to change
    */
    public function toggle_reaction(int $msg_id, string $emoji_id)
    {
        $reactionsHTML = null;
        $created = true;
        $queryBuilder = ListMsgReaction::where('list_msg_id', '=', $msg_id)
            ->where('emoji_id', '=', $emoji_id)
            ->where('user_id', '=', auth()->user()->id);
        
        if (count($queryBuilder->get()) > 0) {
            $queryBuilder->delete();
            $created = false;
        } else {
            (new ListMsgReaction([
                'list_msg_id' => $msg_id,
                'emoji_id' => $emoji_id,
                'user_id' => auth()->user()->id,
            ]))->save();
            $message = ListingMessage::find($msg_id);
            ReactionService::setReactions($message);
            $reactionsHTML = view('components.messages.reactions')->with(['reactions' => $message->allReactions])->render();
        }
        
        $nb_users = ListMsgReaction::where('list_msg_id', '=', $msg_id)
            ->where('emoji_id', '=', $emoji_id)
            ->get();
        return response()->json([
            'success' => true, 
            'created' => $created, 
            'reactionsHTML' => $reactionsHTML, 
            'nb_users' => (count($nb_users) > 0 ? count($nb_users) : ''), 
        ]);
    }
}
