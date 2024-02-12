<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $offer->title }}</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: black;
            color: #fff;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .offer-container {
            border-radius: 10px;
            background: #000;/* Dark red to light red */
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add a subtle shadow */
            text-align: center;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 8px;
        }

        h1 {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.5em;
            margin-top: 10px;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="offer-container">
        <h1>{{ $offer->title }}</h1>

        @if($offer->hasMedia())
            <img src="{{ $offer->getFirstMediaUrl() }}" alt="Offer Image">
        @endif

        <p>Description: {{ $offer->description }}</p>

        <p>Discount: {{ $offer->discount }}</p>

        <p>Category: {{ $offer->category->name ?? 'Service' }}</p>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
