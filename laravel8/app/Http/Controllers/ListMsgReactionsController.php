<?php

namespace App\Http\Controllers;

use App\Models\ListingMessage;
use App\Models\ListMsgReaction;
use App\Services\ReactionService;

class ListMsgReactionsController extends Controller
{
    /**
     * Change emoji on a listing message
     * @param int $msgId Id of the listing_message
     * @param int $emojiId Id of the Emoji to change
    */
    public function toggleReaction(int $msgId, string $emojiId)
    {
        $reactionsHTML = null;
        $created = true;
        $queryBuilder = ListMsgReaction::where('list_msg_id', '=', $msgId)
            ->where('emoji_id', '=', $emojiId)
            ->where('user_id', '=', auth()->user()->id);
        
        if (count($queryBuilder->get()) > 0) {
            $queryBuilder->delete();
            $created = false;
        } else {
            (new ListMsgReaction([
                'list_msg_id' => $msgId,
                'emoji_id' => $emojiId,
                'user_id' => auth()->user()->id,
            ]))->save();
            $message = ListingMessage::find($msgId);
            ReactionService::setReactions($message);
            $reactionsHTML = view('components.Tchat.ReactionsLine')->with(['reactions' => $message->allReactions])->render();
        }
        
        $nb_users = ListMsgReaction::where('list_msg_id', '=', $msgId)
            ->where('emoji_id', '=', $emojiId)
            ->get();
        return response()->json([
            'success' => true, 
            'created' => $created, 
            'reactionsHTML' => $reactionsHTML, 
            'nb_users' => (count($nb_users) > 0 ? count($nb_users) : ''), 
        ]);
    }
}
