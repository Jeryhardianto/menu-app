@extends('layouts.frontsite')
@section('title', 'Custom pembelian - ')

@push('after-style')
<style>
    :root {
        --gf-ink: #1f2d3d;
        --gf-muted: #646b74;
        --gf-line: #e3e6ea;
        --gf-cta: #ffc107;
        --gf-cta-ink: #1f2d3d;
        --gf-accent: #2557e2;
    }

    /* Bar aksi menempel di bawah, jadi bottom nav disembunyikan di halaman ini
       supaya tidak ada dua elemen mengambang yang saling menutupi. */
    .vj-bottomnav { display: none !important; }
    .vj-footer { display: none; }
    body { padding-bottom: 0; }

    .cs-head {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .75rem 0;
    }

    .cs-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        margin-left: -.625rem;
        border-radius: 999px;
        color: var(--gf-ink);
        font-size: 1.125rem;
    }

    .cs-back:hover,
    .cs-back:focus { background: #e9ecef; color: var(--gf-ink); }

    .cs-head h1 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gf-ink);
    }

    .cs-card {
        padding: 1rem;
        margin-bottom: .75rem;
        border-radius: .75rem;
        background: #fff;
    }

    .cs-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        justify-content: space-between;
    }

    .cs-item__name {
        margin: 0;
        font-size: 1.0625rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--gf-ink);
    }

    .cs-item__desc {
        margin: .375rem 0 0;
        font-size: .875rem;
        line-height: 1.45;
        color: var(--gf-muted);
    }

    .cs-item__price {
        flex: 0 0 auto;
        font-size: 1.0625rem;
        font-weight: 700;
        color: var(--gf-ink);
        font-variant-numeric: tabular-nums;
    }

    .cs-thumb {
        width: 72px;
        height: 72px;
        object-fit: cover;
        border-radius: .625rem;
        background: #eef1f5;
    }

    .cs-label {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--gf-ink);
    }

    .cs-sub {
        margin: 0 0 .75rem;
        font-size: .8125rem;
        color: var(--gf-muted);
    }

    .cs-note {
        display: flex;
        align-items: flex-start;
        gap: .625rem;
        padding: .75rem 1rem;
        border: 1px solid #ced4da;
        border-radius: 1rem;
        background: #f8f9fa;
    }

    .cs-note i {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: .5rem;
        background: var(--gf-ink);
        color: #fff;
        font-size: .75rem;
    }

    .cs-note textarea {
        flex: 1 1 auto;
        min-height: 44px;
        border: 0;
        background: transparent;
        resize: vertical;
        font-size: 16px; /* di bawah 16px iOS auto-zoom saat fokus */
        color: var(--gf-ink);
    }

    .cs-note textarea:focus { outline: none; }

    .cs-count {
        margin: .375rem 0 0;
        font-size: .8125rem;
        color: var(--gf-muted);
    }

    .cs-bar {
        position: fixed;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1030;
        padding: .75rem 1rem calc(.75rem + env(safe-area-inset-bottom));
        border-top: 1px solid var(--gf-line);
        background: #fff;
        box-shadow: 0 -4px 16px rgba(31, 45, 61, .08);
    }

    .cs-bar__row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        max-width: 34rem;
        margin: 0 auto .75rem;
    }

    .cs-qty {
        display: flex;
        align-items: center;
        gap: .875rem;
    }

    .cs-step {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border: 1.5px solid var(--gf-accent);
        border-radius: 999px;
        background: #fff;
        color: var(--gf-accent);
        font-size: 1.125rem;
    }

    .cs-step:disabled {
        border-color: var(--gf-line);
        color: #adb5bd;
    }

    .cs-qty output {
        min-width: 2ch;
        text-align: center;
        font-size: 1.0625rem;
        font-weight: 700;
        color: var(--gf-ink);
        font-variant-numeric: tabular-nums;
    }

    .cs-submit {
        display: block;
        width: 100%;
        max-width: 34rem;
        min-height: 52px;
        margin: 0 auto;
        border: 0;
        border-radius: .625rem;
        background: var(--gf-cta);
        font-size: 1rem;
        font-weight: 700;
        color: var(--gf-cta-ink);
    }

    .cs-submit:disabled {
        background: #e9ecef;
        color: #495057;
    }

    @media (min-width: 992px) {
        .cs-wrap { max-width: 34rem; margin: 0 auto; }
    }
</style>
@endpush

