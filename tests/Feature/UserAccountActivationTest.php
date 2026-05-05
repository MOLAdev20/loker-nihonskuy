<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class UserAccountActivationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registered_event_sends_verification_email_using_custom_template(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        event(new Registered($user));

        Notification::assertSentTo($user, VerifyEmail::class, function (VerifyEmail $notification) use ($user) {
            $mailMessage = $notification->toMail($user);

            $this->assertSame('Aktivasi Akun - Loker Nihonskuy', $mailMessage->subject);
            $this->assertSame('emails.account-activation', $mailMessage->view);
            $this->assertSame($user->id, $mailMessage->viewData['user']->id);
            $this->assertArrayHasKey('url', $mailMessage->viewData);

            return true;
        });
    }

    public function test_unverified_user_is_redirected_to_verification_notice_after_login(): void
    {
        $user = User::factory()->unverified()->create([
            'email' => 'login-unverified@example.com',
            'password' => 'password',
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('verification.notice'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_unverified_user_cannot_access_user_dashboard_routes(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get(route('user.dashboard'));

        $response->assertRedirect(route('verification.notice'));
    }

    public function test_verification_link_marks_user_as_verified(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect(route('user.dashboard', ['verified' => 1], false));
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_resend_verification_email_is_rate_limited(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        foreach (range(1, 6) as $attempt) {
            $this->actingAs($user)
                ->post(route('verification.send'))
                ->assertRedirect();
        }

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertStatus(429);
    }
}
