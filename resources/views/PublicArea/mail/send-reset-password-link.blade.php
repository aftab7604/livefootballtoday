@component('mail::message')
LiveFootballToday- Password Reset Link

Click the button to reset your password.

@component('mail::button', ['url' => $data['link']])
Reset Password
@endcomponent

Thanks,<br>
Team {{ config('app.name') }}
@endcomponent
