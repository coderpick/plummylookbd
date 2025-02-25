@component('mail::message')
# {{ ucfirst($data['title']) }}

{{ ucfirst($data['details']) }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
