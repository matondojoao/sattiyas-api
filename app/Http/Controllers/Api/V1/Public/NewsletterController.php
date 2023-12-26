<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsletterSubscriptionRequest;
use App\Notifications\NewNewsletterSubscription;
use App\Repositories\Public\NewsletterRepository;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    private $NewsletterRepository;

    public function __construct(NewsletterRepository $NewsletterRepository)
    {
        $this->NewsletterRepository = $NewsletterRepository;
    }

    public function subscribe(NewsletterSubscriptionRequest $request)
    {
        $data = $request->validated();

        $newsletter = $this->NewsletterRepository->subscribe($data);

        $newsletter->notify(new NewNewsletterSubscription($newsletter->email));

        return response()->json(['message' => 'Subscription successful!']);
    }
}
