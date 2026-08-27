@extends('layouts.frontsite')
@section('title', $title . ' - ')

@push('after-style')
<style>
    :root {
        --gf-accent: #2557e2;
        --gf-accent-ink: #1b46b4;
        --gf-cta: #ffc107;
        --gf-cta-ink: #1f2d3d;
        --gf-ink: #1f2d3d;
        --gf-muted: #646b74;
        --gf-line: #e3e6ea;
        --gf-danger: #c82333;
    }

    /* ===== Pencarian sticky ===== */
    .gf-search {
        position: sticky;
        top: 0;
        z-index: 1020;
        padding: .75rem 0;
        background: #f4f6f9;
        box-shadow: 0 1px 0 rgba(31, 45, 61, .08);
    }

    .gf-search__field {
        display: flex;
        align-items: center;
        gap: .625rem;
        min-height: 46px;
        padding: 0 1rem;
        border: 1px solid #ced4da;
        border-radius: 999px;
        background: #fff;
    }

    .gf-search__field:focus-within { border-color: var(--gf-accent); }

    .gf-search__field i { color: var(--gf-muted); }

    .gf-search__field input {
        flex: 1 1 auto;
        min-width: 0;
        border: 0;
        background: transparent;
        font-size: 16px; /* di bawah 16px iOS auto-zoom saat fokus */
        color: var(--gf-ink);
    }

    .gf-search__field input:focus { outline: none; }

    /* ===== Section per subkategori ===== */
    .gf-section { padding-top: 1.5rem; }

    .gf-section__title {
        margin: 0 0 .75rem;
        font-size: 1.25rem;
        font-weight: 700;
        letter-spacing: .01em;
        text-transform: uppercase;
        color: var(--gf-ink);
    }

    .gf-section__rule {
        border-top: 1px dashed #c9cfd6;
        margin-bottom: .25rem;
    }

    /* ===== Baris menu ===== */
    .gf-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid var(--gf-line);
    }

    .gf-item__main {
        display: block;
        flex: 1 1 auto;
        min-width: 0;
        padding: 0;
        border: 0;
        background: none;
        text-align: left;
        color: inherit;
        cursor: pointer;
    }

    .gf-item__main:focus-visible {
        outline: 2px solid var(--gf-accent);
        outline-offset: 4px;
        border-radius: 4px;
    }

    .gf-tag {
        display: inline-flex;
        align-items: center;
        gap: .375rem;
        margin-bottom: .25rem;
        font-size: .8125rem;
        font-weight: 700;
        color: var(--gf-danger);
    }

    .gf-name {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.3;
        text-transform: uppercase;
        color: var(--gf-ink);
    }

    .gf-meta {
        display: flex;
        align-items: center;
        gap: .375rem;
        margin: .25rem 0 0;
        font-size: .8125rem;
        font-weight: 600;
        color: var(--gf-muted);
    }

    .gf-meta i { color: #d39e00; }

    .gf-desc {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin: .375rem 0 0;
        font-size: .875rem;
        line-height: 1.45;
        color: var(--gf-muted);
    }

    .gf-price {
        margin: .5rem 0 0;
        font-size: 1.0625rem;
        font-weight: 700;
        color: var(--gf-ink);
        font-variant-numeric: tabular-nums;
    }

    /* Sisi kanan: gambar dengan tombol Tambah menumpang di tepi bawahnya.
       padding-bottom menyediakan ruang untuk separuh tombol yang menjorok. */
    .gf-item__aside {
        position: relative;
        flex: 0 0 116px;
        width: 116px;
        padding-bottom: 22px;
    }

    .gf-thumb {
        position: relative;
        padding-top: 100%;
        overflow: hidden;
        border-radius: .75rem;
        background: #eef1f5;
    }

    .gf-thumb img {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .gf-item.is-habis .gf-thumb img {
        filter: grayscale(1);
        opacity: .5;
    }

    .gf-flag {
        position: absolute;
        top: .375rem;
        left: .375rem;
        padding: .1875rem .375rem;
        border-radius: .25rem;
        background: var(--gf-danger);
        font-size: .625rem;
        font-weight: 700;
        line-height: 1.2;
        color: #fff;
    }

    .gf-add {
        position: absolute;
        right: -6px;
        bottom: 0;
        left: -6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 0 .5rem;
        border: 1.5px solid var(--gf-accent);
        border-radius: .625rem;
        background: #fff;
        font-size: .9375rem;
        font-weight: 700;
        color: var(--gf-accent-ink);
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(31, 45, 61, .12);
        transition: background-color .2s ease, color .2s ease;
    }

    .gf-add:hover,
    .gf-add:focus {
        background: #eef3fe;
        color: var(--gf-accent-ink);
        text-decoration: none;
    }

    .gf-add.is-off {
        border-color: var(--gf-line);
        color: var(--gf-muted);
        box-shadow: none;
        pointer-events: none;
    }

    /* ===== Tombol Menu mengambang (lompat section) ===== */
    .gf-jump {
        position: fixed;
        left: 50%;
        transform: translateX(-50%);
        bottom: calc(88px + env(safe-area-inset-bottom));
        z-index: 1029;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        min-height: 44px;
        padding: 0 1.25rem;
        border: 0;
        border-radius: 999px;
        background: var(--gf-danger);
        font-size: .9375rem;
        font-weight: 700;
        color: #fff;
        box-shadow: 0 6px 16px rgba(31, 45, 61, .28);
    }

    .gf-jump:hover,
    .gf-jump:focus { color: #fff; }

    /* ===== Bottom sheet (detail menu + daftar section) ===== */
    .gf-sheet .modal-dialog {
        position: fixed;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        max-width: 34rem;
        margin: 0 auto;
        transform: translateY(100%);
        transition: transform .25s ease-out;
    }

    .gf-sheet.show .modal-dialog { transform: translateY(0); }

    .gf-sheet .modal-content {
        border: 0;
        border-radius: 1rem 1rem 0 0;
        max-height: 92vh;
    }

    .gf-sheet__grip {
        width: 44px;
        height: 4px;
        margin: .625rem auto .25rem;
        border-radius: 999px;
        background: #ced4da;
    }

    .gf-sheet__body {
        overflow-y: auto;
        padding: .75rem 1rem 1rem;
    }

    .gf-sheet__foot {
        padding: .75rem 1rem calc(.75rem + env(safe-area-inset-bottom));
        border-top: 1px solid var(--gf-line);
    }

    .gf-detail__img {
        width: 100%;
        aspect-ratio: 4 / 3;
        object-fit: cover;
        border-radius: .75rem;
        background: #eef1f5;
    }

    .gf-detail__name {
        margin: .875rem 0 0;
        font-size: 1.25rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--gf-ink);
    }

    .gf-detail__desc {
        margin: .5rem 0 0;
        font-size: .9375rem;
        line-height: 1.5;
        color: var(--gf-muted);
    }

    .gf-detail__price {
        margin: .75rem 0 0;
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gf-ink);
    }

    .gf-pill {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        min-height: 44px;
        margin-top: 1rem;
        padding: 0 1.25rem;
        border: 1px solid #ced4da;
        border-radius: 999px;
        background: #fff;
        font-size: .9375rem;
        font-weight: 600;
        color: var(--gf-ink);
    }

    .gf-cta {
        display: block;
        width: 100%;
        min-height: 50px;
        border: 0;
        border-radius: .625rem;
        background: var(--gf-cta);
        font-size: 1rem;
        font-weight: 700;
        color: var(--gf-cta-ink);
    }

    .gf-cta:disabled {
        background: #e9ecef;
        color: #495057;
    }

    .gf-jumplist a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        min-height: 52px;
        padding: .5rem .25rem;
        border-bottom: 1px solid var(--gf-line);
        font-size: .9375rem;
        font-weight: 600;
        color: var(--gf-ink);
        text-decoration: none;
    }

    .gf-jumplist a:last-child { border-bottom: 0; }
    .gf-jumplist span { color: var(--gf-muted); font-weight: 400; }

    .gf-empty {
        padding: 3rem 1rem;
        text-align: center;
        color: var(--gf-muted);
    }

    .gf-empty i { font-size: 2.5rem; color: #ced4da; }

    @media (min-width: 576px) {
        .gf-item__aside { flex-basis: 140px; width: 140px; }
        .gf-name { font-size: 1.0625rem; }
    }

    @media (min-width: 992px) {
        .gf-list { max-width: 44rem; margin: 0 auto; }
        .gf-search__field { max-width: 44rem; margin: 0 auto; }
    }

    @media (prefers-reduced-motion: reduce) {
        .gf-sheet .modal-dialog,
        .gf-add { transition: none; }
    }
</style>
@endpush

@section('content')

    <div class="content-wrapper">
        <section class="content pt-3">
            <div class="container-fluid">

                <div class="gf-search">
                    <label for="gf-search" class="sr-only">Cari {{ strtolower($title) }}</label>
                    <div class="gf-search__field">
                        <i class="fas fa-search" aria-hidden="true"></i>
                        <input type="search" id="gf-search" placeholder="Cari menu apa?"
                            autocomplete="off" enterkeyhint="search">
                    </div>
                </div>

                <div class="gf-list">
                    @forelse ($subkategoris as $sk)
                        <section class="gf-section" id="sk-{{ $sk->id }}" data-gf-section>
                            <h2 class="gf-section__title">{{ $sk->subketagori }}</h2>
                            <div class="gf-section__rule"></div>

                            @foreach ($sk->menus as $ms)
                                @php $habis = $ms->stok == 0; @endphp
                                <article class="gf-item {{ $habis ? 'is-habis' : '' }}"
                                    data-gf-item data-nama="{{ Str::lower($ms->nama_menu . ' ' . $sk->subketagori) }}">

                                    <button type="button" class="gf-item__main"
                                        onclick="gfDetail({{ $ms->id }})"
                                        aria-label="Lihat detail {{ $ms->nama_menu }}">
                                        @if (in_array($ms->id, $seringDibeli))
                                            <span class="gf-tag">
                                                <i class="fas fa-shopping-basket" aria-hidden="true"></i> Sering dibeli lagi
                                            </span>
                                        @endif
                                        <h3 class="gf-name">{{ $ms->nama_menu }}</h3>
                                        @if ($ms->terjual > 0 || (!$habis && $ms->stok <= 5))
                                            <p class="gf-meta">
                                                @if ($ms->terjual > 0)
                                                    <i class="fas fa-fire" aria-hidden="true"></i> Terjual {{ $ms->terjual }}
                                                @endif
                                                @if (!$habis && $ms->stok <= 5)
                                                    <span class="text-danger">Sisa {{ $ms->stok }}</span>
                                                @endif
                                            </p>
                                        @endif
                                        @if ($ms->deskripsi)
                                            <p class="gf-desc">{{ $ms->deskripsi }}</p>
                                        @endif
                                        <p class="gf-price">{{ number_format($ms->harga, 0, ',', '.') }}</p>
                                    </button>

                                    <div class="gf-item__aside">
                                        <div class="gf-thumb">
                                            <img src="{{ $ms->gambar_url }}" width="400" height="400"
                                                loading="{{ $loop->parent->first && $loop->index < 3 ? 'eager' : 'lazy' }}"
                                                decoding="async" alt="{{ $ms->nama_menu }}"
                                                onerror="this.onerror=null;this.src='{{ asset('image/menu-default.svg') }}'">
                                            @if ($habis)
                                                <span class="gf-flag">Habis</span>
                                            @endif
                                        </div>
                                        @if ($habis)
                                            <span class="gf-add is-off" aria-disabled="true">Habis</span>
                                        @else
                                            <a href="{{ route('custom', $ms->id) }}" class="gf-add"
                                                aria-label="Tambah {{ $ms->nama_menu }}">Tambah</a>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </section>
                    @empty
                        <div class="gf-empty">
                            <div><i class="fas fa-utensils" aria-hidden="true"></i></div>
                            <p class="mb-0 mt-2">Belum ada menu di kategori ini.</p>
                        </div>
                    @endforelse

                    <div class="gf-empty" id="gf-noresult" hidden>
                        <div><i class="fas fa-search" aria-hidden="true"></i></div>
                        <p class="mb-0 mt-2">Menu tidak ditemukan. Coba kata kunci lain.</p>
                    </div>
                </div>

            </div>
        </section>

        @if ($subkategoris->count() > 1)
            <button type="button" class="gf-jump" data-toggle="modal" data-target="#gfJump">
                <i class="fas fa-utensils" aria-hidden="true"></i> Menu
            </button>
        @endif

        {{-- Sheet: daftar section --}}
        <div class="modal fade gf-sheet" id="gfJump" tabindex="-1" role="dialog" aria-labelledby="gfJumpTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="gf-sheet__grip" aria-hidden="true"></div>
                    <div class="gf-sheet__body">
                        <h2 class="h5 font-weight-bold mb-2" id="gfJumpTitle">Daftar menu</h2>
                        <nav class="gf-jumplist">
                            @foreach ($subkategoris as $sk)
                                <a href="#sk-{{ $sk->id }}" data-gf-jump="sk-{{ $sk->id }}">
                                    {{ $sk->subketagori }} <span>{{ $sk->menus->count() }}</span>
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sheet: detail menu --}}
        <div class="modal fade gf-sheet" id="gfDetail" tabindex="-1" role="dialog" aria-labelledby="gfDetailName" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="gf-sheet__grip" aria-hidden="true"></div>
                    <div class="gf-sheet__body">
                        <img id="gfDetailImg" class="gf-detail__img" src="{{ asset('image/menu-default.svg') }}" alt="">
                        <h2 class="gf-detail__name" id="gfDetailName"></h2>
                        <p class="gf-detail__desc" id="gfDetailDesc"></p>
                        <p class="gf-detail__price" id="gfDetailPrice"></p>
                        <button type="button" class="gf-pill" id="gfShare">
                            <i class="fas fa-share-alt" aria-hidden="true"></i> Bagikan
                        </button>
                    </div>
                    <div class="gf-sheet__foot">
                        <a href="#" class="gf-cta text-center d-flex align-items-center justify-content-center"
                            id="gfDetailCta">Tambah pembelian</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('javascript-internal')