@section('content')

    <div class="content-wrapper">
        <section class="content pt-2" style="padding-bottom: 140px;">
            <div class="container-fluid cs-wrap">

                @php
                    $kembali = optional($menu->GetSubkategori)->id_kategori == 2 ? route('minuman') : route('makanan');
                    $habis = $menu->stok == 0;
                    $qtyAwal = $habis ? 0 : min(max((int) ($item['qty'] ?? 1), 1), $menu->stok);
                @endphp

                <div class="cs-head">
                    <a href="{{ $kembali }}" class="cs-back" aria-label="Kembali">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    </a>
                    <h1>Custom pembelian</h1>
                </div>

                <div class="cs-card">
                    <div class="cs-item">
                        <img src="{{ $menu->gambar_url }}" class="cs-thumb" width="72" height="72"
                            alt="{{ $menu->nama_menu }}"
                            onerror="this.onerror=null;this.src='{{ asset('image/menu-default.svg') }}'">
                        <div class="flex-grow-1 min-width-0">
                            <h2 class="cs-item__name">{{ $menu->nama_menu }}</h2>
                            @if ($menu->deskripsi)
                                <p class="cs-item__desc">{{ $menu->deskripsi }}</p>
                            @endif
                        </div>
                        <div class="cs-item__price">{{ number_format($menu->harga, 0, ',', '.') }}</div>
                    </div>
                </div>

                <form action="{{ route('addtocart') }}" method="post" id="cs-form">
                    @csrf
                    <input type="hidden" name="id_nemu" value="{{ $menu->id }}">
                    <input type="hidden" name="qty" id="cs-qty" value="{{ $qtyAwal }}">

                    <div class="cs-card">
                        <p class="cs-label">Catatan</p>
                        <p class="cs-sub">Opsional</p>
                        <div class="cs-note">
                            <i class="fas fa-align-left" aria-hidden="true"></i>
                            <label for="cs-catatan" class="sr-only">Catatan untuk {{ $menu->nama_menu }}</label>
                            <textarea name="catatan" id="cs-catatan" rows="1" maxlength="200"
                                placeholder="Tulis permintaan khusus di sini, ya">{{ $item['catatan'] ?? '' }}</textarea>
                        </div>
                        <p class="cs-count"><span id="cs-count">{{ strlen($item['catatan'] ?? '') }}</span>/200</p>
                    </div>

                    <div class="cs-bar">
                        <div class="cs-bar__row">
                            <span class="cs-label">Jumlah pembelian</span>
                            <div class="cs-qty">
                                <button type="button" class="cs-step" id="cs-minus" aria-label="Kurangi jumlah" {{ $habis ? 'disabled' : '' }}>
                                    <i class="fas fa-minus" aria-hidden="true"></i>
                                </button>
                                <output id="cs-view" for="cs-qty" aria-live="polite">{{ $qtyAwal }}</output>
                                <button type="button" class="cs-step" id="cs-plus" aria-label="Tambah jumlah" {{ $habis ? 'disabled' : '' }}>
                                    <i class="fas fa-plus" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="cs-submit" id="cs-submit" {{ $habis ? 'disabled' : '' }}>
                            @if ($habis)
                                Stok habis
                            @else
                                Tambah pembelian - <span id="cs-total">{{ number_format($menu->harga * $qtyAwal, 0, ',', '.') }}</span>
                            @endif
                        </button>
                    </div>
                </form>

            </div>
        </section>
    </div>

@endsection

@push('javascript-internal')
<script>
    (function () {
        var HARGA = {{ (int) $menu->harga }};
        var STOK = {{ (int) $menu->stok }};

        var field = document.getElementById('cs-qty');
        var view = document.getElementById('cs-view');
        var total = document.getElementById('cs-total');
        var minus = document.getElementById('cs-minus');
        var plus = document.getElementById('cs-plus');

        if (!field || !total) return;

        function render() {
            var qty = Number(field.value);

            view.textContent = qty;
            total.textContent = (HARGA * qty).toLocaleString('id-ID');
            minus.disabled = qty <= 1;
            plus.disabled = qty >= STOK;
        }

        function ubah(delta) {
            var qty = Math.min(Math.max(Number(field.value) + delta, 1), STOK);
            field.value = qty;
            render();
        }

        minus.addEventListener('click', function () { ubah(-1); });
        plus.addEventListener('click', function () { ubah(1); });
        render();
    })();

    (function () {
        var area = document.getElementById('cs-catatan');
        var count = document.getElementById('cs-count');
        if (!area || !count) return;

        area.addEventListener('input', function () {
            count.textContent = this.value.length;
        });
    })();
</script>
@endpush
