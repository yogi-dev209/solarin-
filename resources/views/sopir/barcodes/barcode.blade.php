@extends('layouts.sopir')

@section('title', 'Barcode Saya - SolarIn')
@section('page-greeting', 'Hallo, Selamat Datang')
@section('page-subtitle', 'Gunakan barcode ini saat bertransaksi.')

@push('styles')
<style>
    .barcode-page {
        padding-top: 18px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 900;
        margin: 0 0 48px 0;
        color: #111827;
    }

    .barcode-box {
        width: 100%;
        max-width: 900px;
        min-height: 363px;
        border: 1.8px solid #111827;
        border-radius: 24px;
        background: #ffffff;
        overflow: hidden;
        display: grid;
        grid-template-columns: 45.5% 54.5%;
        margin-left: 6px;
    }

    .guide-section {
        border-right: 1.8px solid #111827;
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .guide-title {
        padding: 50px 32px 22px 42px;
        font-size: 26px;
        font-weight: 400;
        color: #111827;
        border-bottom: 1.5px solid #111827;
    }

    .guide-list {
        padding: 12px 30px 20px 42px;
        font-size: 25px;
        line-height: 1.32;
        color: #111827;
    }

    .guide-list div {
        margin-bottom: 3px;
    }

    .barcode-section {
        min-width: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 6px 22px 18px 22px;
    }

    .barcode-title {
        font-size: 25px;
        font-weight: 900;
        text-align: center;
        margin: 0 0 8px 0;
        color: #111827;
    }

    .barcode-card {
        width: 100%;
        max-width: 425px;
        min-height: 268px;
        border-radius: 8px;
        overflow: hidden;
        background: #0b3b91;
        border: 1px solid #d1d5db;
        box-shadow: 0 3px 8px rgba(0, 0, 0, .12);
        position: relative;
    }

    .barcode-card-header {
        height: 52px;
        background: #0b3b91;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 0 15px;
        gap: 10px;
    }

    .pertamina-pill {
        background: #ffffff;
        border-radius: 999px;
        height: 35px;
        min-width: 124px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0b3b91;
        font-size: 12px;
        font-weight: 900;
    }

    .subsidi-pill {
        background: #38bdf8;
        color: #ffffff;
        border-radius: 5px;
        height: 35px;
        width: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8px;
        font-weight: 900;
        text-align: center;
        line-height: 1.05;
    }

    .barcode-card-body {
        display: grid;
        grid-template-columns: 46% 54%;
        min-height: 160px;
        padding: 0 18px 0 24px;
        align-items: center;
        background: #0b3b91;
    }

    .qr-box {
        width: 148px;
        height: 148px;
        background: #ffffff;
        border-radius: 8px;
        padding: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .qr-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .qr-date {
        grid-column: 1 / 3;
        color: #ffffff;
        font-size: 8px;
        text-align: center;
        margin-top: 4px;
    }

    .barcode-info {
        color: #ffffff;
        min-width: 0;
        margin-left: 10px;
    }

    .company-name {
        font-size: 20px;
        font-weight: 900;
        margin-bottom: 11px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .barcode-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        flex-wrap: wrap;
    }

    .small-truck {
        width: 22px;
        height: 12px;
        background: #ffffff;
        border-radius: 2px;
    }

    .barcode-footer {
        min-height: 56px;
        background: #d9f0f0;
        padding: 8px 18px;
        font-size: 8px;
        color: #1f2937;
        line-height: 1.45;
    }

    .mascot {
        position: absolute;
        right: 52px;
        bottom: 48px;
        width: 55px;
        height: 65px;
        border-radius: 12px;
        background: #38bdf8;
        transform: rotate(8deg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 24px;
        font-weight: 900;
        border: 4px solid #ffffff;
    }

    .download-row {
        width: 100%;
        max-width: 900px;
        display: flex;
        justify-content: flex-end;
        padding-right: 20px;
        margin-top: 16px;
    }

    .download-btn {
        width: 190px;
        height: 46px;
        border: 2px solid #08733f;
        border-radius: 10px;
        background: #08733f;
        color: #ffffff;
        font-size: 15px;
        font-weight: 900;
        cursor: pointer;
        text-align: center;
        transition: .18s;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .download-btn:hover {
        background: #065f36;
        border-color: #065f36;
    }

    .empty-state {
        padding: 40px;
        text-align: center;
        border: 2px dashed #9ca3af;
        border-radius: 18px;
        font-size: 18px;
        font-weight: 700;
        color: #64748b;
        margin-top: 20px;
    }

    @media (max-width: 950px) {
        .barcode-box {
            grid-template-columns: 1fr;
            margin-left: 0;
        }

        .guide-section {
            border-right: none;
            border-bottom: 1.8px solid #111827;
        }
    }

    @media (max-width: 768px) {
        .barcode-card-body {
            grid-template-columns: 1fr;
            justify-items: center;
            gap: 15px;
        }

        .barcode-info {
            margin-left: 0;
            text-align: center;
        }

        .barcode-meta {
            justify-content: center;
        }

        .mascot {
            display: none;
        }

        .download-row {
            justify-content: center;
            padding-right: 0;
        }

        .download-btn {
            width: 100%;
            max-width: 260px;
        }
    }
</style>
@endpush

@section('content')
<div class="barcode-page">
    <h2 class="page-title">Barcode Saya</h2>

    @if ($barcode && $barcode->barcode_file)
    <div class="barcode-box">
        <section class="guide-section">
            <div class="guide-title">Cara Menggunakan Barcode:</div>
            <div class="guide-list">
                <div>✓ Tunjukkan barcode ke petugas</div>
                <div>✓ Pastikan layar terang</div>
                <div>✓ Jangan memotong area barcode</div>
                <div>✓ Jangan berikan ke orang lain</div>
            </div>
        </section>

        <section class="barcode-section">
            <h3 class="barcode-title">Barcode Aktif</h3>

            <div class="barcode-card">
                <div class="barcode-card-header">
                    <div class="pertamina-pill">PERTAMINA</div>
                    <div class="subsidi-pill">SUBSIDI<br>TEPAT</div>
                </div>

                <div class="barcode-card-body">
                    <div>
                        <div class="qr-box">
                            <img src="{{ asset('storage/' . $barcode->barcode_file) }}" alt="QR Code" crossorigin="anonymous">
                        </div>
                        <div class="qr-date">Diterbitkan: {{ \Carbon\Carbon::parse($barcode->issued_date)->format('d-m-Y') }}</div>
                    </div>

                    <div class="barcode-info">
                        <div class="company-name">{{ $barcode->submission->vehicle->user->name }}</div>

                        <div class="barcode-meta">
                            <span class="small-truck"></span>
                            <span>{{ $barcode->submission->vehicle->plate_number }}</span>
                            <span>|</span>
                            <span>{{ $barcode->submission->vehicle->door_number }}</span>
                        </div>
                    </div>
                </div>

                <div class="barcode-footer">
                    * Penerima subsidi tidak bersifat permanen dan dapat berubah sewaktu-waktu.<br>
                    * Penyalahgunaan BBM Subsidi akan dikenakan sanksi sesuai dengan ketentuan.
                </div>
                <div class="mascot">☺</div>
            </div>
        </section>
    </div>

    <div class="download-row">
        <button class="download-btn" onclick="downloadKartu()" id="downloadBtn">
            ⬇ Download Kartu
        </button>
    </div>
    @else
    <div class="empty-state">
        Belum ada barcode yang diterbitkan. Silakan periksa menu Status Pengajuan Anda.
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    function downloadKartu() {
        const btn = document.getElementById('downloadBtn');
        const kartu = document.querySelector('.barcode-card');
        const namaSopir = "{{ $barcode->submission->vehicle->user->name ?? 'barcode' }}";
        const platNomor = "{{ $barcode->submission->vehicle->plate_number ?? '' }}";

        // Teks feedback saat proses
        btn.textContent = '⏳ Menyiapkan...';
        btn.disabled = true;

        html2canvas(kartu, {
            useCORS: true, // izinkan cross-origin image (QR dari storage)
            allowTaint: false,
            scale: 3, // resolusi 3× agar hasil tajam saat dicetak
            backgroundColor: null, // transparan — warna card sudah dari CSS
            logging: false,
        }).then(function(canvas) {
            // Buat nama file: kartu_NAMASOPIR_PLAT.png
            const slug = (namaSopir + '_' + platNomor)
                .replace(/\s+/g, '_')
                .replace(/[^a-zA-Z0-9_\-]/g, '');
            const fileName = 'kartu_subsidi_' + slug + '.png';

            // Trigger download
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = fileName;
            link.click();

            // Kembalikan tombol ke semula
            btn.textContent = '⬇ Download Kartu';
            btn.disabled = false;
        }).catch(function(err) {
            console.error('html2canvas error:', err);
            alert('Gagal mengunduh kartu. Coba lagi atau gunakan browser lain.');
            btn.textContent = '⬇ Download Kartu';
            btn.disabled = false;
        });
    }
</script>
@endpush