<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Thank you for staying with us!</h1>
    <p>Please rate your room:</p>
    <a href="{{ route('review.create', ['room_id' => $reservation->room_id, 'reservation_id' => $reservation->id]) }}">
        Rate your stay
    </a>
</body>
</html>