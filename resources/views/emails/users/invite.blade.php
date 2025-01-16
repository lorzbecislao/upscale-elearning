@component('vendor.mail.html.message')
Hi <b>{{ $user['name'] }}</b>, <br>

<p>You have been invited to join the Upscale System. To fully activate your account please click the button below.</p>

@component('vendor.mail.html.button', ['url' => $invite_link])
    Activate Now
@endcomponent

<p>Your sign in email is: <br><b>{{ $user['email'] }}</b></p>
<p>Your temporary password is: <br><b>{{ $generated_password }}</b></p>

@component('vendor.mail.html.subcopy')
    If you’re having trouble clicking the "Activate now" button, copy and paste this link instead into your web browser: {{ $invite_link }}<br/><br/>
    @include('emails.email_footer')
@endcomponent
@endcomponent

