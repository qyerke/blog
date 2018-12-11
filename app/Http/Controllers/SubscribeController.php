<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\Mail\Subscribe;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function subscribe(Request $request)
    {
      $this->validate($request, [
        'email' => 'email|required|unique:subscriptions',
      ]);
      $subs = Subscription::add($request->get('email'));
      \Mail::to($subs)->send(new Subscribe($subs));
      return redirect()->back()->with('status', 'Please check your email');
    }
    public function verify($token)
    {
      $subs = Subscription::where('token', $token)->firstOrFail();
      $subs->token = null;
      $subs->save();
      return redirect('/')->with('status', 'Thanks for subscribe!');
    }
}
