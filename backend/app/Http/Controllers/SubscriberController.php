<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Subscriber;
use App\Jobs\ProcessSubscriber;
use App\Traits\HttpResponses;

class SubscriberController extends Controller
{
    use HttpResponses;
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $subscriber = Subscriber::where('email', $validated['email'])->first();

        if($subscriber && $subscriber->status == 'subscribed') {
            return $this->error(
                null,
                'Subscriber is already subscribed.',
                400
            );
        }

        dispatch(new ProcessSubscriber($validated['email'], 'subscribed'));

        return $this->success(
            [
                'email' => $validated['email'],
            ],
            'Subscription successful.',
            201
        );
    }

    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);
        
        $subscriber = Subscriber::where('email', $validated['email'])->first();

        if(!$subscriber || $subscriber->status !== 'subscribed') {
            return $this->error(
                null,
                'Subscriber is not currently subscribed.',
                400
            );
        }

        dispatch(new ProcessSubscriber($validated['email'], 'unsubscribed'));

        return $this->success(
            [
                'email' => $validated['email'],
            ],
            'Unsubscribed successfully.',
            200
        );
    }
}
