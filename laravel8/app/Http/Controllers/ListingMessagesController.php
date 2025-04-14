<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ListingMessageRequest;
use App\Models\Listing;
use App\Models\ListingMessage;
use App\Models\Notyf;
use App\Services\MessageService;
use App\Services\ReactionService;

class ListingMessagesController extends Controller
{
    public function getActionsMenu(Request $request){
        abort_unless($request->ajax(), 404);
        $this->validate($request, [
            'msg_id' => 'bail|nullable|int',
            'yours' => 'bail|required|boolean',
            'pin' => 'bail|required|boolean',
            'answer_to' => 'bail|required|string',
        ]);
        
        $html = view('components.Tchat.ActionMenu')->with($request->toArray())->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function show(int $listId, string $status){
        $buildQuery = ListingMessage::where('listing_id', '=', $listId);
        if ($status === 'pinned') {
            $buildQuery->where('pin', '=', 1);
        }
        $messages = $buildQuery->get();
        MessageService::setReactions($messages);

        $html = view('components.Tchat.MessagesList')->with(compact('messages'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function send(ListingMessageRequest $request){
        if ($request->ajax()) {
            $message = new ListingMessage([
                'listing_id' => $request->list_id,
                'user_id' => auth()->user()->id,
                'answer_to_id' => ($request->answer_to_id === 0 ? null : $request->answer_to_id),
            ]);
            //On récupère le dernier message de la liste pour vérifier s'il s'agit du même user
            $lastMsg = ListingMessage::where('listing_id', '=', $request->list_id)
                    ->orderBy('id', 'desc')
                    ->first();
            $odd = $lastMsg->user_id != auth()->user()->id;
            
            if ($message->save()) {
                $message->fresh();
                ReactionService::setReactions($message);
                $msg = view('components.Tchat.Message')->with(['message' => $message, 'sent' => true, 'odd' => $odd])->render();
                return response()->json(['success' => true, 'message' => $msg]);
            }
            return response()->json(['success' => false, 'notyf' => Notyf::error('Whoops! Something went wrong.')]);
        }
    }

    /**
     * Edit a listing message
     * @param int $msgId Id of the listing_message to edit
    */
    public function edit(int $msgId){
        return response()->json(['success' => true, 'msg' => ListingMessage::find($msgId)]);
    }

    /**
     * Return messages of a list
     * @param int $listId Id of the listing
    */
    public function getMessages(int $listId){
        $list = Listing::find($listId);
        return response()->json([
            'success' => true, 
            'htmlMsg' => (new MessageService())->show($listId),
            'shared_list' => $list->isShared(),
        ]);
    }

    /**
     * Update a listing message
     * @param int $msgId Id of the listing_message to update
    */
    public function update(Request $request, int $msgId){
        if ($request->ajax()) {
            $this->validate($request, [
                'message' => 'bail|required|string',
            ]);

            ListingMessage::where('id', '=', $msgId)
                ->update($request->all());
            return response()->json(['success' => true, 'msg' => ListingMessage::find($msgId)]);
        }
    }

    /**
     * Pin a listing message
     * @param int $msgId Id of the listing_message to pin
    */
    public function pin(int $msgId, string $action){
        $pin = $action === 'pin';
        if ($pin) {
            $notyf = Notyf::success('Message pinned');
        } else {
            $notyf = Notyf::error('Message unpinned');
        }
        ListingMessage::where('id', '=', $msgId)
            ->update(['pin' => ($pin ? 1 : 0)]);
        return response()->json(['success' => true, 'notyf' => $notyf]);
    }

    /**
     * Delete a listing message
     * @param int $msgId Id of the listing_message to delete
    */
    public function delete(int $msgId){
        ListingMessage::where('answer_to_id', '=', $msgId)
            ->update(['answer_to_id' => null]);
        ListingMessage::find($msgId)->delete();
        return response()->json(['success' => true, 'notyf' => Notyf::success('Message deleted')]);
    }

    /**
     * Delete all messages of the list
     * @param int $listId Id of the listing which will have all its messages deleted
    */
    public function deleteAll(int $listId){
        ListingMessage::where('listing_id', '=', $listId)
            ->delete();
        return response()->json(['success' => true, 'html' => (new MessageService())->show($listId)]);
    }
}
