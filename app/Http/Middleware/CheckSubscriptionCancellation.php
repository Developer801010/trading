<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Subscription;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionCancellation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // $endsAt  = Subscription::where('user_id', $user->id)->value('ends_at');    //subscription cancellation date
        // if($user && $endsAt !== null && now()->lessThan($endsAt) ){
        //      // If the user is logged in, has an 'ends_at' date, and the subscription has not yet ended
        //      return $next($request); // Allow access to other pages
        // }

        // $membership_name = Subscription::where('user_id', $user->id)->value('name');

        // if ($request->user() && ! $request->user()->subscribed($membership_name)) {
        //     return redirect()->route('front.account-membership')->withErrors(['error' => 'Your subscription was cancelled. You can renew your subscription.']);
        // }

        return $next($request);
    }
}
