@component('mail::message')
# New Contact Inquiry 📩

You have received a new inquiry from **{{ $senderName }}**.

| Field   | Details |
|---------|---------|
| **Name**    | {{ $senderName }} |
| **Email**   | {{ $senderEmail }} |
| **Phone**   | {{ $senderPhone ?: '—' }} |

---

**Message:**

{{ $senderMessage }}

---

Reply directly to this email to respond to {{ $senderName }}.

Thanks,
Vidhzz Gallery
@endcomponent
