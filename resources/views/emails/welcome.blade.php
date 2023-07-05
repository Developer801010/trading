<x-mail::message>
Hello <b>{{$data['first_name']}} {{$data['last_name']}},</b>

Thanks for registering and welcome to TradeInSync. Your account is now active. You will have unlimited, full access to the <a href="{{route('front.account-membership')}}" target="_blank">membership</a> you selected during account creation.

Your username is <b>{{$data['user_name']}}</b>. You can access your account area to view recent orders, change your password, and more at: 

Happy Trading!<br>

</x-mail::message>
