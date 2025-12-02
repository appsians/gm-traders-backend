<x-mail::message>
{{-- # Hi {{ $userData['name'] ?? 'User' }}, --}}

Thank you for submitting your consultation request!

We’ve received your request under the following details:

- **Consultancy:** {{ $consultation['consultancy'] }}
- **Sub_Consultancy:** {{ $consultation['sub_consultancy'] }}

Our team will review your request and get back to you soon.

<x-mail::button :url="config('app.url')">
Visit Our Website
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
