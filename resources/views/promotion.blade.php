<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
    <title>“AirRide”Smart Lowered Airsuspension Airbft</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/promotion.css'])
</head>

<body>
    <nav>
        @if (count($promotions) > 0)
            <img src="/storage/{{ $promotions[0]->path }}" alt="AirBft" class="aspect-16/1">
        @endif
    </nav>

    <main>
        @foreach ($promotions as $promotion)
            @if ($loop->index > 0)
                <img src="/storage/{{ $promotion->path }}" alt="Section {{ $promotion->order }}">
            @endif
        @endforeach

        <section class="contact-form">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Airbft Icon" class="logo">
            <form id="contact-form">
                <button type="submit" class="order-now">Order Sekarang</button>
                <input type="text" required name="name" id="name" class="name" placeholder="Nama">
                <input type="text" name="address" id="address" class="address" placeholder="Alamat">
                <input type="tel" required name="phone_number" id="phone_number" class="phone_numer"
                    placeholder="No. Whatsapp">
            </form>

            <h3 class="info-&-consultation">Info & Konsultasi</h3>
            <button class="click-here">Klik Disini</button>
            <div class="socials">
                <a target="_blank" href="https://www.instagram.com/airbft_indonesia/" class="instagram"><i
                        class="fa-brands fa-instagram"></i>airbft_indonesia</a>
                <a target="_blank" href="https://www.facebook.com/airbftsuspension/" class="facebook"><i
                        class="fa-brands fa-square-facebook"></i>airbft indonesia</a>
                <a target="_blank" href="https://www.youtube.com/channel/UCtCFmjqA2mBo7vDpjilb07g   " class="youtube"><i
                        class="fa-brands fa-youtube"></i>airbft indonesia</a>
            </div>
        </section>
    </main>

    <footer>
        <a href="mailto:airbft.indonesia.01@gmail.com" target="_blank" class="email"><i
                class="fa-solid fa-envelope"></i> airbft.indonesia.01@gmail.com</a>
        <a href="https://wa.me/+6282260000055?text=Hallo,%20Saya%20ingin%20bertanya%20tentang%20produk%20Airbft"
            target="_blank" class="whatsapp"><i class="fa-solid fa-phone"></i>
            +62 822 600 000 55</a>
    </footer>
    @vite('resources/js/promotions.ts')
</body>

</html>
