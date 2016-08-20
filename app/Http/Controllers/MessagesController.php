<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class MessagesController extends Controller
{
    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index()
    {
        $currentUserId = Auth::user()->id;

        // All threads that user is participating in
        $threads = Thread::forUser($currentUserId)->latest('updated_at')->get();

        return view('messages.index', compact('threads', 'currentUserId'));
    }

    /**
     * Show all of the message threads the user had with
     * another user.
     *
     * @param int $recipientId
     * @return mixed
     */
    public function showConversations($recipientId)
    {
        $currentUserId = Auth::user()->id;
        $recipient = User::findOrFail($recipientId);

        $threads = Thread::between([
            $currentUserId, $recipientId
        ])->latest('updated_at')->get();

        return view('messages.index', compact('threads', 'currentUserId', 'recipient'));
    }

    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            /** @var Thread $thread */
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect('messages');
        }

        $userId = Auth::user()->id;
        $thread->markAsRead($userId);

        return view('messages.show', compact('thread'));
    }

    /**
     * Creates a new message thread.
     *
     * @param int $recipientId
     * @return mixed
     */
    public function create($recipientId)
    {
        $recipient = User::find($recipientId);

        return view('messages.create', compact('recipient'));
    }

    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function store()
    {
        $input = Input::all();

        $thread = Thread::create(
            [
                'subject' => $input['subject'],
            ]
        );

        // Message
        Message::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
                'body'      => $input['message'],
            ]
        );

        // Sender
        Participant::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
                'last_read' => new Carbon,
            ]
        );

        // Recipients
        $thread->addParticipant($input['recipients']);

        return redirect(route('messages.show', $thread));
    }

    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect('messages');
        }

        // When a new message is sent, mark it as new for everyone
        $thread->activateAllParticipants();

        // Message
        Message::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::id(),
                'body'      => Input::get('message'),
            ]
        );

        // Add replier as a participant
        $participant = Participant::firstOrCreate(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
            ]
        );
        $participant->last_read = new Carbon;
        $participant->save();

        return redirect(route('messages.show', $thread));
    }
}