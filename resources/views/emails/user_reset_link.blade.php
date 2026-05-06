<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRemind — Premium Email Templates</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* ─── Reset & Base ─────────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        html {
            font-size: 16px;
            -webkit-text-size-adjust: 100%
        }

        body {
            background: #EFEDE8;
            font-family: 'DM Sans', sans-serif;
            color: #1A1916;
            min-height: 100vh;
        }

        /* ─── Preview Shell ─────────────────────────────────────────── */
        .shell-nav {
            position: sticky;
            top: 0;
            z-index: 200;
            background: rgba(250, 249, 246, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid #DDD9D0;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .shell-logo {
            font-family: 'Instrument Serif', serif;
            font-size: 18px;
            color: #1A1916;
            margin-right: auto;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .shell-logo svg {
            flex-shrink: 0
        }

        .type-btn {
            border: 1px solid #D5D0C8;
            background: #FAFAF7;
            color: #6B6860;
            padding: 7px 18px;
            border-radius: 100px;
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all .18s;
            letter-spacing: .3px;
        }

        .type-btn:hover {
            background: #F0EDE7;
            color: #1A1916;
            border-color: #B8B3AA
        }

        .type-btn.active {
            background: #1A1916;
            color: #FAF9F6;
            border-color: #1A1916;
        }

        /* ─── Page Wrapper ──────────────────────────────────────────── */
        .page {
            display: none
        }

        .page.active {
            display: block
        }

        /* ─── Template Stage ────────────────────────────────────────── */
        .stage {
            background: #EFEDE8;
            min-height: calc(100vh - 56px);
            padding: 40px 20px 60px;
        }

        .stage-label {
            text-align: center;
            margin-bottom: 10px;
        }

        .stage-label h2 {
            font-family: 'DM Sans', sans-serif;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #A09D96;
        }

        .stage-label p {
            font-size: 11.5px;
            color: #B8B3AA;
            margin-top: 3px
        }

        /* Variant tabs */
        .variant-tabs {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-bottom: 28px;
        }

        .vtab {
            border: 1px solid #D5D0C8;
            background: #FAFAF7;
            color: #8C8980;
            padding: 6px 20px;
            border-radius: 100px;
            font-family: 'DM Sans', sans-serif;
            font-size: 11.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all .16s;
            letter-spacing: .2px;
        }

        .vtab:hover {
            background: #F0EDE7;
            color: #1A1916
        }

        .vtab.active {
            background: #1A1916;
            color: #FAF9F6;
            border-color: #1A1916
        }

        .variant {
            display: none
        }

        .variant.active {
            display: block
        }

        /* ─── EMAIL CARD SHELL ──────────────────────────────────────── */
        .em {
            max-width: 600px;
            margin: 0 auto;
            background: #FFFFFF;
            border-radius: 16px;
            overflow: hidden;
            box-shadow:
                0 1px 2px rgba(30, 28, 20, .06),
                0 4px 12px rgba(30, 28, 20, .07),
                0 20px 50px rgba(30, 28, 20, .1);
        }

        /* Accent top stripe */
        .em-stripe {
            height: 4px
        }

        .stripe-blue {
            background: linear-gradient(90deg, #1D4ED8, #3B82F6, #7C3AED)
        }

        .stripe-amber {
            background: linear-gradient(90deg, #B45309, #D97706, #F59E0B)
        }

        .stripe-green {
            background: linear-gradient(90deg, #15803D, #16A34A, #22C55E)
        }

        .stripe-rose {
            background: linear-gradient(90deg, #BE123C, #E11D48, #F43F5E)
        }

        .stripe-slate {
            background: linear-gradient(90deg, #1E293B, #334155, #475569)
        }

        /* ─── SECTION A — Clean Variant (Option A) ───────────────────── */

        /* Hero block */
        .em-hero {
            padding: 44px 48px 36px;
            text-align: center
        }

        .em-hero.left {
            text-align: left
        }

        .icon-ring {
            width: 200px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            padding: 10px 0 20px 0;
        }

        .icon-ring img {
            width: 100%;
        }

        .em-eyebrow {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
            display: block;
        }

        .eyebrow-blue {
            color: #3B82F6
        }

        .eyebrow-amber {
            color: #D97706
        }

        .eyebrow-green {
            color: #16A34A
        }

        .eyebrow-rose {
            color: #E11D48
        }

        .em-h1 {
            font-family: 'Instrument Serif', serif;
            font-size: 34px;
            line-height: 1.15;
            color: #1A1916;
            margin-bottom: 12px;
            letter-spacing: -.4px;
        }

        .em-h1 em {
            font-style: italic
        }

        .em-sub {
            font-size: 14.5px;
            color: #6B6860;
            line-height: 1.65;
            max-width: 400px;
            margin: 0 auto;
        }

        .em-sub.left-align {
            margin: 0
        }

        /* Divider */
        .em-divider {
            height: 1px;
            background: #F0EDE8;
            margin: 0 48px
        }

        /* Body block */
        .em-body {
            padding: 32px 48px
        }

        .body-p {
            font-size: 14px;
            color: #4A4740;
            line-height: 1.7;
            margin-bottom: 22px
        }

        .body-p strong {
            color: #1A1916;
            font-weight: 600
        }

        /* ─── Credentials Box ─────────────────────────────── */
        .creds {
            background: #FAFAF7;
            border: 1px solid #E8E5DF;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .creds-head {
            padding: 10px 18px;
            background: #F5F3EF;
            border-bottom: 1px solid #E8E5DF;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #9C9890;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .cred-item {
            padding: 14px 18px;
            border-bottom: 1px solid #F0EDE8;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .cred-item:last-child {
            border-bottom: none
        }

        .cred-icon {
            width: 34px;
            height: 34px;
            background: #F0EDE8;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cred-label {
            font-size: 10.5px;
            color: #9C9890;
            font-weight: 600;
            display: block;
            margin-bottom: 3px;
            letter-spacing: .3px
        }

        .cred-value {
            font-size: 14px;
            font-weight: 600;
            color: #1A1916
        }

        .cred-value.mono {
            font-family: 'DM Mono', monospace;
            font-size: 13px;
            letter-spacing: 2px;
            color: #1A1916;
        }

        .cred-password {
            display: flex;
            align-items: center;
            gap: 8px
        }

        .pw-dots {
            font-size: 9px;
            letter-spacing: 3px;
            color: #1A1916;
            display: inline-block;
        }

        .pw-tag {
            font-size: 10px;
            font-weight: 600;
            background: #FEF3C7;
            color: #B45309;
            padding: 2px 8px;
            border-radius: 100px;
            border: 1px solid #FDE68A;
        }

        /* ─── Notice / Alert Box ─────────────────────────── */
        .notice {
            border-radius: 10px;
            padding: 14px 16px;
            display: flex;
            gap: 12px;
            margin-bottom: 22px;
        }

        .notice.amber {
            background: #FFFBEB;
            border: 1px solid #FDE68A
        }

        .notice.red {
            background: #FFF1F2;
            border: 1px solid #FECDD3
        }

        .notice.blue {
            background: #EFF6FF;
            border: 1px solid #BFDBFE
        }

        .notice.green {
            background: #F0FDF4;
            border: 1px solid #BBF7D0
        }

        .notice-icon {
            flex-shrink: 0;
            margin-top: 1px
        }

        .notice-title {
            font-size: 12.5px;
            font-weight: 700;
            margin-bottom: 3px
        }

        .notice.amber .notice-title {
            color: #92400E
        }

        .notice.red .notice-title {
            color: #9F1239
        }

        .notice.blue .notice-title {
            color: #1E40AF
        }

        .notice.green .notice-title {
            color: #15803D
        }

        .notice-text {
            font-size: 12px;
            line-height: 1.55
        }

        .notice.amber .notice-text {
            color: #78350F
        }

        .notice.red .notice-text {
            color: #881337
        }

        .notice.blue .notice-text {
            color: #1E3A8A
        }

        .notice.green .notice-text {
            color: #14532D
        }

        /* ─── Buttons ─────────────────────────────────────── */
        .btn-row {
            text-align: center;
            margin-bottom: 16px
        }

        .btn-row.left {
            text-align: left
        }

        .em-btn {
            display: inline-block;
            padding: 14px 36px;
            border-radius: 100px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: .2px;
            transition: all .2s;
        }

        .em-btn.blue {
            background: #1D4ED8;
            color: #fff
        }

        .em-btn.amber {
            background: #B45309;
            color: #fff
        }

        .em-btn.green {
            background: #15803D;
            color: #fff
        }

        .em-btn.rose {
            background: #BE123C;
            color: #fff
        }

        .em-btn.slate {
            background: #1E293B;
            color: #fff
        }

        .em-btn-ghost {
            display: inline-block;
            padding: 10px 24px;
            border-radius: 100px;
            border: 1.5px solid #E0DDD6;
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            color: #6B6860;
            text-decoration: none;
        }

        /* Small button group */
        .btn-sm-group {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 12px
        }

        /* ─── OTP Block ───────────────────────────────────── */
        .otp-block {
            margin-bottom: 8px
        }

        .otp-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #9C9890;
            text-align: center;
            margin-bottom: 14px
        }

        .otp-digits {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 10px
        }

        .otp-d {
            width: 54px;
            height: 64px;
            background: #FAFAF7;
            border: 1.5px solid #E0DDD6;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Mono', monospace;
            font-size: 28px;
            font-weight: 500;
            color: #1A1916;
        }

        .otp-hint {
            font-size: 11.5px;
            color: #B8B3AA;
            text-align: center;
            margin-bottom: 24px
        }

        /* ─── Expiry timer bar ────────────────────────────── */
        .expiry-bar {
            background: #FEF3C7;
            border-top: 1px solid #FDE68A;
            padding: 12px 48px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            color: #92400E;
            font-weight: 500;
        }

        .expiry-bar strong {
            font-weight: 700;
            color: #78350F
        }

        /* ─── Details Card ────────────────────────────────── */
        .detail-card {
            background: #FAFAF7;
            border: 1px solid #E8E5DF;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 22px;
        }

        .detail-card-head {
            padding: 10px 18px;
            background: #F5F3EF;
            border-bottom: 1px solid #E8E5DF;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #9C9890;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-bottom: 1px solid #F0EDE8;
        }

        .detail-grid:last-child {
            border-bottom: none
        }

        .detail-cell {
            padding: 14px 18px
        }

        .detail-cell+.detail-cell {
            border-left: 1px solid #F0EDE8
        }

        .detail-cell-full {
            padding: 14px 18px;
            border-bottom: 1px solid #F0EDE8
        }

        .detail-cell-full:last-child {
            border-bottom: none
        }

        .d-label {
            font-size: 10.5px;
            font-weight: 600;
            color: #A09D96;
            letter-spacing: .3px;
            display: block;
            margin-bottom: 4px;
            text-transform: uppercase
        }

        .d-value {
            font-size: 13.5px;
            font-weight: 600;
            color: #1A1916;
            display: flex;
            align-items: center;
            gap: 6px
        }

        .d-value.accent-blue {
            color: #1D4ED8
        }

        .d-value.accent-green {
            color: #15803D;
            font-size: 15px;
            font-weight: 700
        }

        .d-value.accent-amber {
            color: #B45309
        }

        .d-value.muted {
            color: #6B6860;
            font-weight: 400;
            font-size: 13px;
            line-height: 1.5
        }

        /* ─── Urgency Badge ───────────────────────────────── */
        .urgency {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 100px;
            padding: 5px 14px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .urgency.green {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            color: #15803D
        }

        .urgency.amber {
            background: #FFFBEB;
            border: 1px solid #FDE68A;
            color: #B45309
        }

        .urgency.red {
            background: #FFF1F2;
            border: 1px solid #FECDD3;
            color: #BE123C
        }

        /* ─── Time banner ─────────────────────────────────── */
        .time-strip {
            display: flex;
            border-top: 1px solid #F0EDE8;
            border-bottom: 1px solid #F0EDE8;
            background: #FAFAF7;
        }

        .time-cell {
            flex: 1;
            padding: 16px 20px;
            text-align: center
        }

        .time-cell+.time-cell {
            border-left: 1px solid #F0EDE8
        }

        .t-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #A09D96;
            display: block;
            margin-bottom: 5px
        }

        .t-value {
            font-size: 15px;
            font-weight: 700;
            color: #1A1916;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px
        }

        /* ─── Category pill ───────────────────────────────── */
        .cat-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 100px;
            padding: 3px 12px;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .cat-pill.health {
            background: #F0FDF4;
            color: #15803D;
            border: 1px solid #BBF7D0
        }

        .cat-pill.insurance {
            background: #EFF6FF;
            color: #1D4ED8;
            border: 1px solid #BFDBFE
        }

        .cat-pill.finance {
            background: #FFFBEB;
            color: #B45309;
            border: 1px solid #FDE68A
        }

        /* OR text */
        .or-row {
            text-align: center;
            font-size: 12px;
            color: #B8B3AA;
            padding: 4px 0 16px;
            font-weight: 500
        }

        /* ─── Footer strip ────────────────────────────────── */
        .em-footer {
            padding: 20px 48px;
            background: #FAFAF7;
            border-top: 1px solid #F0EDE8;
            text-align: center;
        }

        .em-footer p {
            font-size: 11.5px;
            color: #B8B3AA;
            line-height: 1.6
        }

        .em-footer a {
            color: #9C9890;
            text-decoration: underline
        }

        .em-footer strong {
            color: #9C9890
        }

        .em-bottom-stripe {
            height: 3px;
            opacity: .5
        }

        /* ─── Responsive ──────────────────────────────────── */
        @media(max-width:640px) {

            .em-hero,
            .em-body,
            .em-band {
                padding-left: 24px;
                padding-right: 24px
            }

            .em-divider {
                margin: 0 24px
            }

            .expiry-bar {
                padding: 12px 24px
            }

            .info-strip {
                padding: 0 24px;
                flex-direction: column
            }

            .info-item+.info-item {
                border-left: none;
                border-top: 1px solid #F0EDE8
            }

            .detail-grid {
                grid-template-columns: 1fr
            }

            .detail-cell+.detail-cell {
                border-left: none;
                border-top: 1px solid #F0EDE8
            }

            .time-strip {
                flex-direction: column
            }

            .time-cell+.time-cell {
                border-left: none;
                border-top: 1px solid #F0EDE8
            }

            .em-footer {
                padding: 16px 24px
            }

            .otp-d {
                width: 44px;
                height: 56px;
                font-size: 22px
            }

            .em-h1,
            .band-h1 {
                font-size: 26px
            }

            .amount-value {
                font-size: 32px
            }

            .countdown-num {
                font-size: 50px
            }

            .btn-sm-group {
                flex-direction: column;
                align-items: center
            }

            .em-band {
                padding-top: 28px;
                padding-bottom: 24px
            }
        }
    </style>
</head>

<body>

    <!-- ═══════════════════════════════════════════════════════
     2. FORGOT PASSWORD
═══════════════════════════════════════════════════════ -->
    <div id="page-forgot" class="page active">
        <div class="stage">

            <!-- ─── FORGOT A ────────────────────────────────────── -->
            <div id="forgot-v1" class="variant active">
                <div class="em">
                    <div class="em-stripe stripe-amber"></div>

                    <div class="em-hero">
                        <div class="icon-ring amber">
                            <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" alt="">
                        </div>
                        <span class="em-eyebrow eyebrow-amber">Password Reset</span>
                        <h1 class="em-h1">Reset your<br><em>password, {{ $user->first_name }}  {{ $user->last_name }}.</em></h1>
                        <p class="em-sub">We received a request to reset the password associated with your account. Use the one-time code below.</p>
                    </div>

                    <div class="em-divider"></div>

                    <div class="em-body">
                        <div class="btn-row" style="margin-bottom:22px">
                            <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" class="em-btn amber">Reset Password &nbsp;
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display:inline;vertical-align:-2px">
                                    <path d="M5 12h14m-7-7 7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                    </div>

                    <div class="expiry-bar">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#B45309" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        This OTP and link expire in &nbsp;<strong>15 minutes</strong>&nbsp; from the time this email was sent.
                    </div>

                    <div class="em-footer">
                        <p style="margin-top:4px">&copy; 2026 Winngoo infotech. All rights reserved</p>
                    </div>
                    <div class="em-stripe stripe-amber em-bottom-stripe"></div>
                </div>
            </div><!-- /forgot-v1 -->

        </div>
    </div><!-- /page-forgot -->


    <script>
        // ── Page switching ──────────────────────────────────────────────
        function show(id, btn) {
            document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('page-' + id).classList.add('active');
            btn.classList.add('active');
        }

        // ── Variant switching ───────────────────────────────────────────
        function switchVariant(page, num, btn) {
            const variants = document.querySelectorAll('#page-' + page + ' .variant');
            variants.forEach(v => v.classList.remove('active'));
            document.getElementById(page + '-v' + num).classList.add('active');
            btn.closest('.variant-tabs').querySelectorAll('.vtab').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
    </script>
</body>

</html>