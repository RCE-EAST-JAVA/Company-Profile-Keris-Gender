<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): SymfonyResponse|Response
    {
        return $request->user()->hasVerifiedEmail()
                    ? Inertia::location(redirect()->intended(route('admin.dashboard', absolute: false)))
                    : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
