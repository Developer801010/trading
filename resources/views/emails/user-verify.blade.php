<x-mail::message>
# Email Verification

Hello,  
Welcome to our application. Please click the button below to verify your email address.

@component('mail::button', ['url' => $actionUrl, 'color' => 'primary', 'classes' => 'button-success'])
    {{$actionText}}
@endcomponent

Thank you for joining us. If you’re having trouble clicking the link, copy and paste the URL below into your web browser,<br>

{{$actionUrl}} <br>

Regards. <br>

</x-mail::message>


