@component('mail::message')
    # Contact us message

    Name: {{ $data['name'] }}
    Email: {{ $data['email'] }}

    Sub: {{ $data['subject'] }}

    Message:
    {{ $data['message'] }}


    From
    {{ config('app.name') }}
@endcomponent
