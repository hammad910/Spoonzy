<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\PaymentGateways;
use App\Models\Supplement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use App\Models\Transactions;


class ExperimentController extends Controller
{
    public function index()
    {
        return view('users.experiments');
    }
    public function creatorExperiment($id)
    {
        $experiment = Content::with('creator')->findOrFail($id);
        $userPlanMonthlyActive = $experiment->creator->planActive();
        $user = $experiment->creator;
       $totalPosts = $user->updates()->select('updates.id', 'updates.user_id')->count();
        $allPayment = PaymentGateways::where('enabled', '1')->whereSubscription('yes')->get();
        $plans = $user->plans()
      ->where('interval', '<>', 'monthly')
      ->whereStatus('1')
      ->get();

        if (auth()->check()) {
            $checkSubscription = auth()->user()->checkSubscription($user);

            if ($checkSubscription) {
                // Get Payment gateway the subscription
                $paymentGatewaySubscription = Transactions::whereSubscriptionsId($checkSubscription->id)->first();
            }

            // Check Payment Incomplete
            $paymentIncomplete = auth()->user()
                ->userSubscriptions()
                ->whereIn('stripe_price', $user->plans()->pluck('name'))
                ->whereStripeStatus('incomplete')
                ->first();
        }
        return view('users.experiment-creator', compact('id', 'userPlanMonthlyActive', 'user', 'checkSubscription', 'paymentIncomplete', 'totalPosts', 'allPayment', 'plans'));
    }
    public function fetchCreatorExperiement($id)
    {
        $experiment = Content::with('creator')->findOrFail($id);
        $userPlanMonthlyActive = $experiment->creator->planActive();

        return response()->json([
            'success' => true,
            'title' => $experiment->title,
            'category' => $experiment->category ?? 'Healthcare',
            'image_url' => asset('images/' . $experiment->media_url),
            'content_type' => $experiment->content_type,
            'user' => [
                'name' => $experiment->creator->name,
                'avatar' =>  $experiment->creator->avatar
            ],
            'completed' => 30,
            'total' => 40,
            'created_at' => $experiment->created_at,
            'status' => $experiment->status,
        ]);
    }

    public function getExperimentSupplements()
    {
        try {
            $supplements = Supplement::where('user_id', FacadesAuth::id())
                ->get();

            return response()->json($supplements->map(function ($supplement) {
                return [
                    'id' => $supplement->id,
                    'name' => $supplement->name,
                    'image' => $supplement->image,
                    'participants_text' => $supplement->participants_count . ' participants',
                ];
            }));
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to load supplements'
            ], 500);
        }
    }
}
