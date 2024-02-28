<p>Hey {{ $user->name }},</p>
<p>
    Sorry, your {{ $details['className'] }} class on {{ $details['classDateTime']->format('jS F') }} at {{ $details['classDateTime']->format('g:i a') }}
    was canceled by the instructor.
</p>
<p>
    Check the schedule and book another. Thank you!
</p>