<script>
    var GF_CUSTOM_URL = '{{ url('custom') }}';
    var GF_DETAIL_URL = '{{ url('getdetailmenu') }}';
    var GF_FALLBACK_IMG = '{{ asset('image/menu-default.svg') }}';

    function gfRupiah(n) {
        return Number(n || 0).toLocaleString('id-ID');
    }

    // Detail menu dibuka sebagai bottom sheet, isinya diambil saat dibutuhkan.
    function gfDetail(id) {
        $.get(GF_DETAIL_URL + '/' + id, function (res) {
            var m = res.data;
            var img = document.getElementById('gfDetailImg');

            img.onerror = function () { this.onerror = null; this.src = GF_FALLBACK_IMG; };
            img.src = m.gambar_url;
            img.alt = m.nama_menu;

            document.getElementById('gfDetailName').textContent = m.nama_menu;
            document.getElementById('gfDetailDesc').textContent = m.deskripsi || '';
            document.getElementById('gfDetailPrice').textContent = gfRupiah(m.harga);

            var cta = document.getElementById('gfDetailCta');
            if (m.stok > 0) {
                cta.textContent = 'Tambah pembelian';
                cta.href = GF_CUSTOM_URL + '/' + m.id;
                cta.classList.remove('disabled');
                cta.removeAttribute('aria-disabled');
            } else {
                cta.textContent = 'Stok habis';
                cta.removeAttribute('href');
                cta.setAttribute('aria-disabled', 'true');
            }

            $('#gfDetail').data('nama', m.nama_menu).modal('show');
        });
    }

    document.getElementById('gfShare').addEventListener('click', function () {
        var nama = $('#gfDetail').data('nama') || document.title;
        var data = { title: nama, text: nama + ' - {{ config('app.name') }}', url: location.href };

        if (navigator.share) {
            navigator.share(data).catch(function () {});
        } else if (navigator.clipboard) {
            navigator.clipboard.writeText(data.text + ' ' + data.url);
            Swal.fire({ icon: 'success', title: 'Tautan disalin', timer: 1500, showConfirmButton: false });
        }
    });

    // Lompat ke section; offset dikurangi tinggi bar pencarian yang sticky.
    $('[data-gf-jump]').on('click', function (e) {
        e.preventDefault();
        var target = document.getElementById($(this).data('gf-jump'));
        var offset = document.querySelector('.gf-search').offsetHeight;

        $('#gfJump').modal('hide');
        if (!target) return;

        window.scrollTo({
            top: target.getBoundingClientRect().top + window.pageYOffset - offset,
            behavior: 'smooth'
        });
    });

    // Cari di sisi klien: section ikut disembunyikan kalau semua isinya tersaring.
    (function () {
        var input = document.getElementById('gf-search');
        if (!input) return;

        var sections = [].slice.call(document.querySelectorAll('[data-gf-section]'));
        var noResult = document.getElementById('gf-noresult');
        var jump = document.querySelector('.gf-jump');

        input.addEventListener('input', function () {
            var q = this.value.trim().toLowerCase();
            var total = 0;

            sections.forEach(function (sec) {
                var shown = 0;

                [].slice.call(sec.querySelectorAll('[data-gf-item]')).forEach(function (el) {
                    var match = q === '' || el.dataset.nama.indexOf(q) !== -1;
                    el.hidden = !match;
                    if (match) shown++;
                });

                sec.hidden = shown === 0;
                total += shown;
            });

            noResult.hidden = total !== 0;
            if (jump) jump.hidden = q !== '';
        });
    })();
</script>
@endpush
