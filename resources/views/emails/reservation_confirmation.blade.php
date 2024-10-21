<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007BFF;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ __('mail.reservation_confirmation') }}</h1>
        <p>{{ __('mail.thank_you') }}</p>
        <p>{{ __('mail.reservation_details') }}</p>
        <ul>
            <li>{{ __('mail.room') }}: {{ $reservation->room->name }}</li>
            <li>{{ __('mail.check_in') }}: {{ $reservation->check_in->format('d.m.Y') }}</li>
            <li>{{ __('mail.check_out') }}: {{ $reservation->check_out->format('d.m.Y') }}</li>
            <li>{{ __('mail.guests_number') }}: {{ $reservation->guests_number }}</li>
            <li>{{ __('mail.total_price') }}: {{ number_format($reservation->total_price, 2) }} PLN</li>
        </ul>
        <p>{{ __('mail.cancellation_code') }}: {{ $reservation->cancellation_code }}</p>
        <p>{{ __('mail.cancel_reservation_link') }}</p>
        <a href="{{ route('reservation.cancel', ['id' => $reservation->id, 'code' => $reservation->cancellation_code]) }}">
            {{ __('mail.cancel_reservation') }}
        </a>
    </div>
</body>
</html>