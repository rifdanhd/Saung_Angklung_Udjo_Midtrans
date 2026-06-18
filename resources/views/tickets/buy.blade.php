@extends('layouts.app')

@section('title', 'Book Now | Saung Angklung Udjo')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}">
        </script>
    <style>
        :root {
            --gold: #c4a47c;
            --gold-lt: rgba(196, 164, 124, .12);
            --bg: #F7F7F2;
            --white: #ffffff;
            --gray-soft: rgba(26, 20, 69, .06);
            --gray-mid: rgba(26, 20, 69, .12);
            --gray-text: rgba(26, 20, 69, .5);
            --success: #2d9f6a;
            --danger: #e05252;
            --radius-sm: 6px;
            --radius-md: 14px;
            --radius-lg: 24px;
            --shadow-card: 0 12px 48px rgba(26, 20, 69, .07);
            --shadow-hover: 0 24px 60px rgba(26, 20, 69, .12)
        }

        body {
            background: var(--bg);
            /* #F7F7F2 */

        }

        /* HERO */
        .tkt-hero {
            position: relative;
            height: 46vh;
            min-height: 320px;
            display: flex;
            align-items: flex-end;
            overflow: hidden;
            padding: 0 clamp(1.5rem, 5vw, 4rem) 3rem;
        }

        .tkt-hero-bg {
            position: absolute;
            inset: 0;
            /* Perubahan di sini: Menggunakan gambar dan gradien transparan */
            background: linear-gradient(160deg, rgba(13, 11, 46, 0.8) 0%, rgba(26, 20, 69, 0.7) 50%, rgba(34, 24, 93, 0.8) 100%),
                url('{{ asset('img/Angklungmasal.webp') }}') center/cover no-repeat;
            /* Pastikan jalur gambar benar. Asset('images/...') diasumsikan jalur publik Laravel Anda. */
            height: 65vh;
            /* dari 46vh */
            min-height: 420px;
            /* dari 320px */
        }

        .tkt-hero-bg::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            border: 1px solid rgba(196, 164, 124, .07)
        }

        .tkt-hero-bg::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: 20%;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            border: 1px solid rgba(196, 164, 124, .05)
        }

        .hero-pattern {
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(135deg, transparent 0, transparent 40px, rgba(196, 164, 124, .025) 40px, rgba(196, 164, 124, .025) 41px)
        }

        .hero-deco {
            position: absolute;
            right: clamp(2rem, 8vw, 7rem);
            top: 50%;
            transform: translateY(-50%);
            opacity: .055;
            pointer-events: none;
            width: clamp(80px, 12vw, 150px)
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 750px
        }

        .hero-eyebrow {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .55em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px
        }

        .hero-eyebrow::before {
            content: '';
            display: inline-block;
            width: 28px;
            height: 1px;
            background: var(--gold)
        }

        .hero-title {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(1.7rem, 4vw, 3rem);
            color: #fff;
            line-height: 1.15;
            font-weight: 400;
            margin-bottom: 16px
        }

        .hero-title em {
            font-style: italic;
            color: var(--gold)
        }

        .hero-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap
        }

        .hero-badge {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .45)
        }

        .hero-sep {
            width: 1px;
            height: 12px;
            background: rgba(255, 255, 255, .15)
        }

        /* BREADCRUMB */
        .breadcrumb {
            padding: 13px clamp(1.5rem, 5vw, 4rem);
            border-bottom: 1px solid var(--gray-mid);
            background: var(--white)
        }

        .bc-inner {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: var(--gray-text)
        }

        .bc-inner a {
            color: var(--gray-text);
            text-decoration: none;
            transition: color .2s
        }

        .bc-inner a:hover {
            color: var(--gold)
        }

        .bc-inner .sep {
            font-size: 8px;
            opacity: .35
        }

        .bc-inner .cur {
            color: #1a1445
        }

        /* MAIN LAYOUT */
        .tkt-wrap {
            max-width: 1360px;
            margin: 0 auto;
            padding: 2.5rem clamp(1.5rem, 5vw, 4rem) 6rem;
            display: grid;
            grid-template-columns: 1fr 390px;
            gap: 2.5rem;
            align-items: start;
            background: var(--bg)
        }

        /* STEPS */
        .steps {
            grid-column: 1/-1;
            display: flex;
            align-items: center;
            margin-bottom: .5rem
        }

        .step {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1
        }

        .sn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.5px solid var(--gray-mid);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 800;
            color: var(--gray-text);
            transition: all .4s;
            flex-shrink: 0
        }

        .sl {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .28em;
            text-transform: uppercase;
            color: var(--gray-text);
            transition: color .4s
        }

        .step.active .sn {
            background: #1a1445;
            border-color: #1a1445;
            color: #fff
        }

        .step.active .sl {
            color: #1a1445
        }

        .step.done .sn {
            background: var(--gold);
            border-color: var(--gold);
            color: #1a1445
        }

        .step.done .sl {
            color: var(--gold)
        }

        .sline {
            flex: 1;
            height: 1px;
            background: var(--gray-mid);
            margin: 0 10px;
            transition: background .4s
        }

        .sline.done {
            background: var(--gold)
        }

        /* CARD */
        .card {
            background: var(--white);
            border: 1px solid var(--gray-soft);
            border-radius: var(--radius-lg);
            padding: 2rem 2.2rem;
            margin-bottom: 1.4rem;
            box-shadow: var(--shadow-card);
            transition: box-shadow .4s
        }

        .card:hover {
            box-shadow: var(--shadow-hover)
        }

        .sh {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 1.75rem
        }

        .sh-bar {
            width: 3px;
            height: 24px;
            background: linear-gradient(to bottom, var(--gold), rgba(196, 164, 124, .25));
            border-radius: 2px;
            flex-shrink: 0
        }

        .sh h3 {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.15rem;
            font-weight: 400;
            color: #1a1445
        }

        .sh p {
            font-size: 9px;
            color: var(--gray-text);
            letter-spacing: .2em;
            text-transform: uppercase;
            font-weight: 700;
            margin-top: 2px
        }

        /* CALENDAR */
        .cal-hdr {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.4rem
        }

        .cal-month {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.05rem;
            font-weight: 400;
            color: #1a1445
        }

        .cal-navs {
            display: flex;
            gap: 8px
        }

        .cal-btn {
            width: 33px;
            height: 33px;
            border-radius: 50%;
            border: 1px solid var(--gray-mid);
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a1445;
            transition: all .22s
        }

        .cal-btn:hover {
            background: #1a1445;
            color: #fff;
            border-color: #1a1445
        }

        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 3px
        }

        .cdn {
            text-align: center;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--gray-text);
            padding: 7px 0 10px
        }

        .cd {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            color: #1a1445;
            cursor: pointer;
            transition: all .18s;
            position: relative;
            border: 1px solid transparent
        }

        .cd:hover:not(.empty):not(.past) {
            background: var(--gold-lt);
            border-color: rgba(196, 164, 124, .3)
        }

        .cd.past {
            color: rgba(26, 20, 69, .2);
            cursor: not-allowed
        }

        .cd.empty {
            cursor: default
        }

        .cd.today:not(.sel) {
            font-weight: 800;
            color: var(--gold)
        }

        .cd.today:not(.sel)::after {
            content: '';
            position: absolute;
            bottom: 4px;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--gold)
        }

        .cd.sel {
            background: #1a1445;
            color: #fff;
            font-weight: 700;
            border-color: #1a1445
        }

        .cd.has:not(.past):not(.sel):not(.today)::after {
            content: '';
            position: absolute;
            bottom: 4px;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(196, 164, 124, .45)
        }

        /* SESSIONS */
        .sess-grid {
            display: flex;
            flex-direction: column;
            gap: 10px
        }

        .sess-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            border: 1.5px solid var(--gray-mid);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all .22s;
            position: relative
        }

        .sess-item:hover {
            border-color: var(--gold);
            background: var(--gold-lt)
        }

        .sess-item.sel {
            border-color: #1a1445;
            background: rgba(26, 20, 69, .03)
        }



        .sess-time {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.05rem;
            color: #1a1445
        }

        .sess-meta {
            margin-left: auto;
            text-align: right
        }

        .sess-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--gray-text);
            margin-bottom: 3px
        }

        .sess-seats {
            font-size: 11px;
            font-weight: 700;
            color: var(--success)
        }

        .sess-seats.low {
            color: #e08a2d
        }

        .sess-check {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #1a1445;
            display: none;
            align-items: center;
            justify-content: center;
            margin-left: 14px;
            flex-shrink: 0
        }

        .sess-check svg {
            width: 10px;
            height: 10px;
            stroke: #fff
        }

        .sess-item.sel .sess-check {
            display: flex
        }

        /* TICKETS */
        .tkt-list {
            display: flex;
            flex-direction: column;
            gap: 10px
        }

        .tkt-row {
            display: flex;
            align-items: center;
            padding: 1.1rem 1.25rem;
            border: 1px solid var(--gray-mid);
            border-radius: var(--radius-md);
            transition: border-color .22s
        }

        .tkt-row:hover {
            border-color: rgba(196, 164, 124, .35)
        }

        .tkt-row.has {
            border-color: rgba(26, 20, 69, .2)
        }

        .tkt-info {
            flex: 1
        }

        .tkt-name {
            font-size: 13px;
            font-weight: 700;
            color: #1a1445;
            margin-bottom: 3px
        }

        .tkt-desc {
            font-size: 10px;
            color: var(--gray-text)
        }

        .tkt-price {
            font-family: 'Libre Baskerville', serif;
            font-size: .98rem;
            color: #1a1445;
            margin: 0 1.1rem;
            min-width: 88px;
            text-align: right
        }

        .tkt-price small {
            display: block;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .12em;
            color: var(--gray-text);
            font-family: 'Inter', sans-serif;
            text-transform: uppercase;
            margin-bottom: 2px
        }

        .qty-ctrl {
            display: flex;
            align-items: center;
            gap: 9px
        }

        .qty-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1.5px solid var(--gray-mid);
            background: transparent;
            cursor: pointer;
            font-size: 15px;
            color: #1a1445;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .18s;
            line-height: 1;
            user-select: none
        }

        .qty-btn:hover:not(:disabled) {
            background: #1a1445;
            color: #fff;
            border-color: #1a1445
        }

        .qty-btn:disabled {
            border-color: var(--gray-soft);
            color: rgba(26, 20, 69, .2);
            cursor: not-allowed
        }

        .qty-num {
            font-size: 14px;
            font-weight: 700;
            min-width: 22px;
            text-align: center
        }

        /* FORM */
        .fg {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px
        }

        .fg.full {
            grid-template-columns: 1fr
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px
        }

        .field label {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .35em;
            text-transform: uppercase;
            color: var(--gray-text)
        }

        .field input,
        .field select {
            padding: 11px 14px;
            border: 1.5px solid var(--gray-mid);
            border-radius: var(--radius-sm);
            background: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: #1a1445;
            outline: none;
            transition: border-color .22s;
            appearance: none;
            -webkit-appearance: none
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(196, 164, 124, .1)
        }

        .field input::placeholder {
            color: rgba(26, 20, 69, .22)
        }

        .field-err {
            font-size: 10px;
            color: var(--danger);
            margin-top: 2px;
            display: none
        }

        .field.has-err .field-err {
            display: block
        }

        .field.has-err input,
        .field.has-err select {
            border-color: var(--danger)
        }

        .form-gap {
            display: flex;
            flex-direction: column;
            gap: 14px
        }

        /* EMPTY STATE */
        .es {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2.5rem 1rem;
            gap: 10px;
            text-align: center
        }

        .es svg {
            opacity: .16
        }

        .es p {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--gray-text)
        }


        .btn-pay.loading {
            opacity: 0.7;
            cursor: not-allowed;
            position: relative;
            color: transparent !important;
        }

        .btn-pay.loading::after {
            content: "";
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin: -10px 0 0 -10px;
            border: 3px solid rgba(255, 255, 255, .3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s ease-infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ── CUSTOM PAYMENT UI ── */
        #payment-selector-wrapper,
        #payment-instruction-wrapper {
            display: none;
            margin-top: 1rem;
            animation: fadeSlideIn 0.5s ease;
        }

        #payment-selector-wrapper.active,
        #payment-instruction-wrapper.active {
            display: block;
        }

        .pay-meth-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 15px;
        }

        .pay-meth-item {
            border: 1.5px solid var(--gray-soft);
            border-radius: var(--radius-md);
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s;
            background: #fff;
        }

        .pay-meth-item:hover {
            border-color: var(--gold);
            background: rgba(196, 164, 124, .05);
        }

        .pay-meth-item.selected {
            border-color: var(--gold);
            background: rgba(196, 164, 124, .1);
            box-shadow: 0 0 0 1px var(--gold);
        }

        .pay-meth-item img {
            height: 20px;
            object-fit: contain;
        }

        .pay-meth-item span {
            font-size: 12px;
            font-weight: 600;
            color: #1a1445;
        }

        .inst-box {
            border: 1px solid var(--gray-soft);
            border-radius: var(--radius-md);
            padding: 20px;
            text-align: center;
            background: #fff;
            margin-top: 15px;
        }

        .inst-box h4 {
            font-size: 14px;
            color: var(--gray-text);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .inst-va {
            background: #f8f9fa;
            border: 2px dashed var(--gray-mid);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .inst-va .va-num {
            font-family: monospace;
            font-size: 16px;
            font-weight: bold;
            color: #1a1445;
            word-break: break-all;
        }

        .inst-qr img {
            max-width: 200px;
            border-radius: 8px;
            border: 1px solid var(--gray-soft);
            margin: 0 auto 15px;
        }

        .inst-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(196, 164, 124, .15);
            color: #b89240;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .inst-status .spinner {
            width: 12px;
            height: 12px;
            border: 2px solid rgba(184, 146, 64, .3);
            border-top-color: #b89240;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* RIGHT PANEL */
        .order-panel {
            position: sticky;
            top: 86px;
            display: flex;
            flex-direction: column;
            gap: 1rem
        }

        .sum-card {
            background: var(--white);
            border: 1px solid var(--gray-soft);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-card)
        }

        .sum-hdr {
            background: #1a1445;
            padding: 1.4rem 1.6rem
        }

        .sum-hdr p {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .38em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .38);
            margin-bottom: 6px
        }

        .sum-price {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.75rem;
            color: #fff;
            font-weight: 400
        }

        .sum-price small {
            font-size: 11px;
            color: rgba(255, 255, 255, .38);
            font-family: 'Inter', sans-serif;
            margin-left: 4px
        }

        .sum-body {
            padding: 1.4rem 1.6rem
        }

        .sum-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 1.1rem
        }

        .sum-row-info {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 12px
        }

        .sum-row-info svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            margin-top: 1px;
            opacity: .38
        }

        .sum-row-info .lbl {
            color: var(--gray-text)
        }

        .sum-row-info strong {
            color: #1a1445;
            display: block
        }

        .sum-divider {
            height: 1px;
            background: var(--gray-soft);
            margin: 1.1rem 0
        }

        .sum-rows {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 1.1rem
        }

        .sum-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--gray-text)
        }

        .sum-row .val {
            font-weight: 600;
            color: #1a1445
        }

        .sum-total {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding-top: 10px;
            border-top: 1.5px dashed var(--gray-mid);
            margin-bottom: 1.4rem
        }

        .sum-total .tl {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .22em;
            text-transform: uppercase
        }

        .sum-total .tv {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.35rem;
            color: #1a1445
        }

        .btn-pay {
            width: 100%;
            padding: 15px;
            background: var(--gold);
            color: #1a1445;
            border: none;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .28em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .35s cubic-bezier(.16, 1, .3, 1);
            box-shadow: 0 8px 28px rgba(196, 164, 124, .3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px
        }

        .btn-pay:hover:not(:disabled) {
            background: #b89240;
            transform: translateY(-2px);
            box-shadow: 0 14px 38px rgba(196, 164, 124, .4)
        }

        .phone-wrap {
            display: flex;
            gap: 8px;
        }

        .phone-code {
            width: 110px;
            flex-shrink: 0;
            padding: 11px 10px;
            border: 1.5px solid var(--gray-mid);
            border-radius: var(--radius-sm);
            background: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: #1a1445;
            outline: none;
            transition: border-color .22s;
            appearance: none;
            -webkit-appearance: none;
        }

        @media(max-width:600px) {
            .phone-code {
                width: 85px;
                font-size: 11px;
            }
        }

        .btn-pay:disabled {
            background: var(--gray-mid);
            color: var(--gray-text);
            box-shadow: none;
            cursor: not-allowed;
            transform: none
        }

        .btn-pay .btn-spinner {
            width: 14px;
            height: 14px;
            border: 2px solid rgba(26, 20, 69, .2);
            border-top-color: #1a1445;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none
        }

        .btn-pay.loading .btn-spinner {
            display: block
        }

        .btn-pay.loading .btn-label {
            display: none
        }

        .secure-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--gray-text);
            margin-top: 10px
        }

        .secure-note svg {
            width: 11px;
            height: 11px
        }

        .pm-row {
            margin-top: 13px;
            padding-top: 13px;
            border-top: 1px solid var(--gray-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap
        }

        .pm {
            padding: 4px 9px;
            border: 1px solid var(--gray-mid);
            border-radius: 4px;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .08em;
            color: var(--gray-text)
        }

        .policy ul,
        .policy li {
            color: rgba(255, 255, 255, .42);
            font-size: 10px;
            line-height: 1.75;
        }

        .policy {
            background: #1a1445;
            border-radius: var(--radius-md);
            padding: 1rem 1.25rem
        }

        .policy p {
            font-size: 10px;
            color: rgba(255, 255, 255, .42);
            line-height: 1.75
        }

        .policy strong {
            color: var(--gold)
        }

        /* TOAST */
        .toast {
            position: fixed;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            opacity: 0;
            background: rgba(27, 26, 75, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 16px 32px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.05em;
            color: #fff;
            z-index: 9999;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.25);
            text-align: center;
            pointer-events: none;
            white-space: nowrap;
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .toast.err {
            background: rgba(180, 40, 40, 0.95);
            border-color: rgba(255, 100, 100, 0.3);
        }

        .toast.ok {
            background: rgba(30, 130, 75, 0.95);
            border-color: rgba(100, 255, 150, 0.3);
        }

        /* REVEAL */
        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: all .8s cubic-bezier(.16, 1, .3, 1)
        }

        .reveal.active {
            opacity: 1;
            transform: none
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        @media(max-width:900px) {
            .tkt-wrap {
                grid-template-columns: 1fr
            }

            .order-panel {
                position: static
            }

            .steps {
                display: none
            }
        }

        @media(max-width:600px) {
            .fg {
                grid-template-columns: 1fr
            }

            .tkt-price {
                display: none
            }
        }
    </style>
@endpush

@section('content')

    {{-- HERO --}}
    <div class="tkt-hero">
        <div class="tkt-hero-bg"></div>
        <div class="hero-pattern"></div>
        <svg class="hero-deco" viewBox="0 0 80 180" fill="white" xmlns="http://www.w3.org/2000/svg">
            <rect x="0" y="0" width="5" height="180" rx="2" />
            <rect x="75" y="0" width="5" height="180" rx="2" />
            <rect x="0" y="0" width="80" height="6" rx="2" />
            <rect x="0" y="58" width="80" height="4" rx="1" />
            <rect x="9" y="7" width="10" height="118" rx="2" />
            <rect x="24" y="13" width="10" height="113" rx="2" />
            <rect x="40" y="7" width="10" height="118" rx="2" />
            <rect x="56" y="11" width="10" height="116" rx="2" />
        </svg>
        <div class="hero-content">
            <div class="hero-eyebrow">Pesan Tiket</div>
            <h1 class="hero-title">Pertunjukan Angklung<br><em>&amp; Budaya Sunda</em></h1>

        </div>
    </div>

    {{-- BREADCRUMB --}}
    <div class="breadcrumb">
        <div class="bc-inner">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">›</span>
            <span class="cur">Pesan Tiket</span>
        </div>
    </div>

    {{-- MAIN --}}
    <div class="tkt-wrap">

        {{-- STEPS --}}
        <div class="steps">
            <div class="step active" id="stp1">
                <div class="sn">1</div>
                <div class="sl">Data Pengunjung</div>
            </div>
            <div class="sline" id="l12"></div>
            <div class="step" id="stp2">
                <div class="sn">2</div>
                <div class="sl">Pilih Jadwal</div>
            </div>
            <div class="sline" id="l23"></div>
            <div class="step" id="stp3">
                <div class="sn">3</div>
                <div class="sl">Pilih Tiket</div>
            </div>
            <div class="sline" id="l34"></div>
            <div class="step" id="stp4">
                <div class="sn">4</div>
                <div class="sl">Pembayaran</div>
            </div>
        </div>

        {{-- LEFT --}}
        <div>

            {{-- 1. DATA PENGUNJUNG --}}
            <div class="card reveal">
                <div class="sh">
                    <div class="sh-bar"></div>
                    <div>
                        <h3>Data Pengunjung</h3>
                        <p>Untuk konfirmasi tiket</p>
                    </div>
                </div>
                <div class="form-gap">
                    <div class="fg">
                        <div class="field" id="field-name">
                            <label>Nama Lengkap</label>
                            <input type="text" id="f-name" placeholder="Masukkan nama lengkap" autocomplete="name">
                            <span class="field-err">Nama wajib diisi</span>
                        </div>
                        {{-- Nomor HP / WA --}}
                        <div class="field" id="field-phone">
                            <label>Nomor HP / WA</label>
                            <div style="display:flex;gap:8px;width:100%;box-sizing:border-box;">
                                <select id="f-phone-code"
                                    style="width:90px;min-width:90px;max-width:90px;padding:11px 6px;border:1.5px solid var(--gray-mid);border-radius:var(--radius-sm);background:#fff;font-family:'Inter',sans-serif;font-size:12px;color:#1a1445;outline:none;appearance:none;-webkit-appearance:none;flex-shrink:0;box-sizing:border-box;">
                                    <option value="+62">🇮🇩 +62</option>
                                    <option value="+1">🇺🇸 +1</option>
                                    <option value="+44">🇬🇧 +44</option>
                                    <option value="+61">🇦🇺 +61</option>
                                    <option value="+65">🇸🇬 +65</option>
                                    <option value="+60">🇲🇾 +60</option>
                                    <option value="+66">🇹🇭 +66</option>
                                    <option value="+81">🇯🇵 +81</option>
                                    <option value="+82">🇰🇷 +82</option>
                                    <option value="+86">🇨🇳 +86</option>
                                    <option value="+91">🇮🇳 +91</option>
                                    <option value="+31">🇳🇱 +31</option>
                                    <option value="+49">🇩🇪 +49</option>
                                    <option value="+33">🇫🇷 +33</option>
                                </select>
                                <input type="tel" id="f-phone" placeholder="8xxxxxxxxxx" autocomplete="tel"
                                    style="flex:1;min-width:0;width:0;padding:11px 14px;border:1.5px solid var(--gray-mid);border-radius:var(--radius-sm);background:#fff;font-family:'Inter',sans-serif;font-size:13px;color:#1a1445;outline:none;box-sizing:border-box;">
                            </div>
                            <span class="field-err">Nomor HP wajib diisi</span>
                        </div>
                    </div>
                    <div class="fg full">
                        <div class="field" id="field-email">
                            <label>Email</label>
                            <input type="email" id="f-email" placeholder="email@contoh.com" autocomplete="email">
                            <span class="field-err">Format email tidak valid</span>
                        </div>
                    </div>
                    <div class="fg">
                        {{-- Kota & Negara Asal --}}
                        <div class="field">
                            <label>Kota & Negara Asal</label>
                            <input type="text" id="f-city" placeholder="e.g. Bandung, Indonesia / Tokyo, Japan"
                                autocomplete="address-level2">
                        </div>

                    </div>
                </div>

            </div>

            {{-- 2. PILIH TANGGAL --}}
            <div class="card reveal" style="transition-delay:.1s">
                <div class="sh">
                    <div class="sh-bar"></div>
                    <div>
                        <h3>Pilih Tanggal</h3>
                        <p>Tersedia setiap hari</p>
                    </div>
                </div>
                <div class="cal-hdr">
                    <div class="cal-month" id="cal-title"></div>
                    <div class="cal-navs">
                        <button class="cal-btn" onclick="chMonth(-1)" aria-label="Bulan sebelumnya">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button class="cal-btn" onclick="chMonth(1)" aria-label="Bulan berikutnya">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="cal-grid" id="cal-grid"></div>
            </div>

            {{-- 3. PILIH SESI --}}
            <div class="card reveal" style="transition-delay:.2s">
                <div class="sh">
                    <div class="sh-bar"></div>
                    <div>
                        <h3>Pilih Sesi</h3>
                        <p>Durasi 90 menit tiap sesi</p>
                    </div>
                </div>
                <div id="sess-box">
                    <div class="es">
                        <svg width="38" height="38" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p>Pilih tanggal terlebih dahulu</p>
                    </div>
                </div>
            </div>

            {{-- 4. JENIS TIKET --}}
            <div class="card reveal" style="transition-delay:.3s">
                <div class="sh">
                    <div class="sh-bar"></div>
                    <div>
                        <h3>Jenis Tiket</h3>
                        <p>Termasuk welcome drink &amp; souvenir</p>
                    </div>
                </div>
                <div id="tkt-box">
                    <div class="es">
                        <svg width="38" height="38" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        <p>Pilih sesi terlebih dahulu</p>
                    </div>
                </div>
            </div>

        </div>{{-- end left --}}

        {{-- RIGHT PANEL --}}
        <div class="order-panel">

            <div class="sum-card reveal">
                <div class="sum-hdr">
                    <p>Total Pembayaran</p>
                    <div class="sum-price" id="sum-price">Rp 0 <small>/ kunjungan</small></div>
                </div>
                <div class="sum-body">
                    <div class="sum-info">
                        <div class="sum-row-info">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div><span class="lbl">Tanggal</span><strong id="sum-date">—</strong></div>
                        </div>
                        <div class="sum-row-info">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div><span class="lbl">Sesi</span><strong id="sum-sess">—</strong></div>
                        </div>
                        <div class="sum-row-info">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            <div><span class="lbl">Tiket</span><strong id="sum-qty">0 tiket</strong></div>
                        </div>
                    </div>
                    <div class="sum-divider"></div>
                    <div class="sum-rows" id="sum-rows"></div>
                    <div class="sum-total" id="sum-total" style="display:none">
                        <span class="tl">Total</span>
                        <span class="tv" id="sum-tv">Rp 0</span>
                    </div>

                    <button id="btn-pay" class="btn-pay" onclick="handlePay()" disabled>
                        Lanjut Pembayaran
                    </button>
                    <div class="secure-note">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Pembayaran aman via Midtrans
                    </div>

                    {{-- PAYMENT SELECTOR --}}
                    <div id="payment-selector-wrapper">
                        <div style="padding-top: 15px; border-top: 1px solid var(--gray-soft);">
                            <h4 style="font-size: 13px; color: #1a1445;">Pilih Metode Pembayaran</h4>

                            <div class="pay-meth-grid">
                                <div class="pay-meth-item selected" onclick="selectPayment('qris', event)">
                                    <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Logo_QRIS.svg" alt="QRIS"
                                        style="height:24px;">
                                    <span>QRIS (GoPay, dll)</span>
                                </div>
                                <div class="pay-meth-item" onclick="selectPayment('bca_va', event)">
                                    <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Bank_Central_Asia.svg"
                                        alt="BCA" style="height:16px;">
                                    <span>BCA VA</span>
                                </div>
                                <div class="pay-meth-item" onclick="selectPayment('bni_va', event)">
                                    <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Bank_Negara_Indonesia_logo_(2004).svg"
                                        alt="BNI" style="height:14px;">
                                    <span>BNI VA</span>
                                </div>

                                <div class="pay-meth-item" onclick="selectPayment('bri_va', event)">
                                    <img src="https://commons.wikimedia.org/wiki/Special:FilePath/BANK_BRI_logo.svg"
                                        alt="BRI" style="height:16px;">
                                    <span>BRI VA</span>
                                </div>
                                <!-- Mandiri -->
                                <div class="pay-meth-item" onclick="selectPayment('mandiri_va', event)">
                                    <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Bank_Mandiri_logo_2016.svg"
                                        alt="Mandiri" style="height:18px;">
                                    <span>Mandiri VA</span>
                                </div>

                                <!-- Permata -->
                                <div class="pay-meth-item" onclick="selectPayment('permata_va', event)">
                                    <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Permata_Bank_(2024).svg"
                                        alt="Permata" style="height:20px;">
                                    <span>Permata VA</span>
                                </div>
                            </div>
                            <button id="btn-confirm-pay" class="btn-pay" style="margin-top: 15px;"
                                onclick="processPayment()">
                                Bayar Sekarang
                            </button>
                        </div>
                    </div>

                    {{-- PAYMENT INSTRUCTION --}}
                    <div id="payment-instruction-wrapper">
                        <div class="inst-box">
                            <div id="inst-va-content" style="display: none;">
                                <h4>Transfer ke Virtual Account</h4>
                                <div class="inst-va">
                                    <div class="va-num" id="va-number-display">0000 0000 0000</div>
                                </div>
                                <p style="font-size: 11px; color: var(--gray-text); margin-bottom: 15px;">
                                    Salin nomor di atas dan gunakan menu Transfer > Virtual Account di aplikasi m-banking
                                    atau ATM Anda.
                                </p>
                            </div>

                            <div id="inst-qr-content" style="display: none;">
                                <h4>Scan QR Code</h4>
                                <div class="inst-qr">
                                    <img src="" id="qr-image-display" alt="QR Code">
                                </div>
                                <p style="font-size: 11px; color: var(--gray-text); margin-bottom: 15px;">
                                    Buka aplikasi GoPay, OVO, DANA, atau e-wallet lainnya lalu scan QR code ini.
                                </p>
                            </div>

                            <div class="inst-status">
                                <div class="spinner"></div>
                                Menunggu Pembayaran...
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="policy reveal">
                <p style="margin-bottom:10px"><strong>Keterangan:</strong></p>

                <div
                    style="margin-top:10px;display:flex;flex-direction:column;gap:6px;color:rgba(255,255,255,.42);font-size:10px;line-height:1.75">
                    <div style="display:flex;gap:8px"><span style="color:var(--gold);flex-shrink:0">•</span><span>Data yang
                            sudah diisi lengkap akan kami reservasikan. Mohon maaf apabila formulir tidak diisi / tidak
                            lengkap, maka kami belum dapat mereservasikan.</span></div>
                    <div style="display:flex;gap:8px"><span style="color:var(--gold);flex-shrink:0">•</span><span>Dilarang
                            membawa makan/minum dari luar</span></div>
                    <div style="display:flex;gap:8px"><span style="color:var(--gold);flex-shrink:0">•</span><span>Dilarang
                            membuang sampah rombongan di seluruh area Saung Angklung Udjo</span></div>
                    <div style="display:flex;gap:8px"><span style="color:var(--gold);flex-shrink:0">•</span><span>Disarankan
                            untuk hadir 30 menit sebelum pertunjukan dimulai</span></div>
                </div>

            </div>
        </div>{{-- end right --}}

    </div>{{-- end wrap --}}

    {{-- TOAST --}}
    <div class="toast" id="toast" role="alert" aria-live="polite"><span id="toast-msg">—</span></div>

@endsection

@push('scripts')
    <script>
        const MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
            'November', 'Desember'
        ];
        const DAYS = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

        const NOW = new Date();
        const TODAY_Y = NOW.getFullYear(),
            TODAY_M = NOW.getMonth(),
            TODAY_D = NOW.getDate();

        const TICKETS = [{
            id: 'dom-dew',
            name: 'Domestik — Dewasa',
            desc: 'WNI, 18 tahun ke atas',
            price: 85000
        },
        {
            id: 'dom-pel',
            name: 'Domestik — Anak',
            desc: 'WNI di bawah 18 th ',
            price: 60000
        },
        {
            id: 'int-dew',
            name: 'Internasional — Dewasa',
            desc: 'WNA, 18 tahun ke atas',
            price: 120000
        },
        {
            id: 'int-pel',
            name: 'Internasional — Anak',
            desc: 'WNA di bawah 18 tahun',
            price: 85000
        },
        ];

        let calM = TODAY_M,
            calY = TODAY_Y;
        let selDate = null,
            selSess = null;
        const qty = {};
        TICKETS.forEach(t => qty[t.id] = 0);

        /* ── CALENDAR ── */
        function renderCal() {
            document.getElementById('cal-title').textContent = `${MONTHS[calM]} ${calY}`;
            const g = document.getElementById('cal-grid');
            g.innerHTML = '';
            DAYS.forEach(d => {
                const e = document.createElement('div');
                e.className = 'cdn';
                e.textContent = d;
                g.appendChild(e);
            });
            const firstDay = new Date(calY, calM, 1).getDay();
            const totalDays = new Date(calY, calM + 1, 0).getDate();
            for (let i = 0; i < firstDay; i++) {
                const e = document.createElement('div');
                e.className = 'cd empty';
                g.appendChild(e);
            }
            for (let d = 1; d <= totalDays; d++) {
                const isPast = (calY < TODAY_Y) || (calY === TODAY_Y && calM < TODAY_M) || (calY === TODAY_Y && calM ===
                    TODAY_M && d < TODAY_D);
                const isToday = calY === TODAY_Y && calM === TODAY_M && d === TODAY_D;
                const ds = fmt(calY, calM, d);
                let cls = 'cd' + (isPast ? ' past' : ' has') + (isToday ? ' today' : '') + (ds === selDate ? ' sel' : '');
                const e = document.createElement('div');
                e.className = cls;
                e.textContent = d;
                e.setAttribute('role', 'button');
                if (!isPast) e.onclick = () => pickDate(ds, d);
                g.appendChild(e);
            }
        }

        function fmt(y, m, d) {
            return `${y}-${String(m + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
        }

        function chMonth(dir) {
            calM += dir;
            if (calM < 0) {
                calM = 11;
                calY--;
            }
            if (calM > 11) {
                calM = 0;
                calY++;
            }
            renderCal();
        }

        function pickDate(ds, dayNum) {
            selDate = ds;
            selSess = null;
            TICKETS.forEach(t => qty[t.id] = 0);
            renderCal();
            renderSess();
            renderTkts();
            updateSum();
            document.getElementById('sum-date').textContent = `${dayNum} ${MONTHS[calM]} ${calY}`;
            document.getElementById('sum-sess').textContent = '—';
        }

        /* ── SESSIONS ── */
        function getSess(ds) {
            const [y, m, d] = ds.split('-').map(Number);
            const day = new Date(y, m - 1, d).getDay();
            if (day === 0) return [{
                id: 'pagi',
                t: '10.00 – 11.30 WIB',
                l: 'Sesi Pagi',
                s: 500
            }, {
                id: 'sore',
                t: '15.30 – 17.00 WIB',
                l: 'Sesi Sore',
                s: 500
            }];
            if (day === 6) return [{
                id: 'siang',
                t: '13.00 – 14.30 WIB',
                l: 'Sesi Siang',
                s: 500
            }, {
                id: 'sore',
                t: '15.30 – 17.00 WIB',
                l: 'Sesi Sore',
                s: 489
            }];
            return [{
                id: 'reg',
                t: '15.30 – 17.00 WIB',
                l: 'Regular Show',
                s: 456
            }];
        }

        function renderSess() {
            const b = document.getElementById('sess-box');
            if (!selDate) {
                b.innerHTML =
                    `<div class="es"><svg width="38" height="38" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><p>Pilih tanggal terlebih dahulu</p></div>`;
                return;
            }
            b.innerHTML = '<div class="sess-grid">' + getSess(selDate).map(s => `
                            <div class="sess-item${selSess === s.id ? ' sel' : ''}" onclick="pickSess('${s.id}','${s.t}')" role="button" tabindex="0">
                              <div><div class="sess-time">${s.t}</div><div class="sess-label" style="margin-top:4px">${s.l}</div></div>
                              <div class="sess-check"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                            </div>`).join('') + '</div>';
        }

        function pickSess(id, t) {
            selSess = id;
            TICKETS.forEach(tk => qty[tk.id] = 0);
            renderSess();
            renderTkts();
            document.getElementById('sum-sess').textContent = t;
            updateSum();
        }

        /* ── TICKETS ── */
        function renderTkts() {
            const b = document.getElementById('tkt-box');
            if (!selSess) {
                b.innerHTML =
                    `<div class="es"><svg width="38" height="38" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg><p>Pilih sesi terlebih dahulu</p></div>`;
                return;
            }
            b.innerHTML = '<div class="tkt-list">' + TICKETS.map(t => `
                            <div class="tkt-row${qty[t.id] > 0 ? ' has' : ''}">
                              <div class="tkt-info">
                                <div class="tkt-name">${t.name}</div>
                                <div class="tkt-desc">${t.desc} &nbsp;·&nbsp; <strong style="color:#1a1445">Rp ${n(t.price)}</strong></div>
                              </div>
                              <div class="tkt-price"><small>per orang</small>Rp ${n(t.price)}</div>
                              <div class="qty-ctrl">
                                <button class="qty-btn" onclick="chQty('${t.id}',-1)"${qty[t.id] === 0 ? ' disabled' : ''}>−</button>
                                <span class="qty-num">${qty[t.id]}</span>
                                <button class="qty-btn" onclick="chQty('${t.id}',1)">+</button>
                              </div>
                            </div>`).join('') + '</div>';
        }

        function chQty(id, d) {
            qty[id] = Math.max(0, qty[id] + d);
            renderTkts();
            updateSum();
        }

        /* ── SUMMARY ── */
        function updateSum() {
            let sub = 0,
                totalQ = 0,
                rows = '';
            TICKETS.forEach(t => {
                if (qty[t.id] > 0) {
                    const s = qty[t.id] * t.price;
                    sub += s;
                    totalQ += qty[t.id];
                    rows +=
                        `<div class="sum-row"><span>${t.name} ×${qty[t.id]}</span><span class="val">Rp ${n(s)}</span></div>`;
                }
            });
            document.getElementById('sum-rows').innerHTML = rows;
            document.getElementById('sum-qty').textContent = totalQ > 0 ? `${totalQ} tiket` : '0 tiket';
            document.getElementById('sum-price').innerHTML = (totalQ > 0 ? `Rp ${n(sub)}` : 'Rp 0') +
                ' <small>/ kunjungan</small>';
            const tot = document.getElementById('sum-total');
            if (totalQ > 0) {
                tot.style.display = 'flex';
                document.getElementById('sum-tv').textContent = `Rp ${n(sub)}`;
            } else {
                tot.style.display = 'none';
            }
            updSteps(totalQ);
            document.getElementById('btn-pay').disabled = !(selDate && selSess && totalQ > 0);
        }

        function updSteps(q) {
            const s1 = document.getElementById('stp1'),
                s2 = document.getElementById('stp2'),
                s3 = document.getElementById('stp3'),
                s4 = document.getElementById('stp4'),
                l12 = document.getElementById('l12'),
                l23 = document.getElementById('l23'),
                l34 = document.getElementById('l34');
            s1.className = 'step active';
            if (selDate) {
                s2.className = 'step done';
                l12.className = 'sline done';
            } else {
                s2.className = 'step';
                l12.className = 'sline';
            }
            if (q > 0) {
                s3.className = 'step done';
                l23.className = 'sline done';
            } else if (selSess) {
                s3.className = 'step active';
                l23.className = 'sline';
            } else {
                s3.className = 'step';
                l23.className = 'sline';
            }
            s4.className = 'step';
            l34.className = 'sline';
        }

        /* ── VALIDATION ── */
        function validateForm() {
            const name = document.getElementById('f-name').value.trim();
            const phone = document.getElementById('f-phone').value.trim();
            const email = document.getElementById('f-email').value.trim();
            const setErr = (id, err) => document.getElementById(id).classList.toggle('has-err', err);
            setErr('field-name', !name);
            setErr('field-phone', !phone);
            setErr('field-email', !email || !email.includes('@') || !email.includes('.'));
            if (!name || !phone || !email || !email.includes('@') || !email.includes('.')) {
                const f = document.querySelector('.field.has-err input');
                if (f) {
                    f.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    f.focus();
                }
                return false;
            }
            return true;
        }

        /* ── PAYMENT ── */
        let selectedPaymentMethod = 'qris';
        let pollingInterval = null;

        function selectPayment(method, event) {
            selectedPaymentMethod = method;
            document.querySelectorAll('.pay-meth-item').forEach(el => el.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
        }

        async function handlePay() {
            if (!validateForm()) {
                showToast('⚠ Lengkapi data pengunjung terlebih dahulu', 'err');
                return;
            }
            // Sembunyikan tombol bayar awal, tampilkan pilihan metode bayar
            document.getElementById('btn-pay').style.display = 'none';
            document.getElementById('payment-selector-wrapper').classList.add('active');
            document.getElementById('payment-selector-wrapper').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        async function processPayment() {
            const btn = document.getElementById('btn-confirm-pay');
            btn.classList.add('loading');
            btn.disabled = true;
            document.getElementById('stp4').className = 'step active';
            document.getElementById('l34').className = 'sline done';

            const items = TICKETS.filter(t => qty[t.id] > 0).map(t => ({
                id: t.id,
                name: t.name,
                price: t.price,
                quantity: qty[t.id]
            }));
            const total = items.reduce((s, i) => s + i.price * i.quantity, 0);
            const payload = {
                payment_method: selectedPaymentMethod,
                customer: {
                    name: document.getElementById('f-name').value.trim(),
                    phone: (document.getElementById('f-phone-code').value + document.getElementById('f-phone').value.trim()),
                    email: document.getElementById('f-email').value.trim(),
                    city: document.getElementById('f-city').value.trim(),
                },
                booking: {
                    date: selDate,
                    session: selSess,
                    items,
                    total
                }
            };

            try {
                const res = await fetch('{{ route('tickets.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();
                if (!res.ok) throw new Error(data.error || 'Server error');

                btn.classList.remove('loading');

                // Sembunyikan selector, tampilkan instruksi
                document.getElementById('payment-selector-wrapper').style.display = 'none';
                const instWrapper = document.getElementById('payment-instruction-wrapper');
                instWrapper.classList.add('active');

                if (selectedPaymentMethod.endsWith('_va')) {
                    document.getElementById('inst-qr-content').style.display = 'none';
                    document.getElementById('inst-va-content').style.display = 'block';
                    document.getElementById('va-number-display').textContent = data.payment_data.va_number || data.payment_data.bill_key || 'N/A';
                } else if (selectedPaymentMethod === 'qris') {
                    document.getElementById('inst-va-content').style.display = 'none';
                    document.getElementById('inst-qr-content').style.display = 'block';
                    document.getElementById('qr-image-display').src = data.payment_data.qr_url;
                }

                // Scroll ke instruksi
                instWrapper.scrollIntoView({ behavior: 'smooth', block: 'center' });

                // Mulai auto polling
                startPolling(data.order_code);

            } catch (e) {
                btn.classList.remove('loading');
                btn.disabled = false;
                showToast('❌ ' + (e.message || 'Terjadi kesalahan, coba lagi.'), 'err');
                console.error('Error:', e);
            }
        }

        function startPolling(orderCode) {
            if (pollingInterval) clearInterval(pollingInterval);
            pollingInterval = setInterval(async () => {
                try {
                    const res = await fetch(`/tiket/status/${orderCode}`);
                    const data = await res.json();
                    if (data.status === 'paid') {
                        clearInterval(pollingInterval);
                        window.location.href = '/tiket/sukses/' + orderCode; // langsung redirect

                    } else if (data.status === 'cancelled') {
                        clearInterval(pollingInterval);
                        showToast('❌ Pembayaran dibatalkan atau kedaluwarsa.', 'err');
                        setTimeout(() => window.location.reload(), 2000);
                    }
                } catch (e) {
                    console.error('Polling error', e);
                }
            }, 5000);
        }
        /* ── HELPERS ── */
        function n(v) {
            return v.toLocaleString('id-ID');
        }
        let toastTimer;

        function showToast(msg, type = '') {
            const t = document.getElementById('toast');
            document.getElementById('toast-msg').textContent = msg;
            t.className = `toast ${type} show`;
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => t.classList.remove('show'), 3800);
        }
        ['f-name', 'f-phone', 'f-email'].forEach(id => {
            document.getElementById(id)?.addEventListener('input', () => {
                const m = {
                    'f-name': 'field-name',
                    'f-phone': 'field-phone',
                    'f-email': 'field-email'
                };
                document.getElementById(m[id])?.classList.remove('has-err');
            });
        });

        /* ── INIT ── */
        document.addEventListener('DOMContentLoaded', () => {
            renderCal();
            updateSum();
            const obs = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting) e.target.classList.add('active');
                });
            }, {
                threshold: .1
            });
            document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
        });
    </script>
@endpush