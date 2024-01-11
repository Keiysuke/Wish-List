<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingMessageRequest;
use App\Models\ListingMessage;
use App\Models\Notyf;

class ListingMessagesController extends Controller
{
    public function show(int $id){
        $messages = ListingMessage::where('listing_id', '=', $id)
            ->get();

        return view('partials.lists.messages')->with(compact('messages'))->render();
    }

    public function send(ListingMessageRequest $request){
        if ($request->ajax()) {
            $message = new ListingMessage([
                'listing_id' => $request->listing_id,
                'user_id' => auth()->user()->id,
                'message' => $request->message,
                'answer_to_id' => ($request->answer_to_id === 0 ? null : $request->answer_to_id),
            ]);
            
            if ($message->save()) {
                $msg = view('components.message')->with(['message' => $message->fresh()])->render();
                return response()->json(['success' => true, 'message' => $msg]);
            }
            return response()->json(['success' => false, 'notyf' => Notyf::error('Whoops! Something went wrong.')]);
        }
    }

    /**
     * Pin a listing message
     * @param int $id Id of the listing_message to pin
    */
    public function pin(int $id, string $action){
        $pin = $action === 'pin';
        if ($pin) {
            $notyf = Notyf::success('Message pinned');
        } else {
            $notyf = Notyf::error('Message unpinned');
        }
        ListingMessage::where('id', '=', $id)
            ->update(['pin' => ($pin ? 1 : 0)]);
        return response()->json(['success' => true, 'notyf' => $notyf]);
    }

    /**
     * Delete a listing message
     * @param int $id Id of the listing_message to delete
    */
    public function delete(int $id){
        ListingMessage::where('answer_to_id', '=', $id)
            ->update(['answer_to_id' => null]);
        ListingMessage::find($id)->delete();
        return response()->json(['success' => true, 'notyf' => Notyf::success('Message deleted')]);
    }

    /**
     * Delete all messages of the list
     * @param int $id Id of the listing which will have all its messages deleted
    */
    public function delete_all(int $id){
        ListingMessage::where('listing_id', '=', $id)
            ->delete();
        return response()->json(['success' => true, 'html' => $this->show($id)]);
    }
}
