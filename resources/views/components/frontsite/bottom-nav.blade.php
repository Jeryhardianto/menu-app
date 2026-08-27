<style>
    /* Bar mengambang jadi satu-satunya navigasi setelah sidebar dilepas,
       jadi isi halaman perlu ruang kosong di bawah supaya tidak tertutup. */
    body { padding-bottom: 96px; }

    .vj-bottomnav {
        position: fixed;
        right: .75rem;
        bottom: .75rem;
        bottom: max(.75rem, env(safe-area-inset-bottom));
        left: .75rem;
        z-index: 1030;
        display: flex;
        align-items: center;
        justify-content: space-around;
        max-width: 28rem;
        height: 64px;
        margin: 0 auto;
        padding: 0 .5rem;
        border: 1px solid #e3e6ea;
        border-radius: 999px;
        background: rgba(255, 255, 255, .95);
        -webkit-backdrop-filter: blur(12px);
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 25px rgba(31, 45, 61, .15);
    }

    .vj-bottomnav__item {
        display: flex;
        border: 0;
        background: none;
        flex: 1 1 0;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: .125rem;
        min-width: 44px;
        min-height: 44px;
        padding: 0 .25rem;
        border-radius: 999px;
        color: #6c757d;
        text-decoration: none;
        transition: color .2s ease;
    }

    .vj-bottomnav__item:hover,
    .vj-bottomnav__item:focus {
        color: #1f2d3d;
        text-decoration: none;
    }

    .vj-bottomnav__item.is-on { color: #1b46b4; }

    .vj-bottomnav__icon {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 28px;
        border-radius: 999px;
        font-size: 1.125rem;
        transition: background-color .2s ease;
    }

    .vj-bottomnav__item.is-on .vj-bottomnav__icon { background: rgba(37, 87, 226, .15); }

    .vj-bottomnav__badge {
        position: absolute;
        top: -2px;
        right: 1px;
        min-width: 18px;
        height: 18px;
        padding: 0 5px;
        border-radius: 999px;
        background: #c82333;
        font-size: 10px;
        font-weight: 700;
        line-height: 18px;
        color: #fff;
    }

    .vj-bottomnav__label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .06em;
        line-height: 1;
        text-transform: uppercase;
    }

    @media (prefers-reduced-motion: reduce) {
        .vj-bottomnav__item,
        .vj-bottomnav__icon { transition: none; }
    }
</style>

@php
    $navItems = [
        ['route' => 'makanan', 'label' => 'Makanan', 'icon' => 'fa-hamburger', 'match' => 'makanan'],
        ['route' => 'minuman', 'label' => 'Minuman', 'icon' => 'fa-coffee', 'match' => 'minuman'],
    ];

    $pelanggan = auth()->check() && auth()->user()->role == 'Pelanggan';

    if ($pelanggan) {
        $navItems[] = ['route' => 'order', 'label' => 'Pesanan', 'icon' => 'fa-receipt', 'match' => ['order', 'payment', 'paymentsuccess']];
        $navItems[] = ['route' => 'myaccount', 'label' => 'Akun', 'icon' => 'fa-user', 'match' => 'myaccount', 'param' => auth()->id()];
    } else {
        $navItems[] = ['route' => 'login', 'label' => 'Masuk', 'icon' => 'fa-user', 'match' => 'login'];
    }
@endphp

<nav class="vj-bottomnav" aria-label="Navigasi utama">
    @foreach ($navItems as $i => $item)
        @php $on = set_active($item['match']); @endphp

        {{-- Keranjang disisipkan sebelum item akun supaya urutannya tetap sama
             untuk tamu maupun pelanggan. --}}
        @if ($i === 2)
            <button type="button" class="vj-bottomnav__item" data-toggle="modal" data-target="#modalCart"
                aria-label="Keranjang, {{ $cart['sumQty'] }} item">
                <span class="vj-bottomnav__icon">
                    <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                    @if ($cart['sumQty'] > 0)
                        <span class="vj-bottomnav__badge">{{ $cart['sumQty'] }}</span>
                    @endif
                </span>
                <span class="vj-bottomnav__label">Keranjang</span>
            </button>
        @endif

        <a href="{{ route($item['route'], $item['param'] ?? []) }}"
            class="vj-bottomnav__item {{ $on ? 'is-on' : '' }}"
            @if ($on) aria-current="page" @endif>
            <span class="vj-bottomnav__icon"><i class="fas {{ $item['icon'] }}" aria-hidden="true"></i></span>
            <span class="vj-bottomnav__label">{{ $item['label'] }}</span>
        </a>
    @endforeach
</nav>
