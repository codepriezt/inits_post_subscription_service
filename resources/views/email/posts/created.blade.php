@component('mail::message')


Hello {{$user->full_name}}, <br>

You have a new post with the title : {{$title}} and  <br>

description: {{$description}}

Sign in to your Profile to check it out <br>


Regards, <br> <br>

The Init Team

@endcomponent
