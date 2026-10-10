@extends('layouts.app')

@push('styles')
<style>
    /* ====================================================================
       BERANDA — "FILM" SCROLL (scroll = timeline video)
       ==================================================================== */
    .film { position: relative; background: var(--nu-green-dark); }
    .film-stage { position: relative; min-height: calc(100svh - var(--nu-nav-h)); overflow: hidden; isolation: isolate; color: #fff; }

    /* Mode film aktif (diset oleh JS bila gerak tidak dikurangi) */
    .film-on .film { height: 480vh; }
    .film-on .film-stage { position: sticky; top: var(--nu-nav-h); height: calc(100svh - var(--nu-nav-h)); min-height: 0; }

    .f-bg { position: absolute; inset: 0; z-index: -5; background: radial-gradient(ellipse 80% 70% at 50% 30%, #0b6e44 0%, #055631 48%, #00402a 100%); }
    .f-pattern { position: absolute; inset: -20%; z-index: -4; opacity: .55; will-change: transform;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='96' height='96' viewBox='0 0 96 96' fill='none' stroke='%23ffffff' stroke-opacity='.07' stroke-width='1.2'%3E%3Crect x='24' y='24' width='48' height='48'/%3E%3Crect x='24' y='24' width='48' height='48' transform='rotate(45 48 48)'/%3E%3Ccircle cx='48' cy='48' r='9'/%3E%3C/svg%3E");
        background-size: 96px 96px; }
    .f-glow { position: absolute; left: 50%; top: 34%; width: 760px; height: 760px; margin: -380px 0 0 -380px; border-radius: 50%; z-index: -3; background: radial-gradient(circle, rgba(252,209,43,.20), rgba(252,209,43,0) 62%); will-change: transform, opacity; }
    .f-layer { position: absolute; z-index: -2; pointer-events: none; will-change: transform, opacity; }
    .f-layer img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .f-mosque { left: 0; bottom: 0; width: min(38vw, 560px); height: 86%; transform-origin: 0% 100%;
        -webkit-mask-image: radial-gradient(ellipse 100% 95% at 0% 100%, #000 52%, transparent 100%); mask-image: radial-gradient(ellipse 100% 95% at 0% 100%, #000 52%, transparent 100%); }
    .f-mosque img { object-position: left bottom; }
    .f-flag { right: 0; top: 0; width: min(30vw, 440px); height: 92%; transform-origin: 100% 40%;
        -webkit-mask-image: radial-gradient(ellipse 100% 100% at 100% 40%, #000 45%, transparent 100%); mask-image: radial-gradient(ellipse 100% 100% at 100% 40%, #000 45%, transparent 100%); }
    .f-flag img { object-position: 20% center; }
    .f-vignette { position: absolute; inset: 0; z-index: -1; pointer-events: none; background: radial-gradient(ellipse 60% 55% at 50% 42%, rgba(0,50,32,.55), rgba(0,50,32,0) 70%), linear-gradient(to bottom, rgba(0,40,26,0) 60%, rgba(0,40,26,.55)); }
    .f-orn { position: absolute; left: 0; right: 0; bottom: 0; height: 90px; z-index: 6; pointer-events: none; }
    .f-orn svg { position: absolute; bottom: -2px; width: 300px; height: 90px; }
    .f-orn .l { left: 0; } .f-orn .r { right: 0; transform: scaleX(-1); }

    .scene { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 24px 20px 56px; }
    html:not(.film-on) .scene { position: relative; inset: auto; }
    html:not(.film-on) .s-hero { min-height: calc(100svh - var(--nu-nav-h) - 80px); }
    html:not(.film-on) .s-stats { padding-top: 10px; padding-bottom: 60px; }
    html:not(.film-on) .s-chapter, html:not(.film-on) .iris { display: none; }

    /* ---------- Scene 1 : Hero ---------- */
    .s-hero { z-index: 3; }
    .hero-inner { display: flex; flex-direction: column; align-items: center; will-change: transform, opacity; max-width: 860px; }
    .hero-badge { display: inline-flex; align-items: center; gap: 8px; padding: 7px 18px; border-radius: 999px; border: 1px solid rgba(252,209,43,.55); background: rgba(0,60,40,.45); backdrop-filter: blur(6px); color: #f3f8f5; font-size: 10.5px; font-weight: 700; letter-spacing: .09em; text-transform: uppercase; }
    .hero-badge::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--nu-gold); box-shadow: 0 0 0 4px rgba(252,209,43,.2); }
    .hero-emblem { width: clamp(86px, 13vh, 116px); aspect-ratio: 1; margin: clamp(10px, 2.2vh, 22px) 0 clamp(6px, 1.4vh, 14px); border-radius: 50%; padding: 5px; background: linear-gradient(145deg, #ffe680, #fcd12b 45%, #d9a90f); box-shadow: 0 18px 44px rgba(0,0,0,.4), 0 0 0 8px rgba(252,209,43,.12); }
    .hero-emblem > div { width: 100%; height: 100%; border-radius: 50%; background: radial-gradient(circle at 35% 30%, #0b8a58, #045c38); display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--nu-gold); overflow: hidden; border: 2px solid rgba(255,255,255,.85); }
    .hero-emblem img { width: 100%; height: 100%; object-fit: contain; background: #fff; }
    .hero-emblem i { font-size: clamp(28px, 4.6vh, 40px); }
    .hero-emblem small { font-size: 8px; font-weight: 800; letter-spacing: .14em; color: #fff; margin-top: 3px; line-height: 1.15; }
    .hero-title { font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: clamp(46px, 8.4vh, 78px); line-height: 1.04; margin: 0; letter-spacing: -.01em; text-shadow: 0 6px 30px rgba(0,0,0,.35); }
    .hero-quote { margin: clamp(8px, 1.6vh, 14px) 0 0; font-size: clamp(16px, 2.6vh, 21px); font-weight: 700; color: #fff; }
    .hero-desc { margin: clamp(8px, 1.6vh, 14px) 0 0; max-width: 560px; font-size: clamp(13px, 1.9vh, 15px); line-height: 1.65; color: #e1efe8; }
    .hero-cta { display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 12px; margin-top: clamp(14px, 3vh, 26px); }

    .intro > * { opacity: 0; transform: translateY(26px); animation: nuIntro .9s cubic-bezier(.2,.7,.2,1) forwards; }
    .intro > *:nth-child(1) { animation-delay: .05s; } .intro > *:nth-child(2) { animation-delay: .18s; transform: scale(.7) translateY(0); }
    .intro > *:nth-child(3) { animation-delay: .32s; } .intro > *:nth-child(4) { animation-delay: .44s; }
    .intro > *:nth-child(5) { animation-delay: .55s; } .intro > *:nth-child(6) { animation-delay: .66s; }
    @keyframes nuIntro { to { opacity: 1; transform: none; } }

    .scroll-hint { position: absolute; left: 50%; bottom: 18px; transform: translateX(-50%); z-index: 7; display: flex; flex-direction: column; align-items: center; gap: 6px; font-size: 10px; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; color: rgba(255,255,255,.75); }
    .scroll-hint .mouse { width: 20px; height: 32px; border: 1.5px solid rgba(255,255,255,.7); border-radius: 12px; position: relative; }
    .scroll-hint .mouse::after { content: ''; position: absolute; left: 50%; top: 6px; width: 3px; height: 7px; margin-left: -1.5px; border-radius: 2px; background: var(--nu-gold); animation: nuWheel 1.6s infinite; }
    @keyframes nuWheel { 0% { opacity: 1; transform: translateY(0); } 100% { opacity: 0; transform: translateY(11px); } }
    html:not(.film-on) .scroll-hint { display: none; }

    /* ---------- Scene 2 : Statistik ---------- */
    .s-stats { z-index: 4; perspective: 1100px; }
    .film-on .s-stats { opacity: 0; pointer-events: none; }
    .stats-kicker { display: inline-flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; color: var(--nu-gold); }
    .stats-kicker::before, .stats-kicker::after { content: ''; width: 28px; height: 1px; background: rgba(252,209,43,.6); }
    .stats-title { font-family: 'Playfair Display', Georgia, serif; font-size: clamp(28px, 4.6vw, 48px); font-weight: 700; margin: 10px 0 clamp(18px, 4vh, 38px); line-height: 1.12; }
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; width: min(1000px, 100%); }
    .stat-card { background: #fff; color: var(--nu-ink); border-radius: 16px; padding: 24px 12px 20px; box-shadow: 0 24px 50px rgba(0,30,18,.35); will-change: transform, opacity; }
    .stat-ico { width: 40px; height: 40px; border-radius: 50%; margin: 0 auto 8px; display: grid; place-items: center; font-size: 17px; }
    .stat-num { font-size: clamp(30px, 3.4vw, 40px); font-weight: 800; line-height: 1.05; color: #1a2b24; font-variant-numeric: tabular-nums; }
    .stat-lbl { margin-top: 5px; font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: #5f6f68; }
    .ic-green { background: #dcf4ea; color: #1f9d6b; } .ic-gold { background: #fdf0cf; color: #e0961a; }
    .ic-blue { background: #dde9fb; color: #3b72d6; } .ic-violet { background: #e8e1fa; color: #7655d6; }
    @media (max-width: 760px) { .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; } .stat-card { padding: 18px 8px 16px; } }

    /* ---------- Scene 3 : Chapter (iris wipe) ---------- */
    .iris { position: absolute; inset: 0; z-index: 8; pointer-events: none; clip-path: circle(0% at 50% 58%); will-change: clip-path;
        background: radial-gradient(ellipse 70% 60% at 50% 40%, #ffffff 0%, var(--nu-bg-mint) 100%); }
    .iris::before { content: ''; position: absolute; inset: 0; opacity: .7;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='96' height='96' viewBox='0 0 96 96' fill='none' stroke='%23027f52' stroke-opacity='.07' stroke-width='1.2'%3E%3Crect x='24' y='24' width='48' height='48'/%3E%3Crect x='24' y='24' width='48' height='48' transform='rotate(45 48 48)'/%3E%3Ccircle cx='48' cy='48' r='9'/%3E%3C/svg%3E"); }
    .s-chapter { z-index: 9; color: var(--nu-ink); pointer-events: none; }
    .film-on .s-chapter { opacity: 0; }
    .chapter-tag { display: inline-flex; align-items: center; gap: 8px; padding: 7px 14px; border-radius: 999px; background: var(--nu-mint); color: var(--nu-green-700); font-size: 11px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
    .chapter-title { font-family: 'Playfair Display', Georgia, serif; font-size: clamp(36px, 6.6vw, 84px); line-height: 1.04; font-weight: 800; margin: 18px 0 0; color: #0d3a28; max-width: 900px; }
    .chapter-title em { font-style: normal; color: var(--nu-green); }
    .chapter-line { width: 90px; height: 4px; border-radius: 3px; margin: 24px auto 0; background: linear-gradient(90deg, var(--nu-green), var(--nu-gold)); }

    /* ====================================================================
       SECTION LANJUTAN (juga di-scrub oleh scroll)
       ==================================================================== */
    .sec { position: relative; padding: 70px 20px; }
    .wrap { max-width: 1120px; margin: 0 auto; }
    .film-on [data-scrub], .film-on [data-clip] { opacity: 0; }
    [data-scrub], [data-clip], [data-parallax] { will-change: transform, opacity; }

    .sec-head { display: flex; align-items: center; gap: 12px; margin-bottom: 22px; }
    .sec-ico { width: 34px; height: 34px; border-radius: 10px; background: var(--nu-green); color: #fff; display: grid; place-items: center; font-size: 15px; box-shadow: 0 8px 18px rgba(2,127,82,.3); }
    .sec-title { font-family: 'Playfair Display', Georgia, serif; font-size: clamp(22px, 2.6vw, 28px); font-weight: 700; color: #123b2b; margin: 0; }
    .sec-more { margin-left: auto; font-size: 11px; font-weight: 700; color: var(--nu-green); text-decoration: none; white-space: nowrap; }
    .sec-more:hover { color: var(--nu-green-dark); }
    .sec-more i { font-size: 9px; margin-left: 3px; }

    /* About */
    .about { background: linear-gradient(to bottom, var(--nu-bg-mint), var(--nu-bg) 220px); padding-top: 40px; overflow: hidden; }
    .about-grid { display: grid; gap: 44px; grid-template-columns: 1fr; align-items: center; }
    @media (min-width: 900px) { .about-grid { grid-template-columns: 1.05fr .95fr; gap: 64px; } }
    .about p.lead { font-size: 15px; line-height: 1.8; color: #4a5a53; margin: 0 0 22px; max-width: 520px; }
    .vm-grid { display: grid; gap: 14px; grid-template-columns: 1fr; max-width: 520px; }
    @media (min-width: 560px) { .vm-grid { grid-template-columns: 1fr 1fr; } }
    .vm-card { background: #fff; border: 1px solid var(--nu-line); border-radius: 14px; padding: 18px; box-shadow: 0 10px 26px rgba(2,60,40,.06); transition: transform .3s, box-shadow .3s; }
    .vm-card:hover { transform: translateY(-5px); box-shadow: 0 18px 36px rgba(2,60,40,.12); }
    .vm-ico { width: 28px; height: 28px; border-radius: 8px; display: grid; place-items: center; font-size: 13px; margin-bottom: 8px; }
    .vm-card h3 { margin: 0 0 4px; font-size: 14px; font-weight: 800; color: #17352a; }
    .vm-card p { margin: 0; font-size: 12px; line-height: 1.6; color: #5b6b64; }
    .link-arrow { display: inline-flex; align-items: center; gap: 8px; margin-top: 22px; font-size: 12px; font-weight: 800; color: var(--nu-green-dark); text-decoration: none; }
    .link-arrow i { font-size: 10px; transition: transform .2s; }
    .link-arrow:hover i { transform: translateX(5px); }

    .contact-stack { position: relative; max-width: 440px; margin: 0 auto; width: 100%; }
    .contact-stack::before { content: ''; position: absolute; inset: 22px -16px -16px 22px; border-radius: 26px; background: linear-gradient(145deg, #dff3ea, #c8ebdb); opacity: .85; transform: rotate(1.8deg); }
    .contact-card { position: relative; background: #fff; border-radius: 22px; padding: 26px; box-shadow: 0 28px 60px rgba(2,60,40,.16); }
    .cc-top { display: flex; align-items: center; gap: 14px; padding-bottom: 18px; border-bottom: 1px solid var(--nu-line); }
    .cc-logo { width: 46px; height: 46px; border-radius: 12px; background: var(--nu-green-dark); color: var(--nu-gold); display: grid; place-items: center; font-size: 20px; overflow: hidden; }
    .cc-logo img { width: 100%; height: 100%; object-fit: cover; }
    .cc-top strong { display: block; font-size: 15px; color: #16342a; line-height: 1.2; }
    .cc-top span { font-size: 12px; color: #64756d; }
    .cc-list { list-style: none; margin: 0; padding: 18px 0 8px; display: grid; gap: 14px; font-size: 13px; color: #33463e; }
    .cc-list li { display: flex; align-items: flex-start; gap: 12px; }
    .cc-list i { width: 28px; height: 28px; border-radius: 50%; background: var(--nu-green-light); color: var(--nu-green); display: grid; place-items: center; font-size: 12px; flex-shrink: 0; }
    .cc-help { margin-top: 14px; padding: 12px 14px; border-radius: 12px; background: var(--nu-green-light); display: flex; align-items: center; gap: 12px; }
    .cc-help .txt { flex: 1; } .cc-help small { display: block; font-size: 10px; color: var(--nu-green); font-weight: 700; } .cc-help b { font-size: 13px; color: #123b2b; }
    .cc-wa { width: 40px; height: 40px; border-radius: 50%; background: var(--nu-green-dark); color: #fff; display: grid; place-items: center; font-size: 19px; text-decoration: none; transition: transform .2s, background .2s; }
    .cc-wa:hover { transform: scale(1.1) rotate(-6deg); background: var(--nu-green); }

    /* Banom */
    .banom { background: #fff; }
    .banom-grid { display: grid; gap: 18px; grid-template-columns: 1fr; }
    @media (min-width: 640px) { .banom-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 960px) { .banom-grid { grid-template-columns: repeat(3, 1fr); } }
    .b-card { background: var(--nu-bg); border: 1px solid var(--nu-line); border-radius: 18px; padding: 22px; display: flex; flex-direction: column; justify-content: space-between; gap: 16px; transition: transform .3s, box-shadow .3s, background .3s; }
    .b-card:hover { transform: translateY(-6px); background: #fff; box-shadow: 0 20px 40px rgba(2,60,40,.12); }
    .b-top { display: flex; align-items: center; gap: 14px; }
    .b-logo { width: 52px; height: 52px; border-radius: 14px; background: var(--nu-green-light); color: var(--nu-green); display: grid; place-items: center; font-size: 22px; flex-shrink: 0; }
    .b-logo img { width: 38px; height: 38px; object-fit: contain; }
    .b-card h3 { margin: 0; font-size: 15px; font-weight: 800; color: #16342a; line-height: 1.25; }
    .b-chip { display: inline-block; margin-top: 4px; padding: 2px 9px; border-radius: 6px; background: var(--nu-gold-soft); color: #9a6f00; font-size: 10.5px; font-weight: 800; }
    .b-card p { margin: 0; font-size: 12.5px; line-height: 1.65; color: #5b6b64; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .b-foot { display: flex; align-items: center; justify-content: space-between; padding-top: 14px; border-top: 1px solid var(--nu-line); font-size: 11.5px; color: #7a8a83; }
    .b-foot a { color: var(--nu-green); font-weight: 800; text-decoration: none; } .b-foot a:hover { color: var(--nu-green-dark); }
    .empty-box { grid-column: 1 / -1; text-align: center; padding: 30px; color: #8a9a93; font-size: 13px; }
    .empty-box i { display: block; font-size: 26px; margin-bottom: 8px; }

    /* Warta + Agenda */
    .news { background: var(--nu-bg); }
    .news-grid { display: grid; gap: 44px; grid-template-columns: 1fr; }
    @media (min-width: 1000px) { .news-grid { grid-template-columns: 1.55fr 1fr; gap: 56px; } }
    .posts { display: grid; gap: 16px; grid-template-columns: 1fr; }
    @media (min-width: 560px) { .posts { grid-template-columns: repeat(3, 1fr); } }
    .p-card { background: #fff; border: 1px solid var(--nu-line); border-radius: 10px; overflow: hidden; display: flex; flex-direction: column; transition: transform .3s, box-shadow .3s; }
    .p-card:hover { transform: translateY(-6px); box-shadow: 0 18px 36px rgba(2,60,40,.14); }
    .p-img { position: relative; aspect-ratio: 16 / 9; overflow: hidden; background: linear-gradient(135deg, #0a6b42, #055631); }
    .p-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .6s; }
    .p-card:hover .p-img img { transform: scale(1.07); }
    .p-img .ph { position: absolute; inset: 0; display: grid; place-items: center; color: rgba(255,255,255,.35); font-size: 28px; }
    .p-tag { position: absolute; left: 8px; bottom: 8px; padding: 3px 9px; border-radius: 6px; font-size: 9.5px; font-weight: 800; color: #fff; background: rgba(2,127,82,.88); backdrop-filter: blur(4px); }
    .p-body { padding: 12px 12px 14px; display: flex; flex-direction: column; gap: 8px; flex: 1; }
    .p-body h3 { margin: 0; font-size: 12.5px; line-height: 1.4; font-weight: 700; color: #17352a; }
    .p-body h3 a { color: inherit; text-decoration: none; } .p-body h3 a:hover { color: var(--nu-green); }
    .p-date { margin-top: auto; padding-top: 8px; border-top: 1px solid var(--nu-line); font-size: 10.5px; color: #75867e; display: flex; align-items: center; gap: 6px; }

    .agenda-list { display: grid; gap: 14px; }
    .a-item { display: flex; align-items: flex-start; gap: 14px; padding: 4px 6px 4px 0; text-decoration: none; color: inherit; transition: transform .25s; }
    .a-item:hover { transform: translateX(6px); }
    .a-date { width: 48px; flex-shrink: 0; padding: 7px 0; border-radius: 10px; background: var(--nu-green-light); text-align: center; color: #0c6b45; transition: background .25s, color .25s; }
    .a-item:hover .a-date { background: var(--nu-green); color: #fff; }
    .a-date b { display: block; font-size: 19px; line-height: 1; font-weight: 800; } .a-date span { font-size: 11px; font-weight: 700; }
    .a-info h3 { margin: 0 0 5px; font-size: 13px; font-weight: 700; color: #17352a; line-height: 1.35; }
    .a-meta { display: grid; gap: 3px; font-size: 11px; color: #6c7d75; }
    .a-meta i { color: var(--nu-green); width: 13px; text-align: center; margin-right: 3px; font-size: 10px; }

    /* Galeri */
    .gal { background: var(--nu-bg-mint); overflow: hidden; }
    .gal-strip { display: grid; gap: 14px; grid-template-columns: repeat(2, 1fr); }
    @media (min-width: 700px) { .gal-strip { grid-template-columns: repeat(5, 1fr); } }
    .g-item { position: relative; display: block; border-radius: 12px; overflow: hidden; aspect-ratio: 4 / 5; background: var(--nu-green-dark); box-shadow: 0 12px 28px rgba(2,60,40,.14); }
    @media (min-width: 700px) { .g-item { aspect-ratio: 3 / 4; } .g-item:nth-child(even) { margin-top: 26px; } .gal-strip { padding-bottom: 26px; } }
    .g-item .pimg { position: absolute; inset: -12% 0; will-change: transform; }
    .g-item img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .6s; }
    .g-item:hover img { transform: scale(1.08); }
    .g-item .ph { position: absolute; inset: 0; display: grid; place-items: center; color: rgba(255,255,255,.4); font-size: 26px; }
    .g-cap { position: absolute; inset: auto 0 0 0; padding: 30px 12px 11px; background: linear-gradient(to top, rgba(0,35,22,.88), rgba(0,35,22,0)); color: #fff; font-size: 11.5px; font-weight: 700; line-height: 1.3; }
    .g-cap small { display: block; font-size: 10px; font-weight: 600; color: var(--nu-gold); margin-bottom: 2px; }

    /* CTA infaq */
    .cta { position: relative; overflow: hidden; background: linear-gradient(135deg, #013c2a, #055631 60%, #027f52); color: #fff; padding: 90px 20px; text-align: center; }
    .cta-bg { position: absolute; inset: -15% 0; opacity: .16; background: url('{{ asset('images/nu/hero-mosque.jpg') }}') center / cover no-repeat; mix-blend-mode: luminosity; will-change: transform; }
    .cta::after { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 60% 70% at 50% 50%, rgba(252,209,43,.14), transparent 70%); pointer-events: none; }
    .cta .wrap { position: relative; z-index: 2; max-width: 760px; }
    .cta-ico { width: 64px; height: 64px; margin: 0 auto 18px; border-radius: 50%; border: 2px solid var(--nu-gold); background: rgba(255,255,255,.08); color: var(--nu-gold); display: grid; place-items: center; font-size: 24px; }
    .cta h2 { font-family: 'Playfair Display', Georgia, serif; font-size: clamp(28px, 4.4vw, 44px); line-height: 1.15; margin: 0 0 14px; }
    .cta p { margin: 0 auto 28px; font-size: 14.5px; line-height: 1.75; color: #d6ebe1; max-width: 600px; }
    .cta-row { display: flex; flex-wrap: wrap; gap: 14px; justify-content: center; }

    @media (max-width: 640px) {
        .sec { padding: 54px 18px; }
        .f-mosque { width: 62vw; height: 52%; opacity: .75; } .f-flag { width: 44vw; height: 46%; }
        .f-orn svg { width: 170px; height: 52px; }
        .f-flag { -webkit-mask-image: radial-gradient(ellipse 110% 100% at 100% 0%, #000 38%, transparent 100%); mask-image: radial-gradient(ellipse 110% 100% at 100% 0%, #000 38%, transparent 100%); }
    }
    @media (prefers-reduced-motion: reduce) {
        .intro > * { animation: none; opacity: 1; transform: none; }
        html { scroll-behavior: auto; }
    }
</style>
@endpush

@section('content')
@php
    $logo = data_get($profile, 'logo');
    $orgName = data_get($profile, 'nama_organisasi') ?: 'NU Ranting';
    $tagline = data_get($profile, 'tagline') ?: 'Menegakkan Ajaran Islam Ahlussunnah Wal Jamaah';
    $heroDesc = 'Selamat datang di website resmi Pengurus Ranting Nahdlatul Ulama. Mari bersama-sama menjaga nilai-nilai Islam yang damai, toleran dan penuh keberkahan.';
    $galleryItems = collect($galleries ?? [])->take(5);
@endphp

<!-- ============================================================== -->
<!--  FILM : hero → statistik → bab "Tentang Kami"  (di-scrub scroll) -->
<!-- ============================================================== -->
<section id="film" class="film" aria-label="Beranda">
    <div class="film-stage" id="film-stage">
        <div class="f-bg"></div>
        <div class="f-pattern" id="f-pattern"></div>
        <div class="f-glow" id="f-glow"></div>
        <div class="f-layer f-mosque" id="f-mosque"><img src="{{ asset('images/nu/hero-mosque.jpg') }}" alt="" loading="eager"></div>
        <div class="f-layer f-flag" id="f-flag"><img src="{{ asset('images/nu/hero-flag.jpg') }}" alt="" loading="eager"></div>
        <div class="f-vignette"></div>

        <!-- Scene 1 : Hero -->
        <div class="scene s-hero" id="s-hero">
            <div class="hero-inner intro" id="hero-inner">
                <div class="hero-badge">
                    <span>{{ data_get($profile, 'tingkat') ?: 'Pengurus Ranting' }} Nahdlatul Ulama &bull; {{ data_get($profile, 'wilayah') ?: 'Kecamatan / Desa' }}</span>
                </div>
                <div class="hero-emblem">
                    <div>
                        @if($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="Logo NU">
                        @else
                            <i class="fas fa-star-and-crescent"></i>
                            <small>NAHDLATUL<br>ULAMA</small>
                        @endif
                    </div>
                </div>
                <h1 class="hero-title">{{ $orgName }}</h1>
                <p class="hero-quote">&ldquo;{{ $tagline }}&rdquo;</p>
                <p class="hero-desc">{{ $heroDesc }}</p>
                <div class="hero-cta">
                    <a href="{{ route('daftar-anggota') }}" class="nu-btn nu-btn-gold"><i class="fas fa-id-card"></i> Daftar Anggota Online</a>
                    <a href="{{ route('donasi.index') }}" class="nu-btn nu-btn-ghost"><i class="fas fa-hand-holding-heart"></i> Infaq &amp; Donasi</a>
                    <a href="{{ route('berita.index') }}" class="nu-btn nu-btn-text nu-btn-link">Warta Berita <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Scene 2 : Statistik -->
        <div class="scene s-stats" id="s-stats">
            <div class="stats-head" id="stats-head">
                <span class="stats-kicker">Jam'iyyah dalam angka</span>
                <h2 class="stats-title">Berkhidmah bersama jamaah</h2>
            </div>
            <div class="stats-grid">
                <div class="stat-card" data-stat>
                    <div class="stat-ico ic-green"><i class="fas fa-users"></i></div>
                    <div class="stat-num" data-count="{{ (int) ($stats['total_members'] ?? 0) }}">{{ number_format($stats['total_members'] ?? 0) }}</div>
                    <div class="stat-lbl">Anggota Aktif</div>
                </div>
                <div class="stat-card" data-stat>
                    <div class="stat-ico ic-gold"><i class="fas fa-sitemap"></i></div>
                    <div class="stat-num" data-count="{{ (int) ($stats['total_banoms'] ?? 0) }}">{{ $stats['total_banoms'] ?? 0 }}</div>
                    <div class="stat-lbl">Badan Otonom</div>
                </div>
                <div class="stat-card" data-stat>
                    <div class="stat-ico ic-blue"><i class="fas fa-calendar-days"></i></div>
                    <div class="stat-num" data-count="{{ (int) ($stats['total_agendas'] ?? 0) }}">{{ $stats['total_agendas'] ?? 0 }}</div>
                    <div class="stat-lbl">Agenda Kegiatan</div>
                </div>
                <div class="stat-card" data-stat>
                    <div class="stat-ico ic-violet"><i class="fas fa-file-lines"></i></div>
                    <div class="stat-num" data-count="{{ (int) ($stats['total_posts'] ?? 0) }}">{{ $stats['total_posts'] ?? 0 }}</div>
                    <div class="stat-lbl">Warta &amp; Berita</div>
                </div>
            </div>
        </div>

        <!-- Gold ornament -->
        <div class="f-orn" id="f-orn" aria-hidden="true">
            <svg class="l" viewBox="0 0 300 90" fill="none"><path d="M0 70 C40 70 52 52 70 52 C92 52 96 74 118 74 C140 74 142 56 166 56 C190 56 196 82 230 82 C260 82 280 90 300 90" stroke="#fcd12b" stroke-width="2.2" stroke-linecap="round"/><path d="M0 84 C34 84 46 68 64 68 C84 68 88 86 108 86 C128 86 134 72 154 72" stroke="#fcd12b" stroke-opacity=".5" stroke-width="1.4" stroke-linecap="round"/></svg>
            <svg class="r" viewBox="0 0 300 90" fill="none"><path d="M0 70 C40 70 52 52 70 52 C92 52 96 74 118 74 C140 74 142 56 166 56 C190 56 196 82 230 82 C260 82 280 90 300 90" stroke="#fcd12b" stroke-width="2.2" stroke-linecap="round"/><path d="M0 84 C34 84 46 68 64 68 C84 68 88 86 108 86 C128 86 134 72 154 72" stroke="#fcd12b" stroke-opacity=".5" stroke-width="1.4" stroke-linecap="round"/></svg>
        </div>

        <!-- Scene 3 : iris wipe + judul bab -->
        <div class="iris" id="iris"></div>
        <div class="scene s-chapter" id="s-chapter">
            <span class="chapter-tag"><i class="fas fa-mosque"></i> Tentang Kami</span>
            <h2 class="chapter-title">Khidmah <em>Jam'iyyah</em><br>Nahdlatul Ulama</h2>
            <div class="chapter-line"></div>
        </div>

        <div class="scroll-hint" id="scroll-hint"><span>Gulir</span><div class="mouse"></div></div>
    </div>
</section>

<!-- ============================================================== -->
<!--  TENTANG KAMI                                                   -->
<!-- ============================================================== -->
<section class="sec about">
    <div class="wrap about-grid">
        <div>
            <p class="lead" data-scrub>
                {{ \Illuminate\Support\Str::limit(data_get($profile, 'tentang') ?: 'Pengurus Ranting Nahdlatul Ulama adalah struktur organisasi NU di tingkat desa/kelurahan yang bersentuhan langsung dengan denyut nadi jamaah nahdliyin. Kami berkhidmat untuk mewujudkan kemaslahatan umat dalam bingkai Islam rahmatan lil alamin.', 320) }}
            </p>
            <div class="vm-grid">
                <div class="vm-card" data-scrub data-delay="60">
                    <div class="vm-ico ic-green"><i class="fas fa-eye"></i></div>
                    <h3>Visi</h3>
                    <p>{{ data_get($profile, 'visi') ?: 'Terwujudnya jamaah nahdliyin yang mandiri, berilmu, dan berakhlakul karimah.' }}</p>
                </div>
                <div class="vm-card" data-scrub data-delay="140">
                    <div class="vm-ico ic-gold"><i class="fas fa-bullseye"></i></div>
                    <h3>Misi</h3>
                    <p>{{ data_get($profile, 'misi') ?: 'Menguatkan dakwah aswaja, pemberdayaan ekonomi umat, dan kaderisasi berkelanjutan.' }}</p>
                </div>
            </div>
            <a href="{{ route('profil') }}" class="link-arrow" data-scrub data-delay="200">Baca Profil Lengkap &amp; Sejarah <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="contact-stack" data-scrub data-dir="right">
            <div class="contact-card">
                <div class="cc-top">
                    <div class="cc-logo">
                        @if($logo)<img src="{{ asset('storage/' . $logo) }}" alt="Logo NU">@else<i class="fas fa-star-and-crescent"></i>@endif
                    </div>
                    <div>
                        <strong>{{ $orgName }}</strong>
                        <span>{{ data_get($profile, 'wilayah') ?: 'Ranting NU' }}</span>
                    </div>
                </div>
                <ul class="cc-list">
                    <li><i class="fas fa-location-dot"></i><span>{{ data_get($profile, 'alamat_lengkap') ?: 'Sekretariat Ranting Nahdlatul Ulama' }}</span></li>
                    <li><i class="fas fa-phone"></i><span>{{ data_get($profile, 'telepon') ?: '+62 812-3456-7890' }}</span></li>
                    <li><i class="fas fa-envelope"></i><span>{{ data_get($profile, 'email') ?: 'ranting@nu.or.id' }}</span></li>
                </ul>
                <div class="cc-help">
                    <div class="txt"><small>Butuh Bantuan / Informasi?</small><b>Hubungi Layanan Pengurus</b></div>
                    <a class="cc-wa" target="_blank" rel="noopener" aria-label="WhatsApp" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', data_get($profile, 'whatsapp') ?: '6281234567890') }}"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!--  BANOM                                                          -->
<!-- ============================================================== -->
<section class="sec banom">
    <div class="wrap">
        <div class="sec-head" data-scrub>
            <span class="sec-ico"><i class="fas fa-sitemap"></i></span>
            <h2 class="sec-title">Badan Otonom (Banom)</h2>
            <a href="{{ route('banom.index') }}" class="sec-more">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
                @include('components.banom-chart', ['banoms' => $banoms, 'detail' => false])
    </div>
</section>

<!-- ============================================================== -->
<!--  WARTA & AGENDA                                                 -->
<!-- ============================================================== -->
<section class="sec news">
    <div class="wrap news-grid">
        <div>
            <div class="sec-head" data-scrub>
                <span class="sec-ico"><i class="fas fa-newspaper"></i></span>
                <h2 class="sec-title">Warta Nahdliyyin</h2>
                <a href="{{ route('berita.index') }}" class="sec-more">Lihat Semua Berita <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="posts">
                @forelse($latestPosts as $post)
                    <article class="p-card" data-scrub data-delay="{{ $loop->index * 110 }}">
                        <a href="{{ route('berita.show', $post->slug) }}" class="p-img" aria-label="{{ $post->title }}">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" loading="lazy">
                            @else
                                <span class="ph"><i class="fas fa-newspaper"></i></span>
                            @endif
                            @if($post->category)<span class="p-tag">{{ $post->category->name }}</span>@endif
                        </a>
                        <div class="p-body">
                            <h3><a href="{{ route('berita.show', $post->slug) }}">{{ $post->title }}</a></h3>
                            <div class="p-date"><i class="fas fa-calendar-days"></i>{{ ($post->published_at ?? $post->created_at)->translatedFormat('j F Y') }}</div>
                        </div>
                    </article>
                @empty
                    <div class="empty-box"><i class="fas fa-newspaper"></i>Belum ada warta berita yang dipublikasikan.</div>
                @endforelse
            </div>
        </div>

        <div>
            <div class="sec-head" data-scrub data-dir="right">
                <span class="sec-ico"><i class="fas fa-calendar-days"></i></span>
                <h2 class="sec-title">Agenda &amp; Kegiatan</h2>
                <a href="{{ route('agenda.index') }}" class="sec-more">Lihat Semua Agenda <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="agenda-list">
                @forelse($upcomingAgendas as $agenda)
                    <a href="{{ route('agenda.show', $agenda->slug) }}" class="a-item" data-scrub data-dir="right" data-delay="{{ $loop->index * 110 }}">
                        <div class="a-date"><b>{{ $agenda->start_at->format('d') }}</b><span>{{ $agenda->start_at->translatedFormat('M') }}</span></div>
                        <div class="a-info">
                            <h3>{{ $agenda->title }}</h3>
                            <div class="a-meta">
                                @if($agenda->location)<span><i class="fas fa-location-dot"></i>{{ $agenda->location }}</span>@endif
                                <span><i class="fas fa-clock"></i>{{ $agenda->start_at->format('H:i') }} WIB</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="empty-box"><i class="fas fa-calendar-xmark"></i>Belum ada agenda terdekat yang dijadwalkan.</div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!--  GALERI                                                         -->
<!-- ============================================================== -->
<section class="sec gal">
    <div class="wrap">
        <div class="sec-head" data-scrub>
            <span class="sec-ico"><i class="fas fa-camera"></i></span>
            <h2 class="sec-title">Galeri Jam'iyyah</h2>
            <a href="{{ route('galeri.index') }}" class="sec-more">Lihat Semua Galeri <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="gal-strip">
            @forelse($galleryItems as $gallery)
                <a href="{{ route('galeri.show', $gallery->slug) }}" class="g-item" data-clip data-delay="{{ $loop->index * 80 }}">
                    <div class="pimg" data-parallax="0.10">
                        @if($gallery->cover_image)
                            <img src="{{ asset('storage/' . $gallery->cover_image) }}" alt="{{ $gallery->title }}" loading="lazy">
                        @else
                            <span class="ph"><i class="fas fa-images"></i></span>
                        @endif
                    </div>
                    <div class="g-cap"><small>{{ $gallery->images->count() }} Foto</small>{{ $gallery->title }}</div>
                </a>
            @empty
                <div class="empty-box"><i class="fas fa-camera"></i>Belum ada album dokumentasi yang diunggah.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!--  CTA INFAQ                                                      -->
<!-- ============================================================== -->
<section class="cta">
    <div class="cta-bg" data-parallax="0.18"></div>
    <div class="wrap">
        <div class="cta-ico" data-scrub><i class="fas fa-hand-holding-heart"></i></div>
        <h2 data-scrub data-delay="80">Salurkan Infaq &amp; Shodaqoh Terbaik Anda</h2>
        <p data-scrub data-delay="140">Dukung gerak dakwah, kemaslahatan santri, pemeliharaan sarana ibadah, dan kemandirian umat melalui infaq jariyah di tingkat ranting.</p>
        <div class="cta-row" data-scrub data-delay="200">
            <a href="{{ route('donasi.index') }}" class="nu-btn nu-btn-gold"><i class="fas fa-donate"></i> Tunaikan Infaq Sekarang</a>
            <a href="{{ route('daftar-anggota') }}" class="nu-btn nu-btn-ghost">Daftar Jadi Bagian Nahdliyin</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
/* =====================================================================
   FILM SCROLL ENGINE
   - Scroll dipetakan ke "timeline" 0..1 (seperti scrubbing video)
   - Posisi scroll diperhalus (inersia) → terasa sinematik
   - Elemen [data-scrub] / [data-clip] / [data-parallax] ikut ter-scrub,
     maju & mundur mengikuti arah scroll (reversibel seperti video)
   ===================================================================== */
(function () {
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var film = document.getElementById('film');
    if (reduce || !film) return;
    document.documentElement.classList.add('film-on');

    var $ = function (id) { return document.getElementById(id); };
    var stage = $('film-stage'), heroInner = $('hero-inner'), sHero = $('s-hero'), sStats = $('s-stats'),
        statsHead = $('stats-head'), iris = $('iris'), chapter = $('s-chapter'), mosque = $('f-mosque'),
        flag = $('f-flag'), pattern = $('f-pattern'), glow = $('f-glow'), orn = $('f-orn'), hint = $('scroll-hint');
    var cards = Array.prototype.slice.call(document.querySelectorAll('[data-stat]'));
    var counters = cards.map(function (c) { return c.querySelector('[data-count]'); });
    var targets = counters.map(function (el) { return parseInt(el.getAttribute('data-count'), 10) || 0; });
    var items = Array.prototype.slice.call(document.querySelectorAll('[data-scrub], [data-clip]'));
    var paras = Array.prototype.slice.call(document.querySelectorAll('[data-parallax]'));

    var clamp = function (v, a, b) { return Math.min(b === undefined ? 1 : b, Math.max(a === undefined ? 0 : a, v)); };
    var seg = function (p, a, b) { return clamp((p - a) / (b - a)); };
    var eo = function (t) { return 1 - Math.pow(1 - t, 3); };
    var eio = function (t) { return t < .5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2; };
    var fmt = function (n) { return n.toLocaleString('id-ID'); };

    var vy = window.scrollY, filmTop = 0, range = 1, vh = window.innerHeight, navH = 72, running = false;

    function measure() {
        vh = window.innerHeight;
        navH = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--nu-nav-h')) || 72;
        filmTop = film.getBoundingClientRect().top + window.scrollY;
        range = Math.max(1, film.offsetHeight - stage.offsetHeight);
    }

    function drawFilm(y) {
        var p = clamp((y - (filmTop - navH)) / range);
        var small = window.innerWidth < 760;

        /* --- kamera: dorong masuk (push-in) ke masjid & bendera --- */
        var push = eio(seg(p, 0, .52));
        mosque.style.transform = 'translate3d(' + (-push * 9) + '%,' + (push * 6) + '%,0) scale(' + (1 + push * (small ? .7 : 1.15)) + ')';
        flag.style.transform = 'translate3d(' + (push * 10) + '%,' + (-push * 4) + '%,0) scale(' + (1 + push * (small ? .6 : 1)) + ')';
        var layerFade = 1 - .88 * eio(seg(p, .18, .46));
        mosque.style.opacity = layerFade; flag.style.opacity = layerFade;
        pattern.style.transform = 'rotate(' + (p * 30) + 'deg) scale(' + (1 + p * .25) + ')';
        glow.style.transform = 'scale(' + (1 + p * 1.4) + ')';
        glow.style.opacity = 1 - seg(p, .45, .7);
        orn.style.opacity = 1 - seg(p, .6, .72);

        /* --- scene 1 : hero keluar --- */
        var h = eio(seg(p, .05, .24));
        heroInner.style.opacity = 1 - h;
        heroInner.style.transform = 'translate3d(0,' + (-h * 90) + 'px,0) scale(' + (1 + h * .12) + ')';
        sHero.style.visibility = h >= 1 ? 'hidden' : 'visible';
        hint.style.opacity = 1 - seg(p, 0, .06);

        /* --- scene 2 : statistik masuk, hitung naik, lalu keluar --- */
        var inn = eio(seg(p, .22, .38)), out = eio(seg(p, .66, .78));
        sStats.style.opacity = inn * (1 - out);
        sStats.style.visibility = (inn <= 0 || out >= 1) ? 'hidden' : 'visible';
        statsHead.style.transform = 'translate3d(0,' + ((1 - inn) * 40 - out * 40) + 'px,0)';
        for (var i = 0; i < cards.length; i++) {
            var e = eo(seg(p, .24 + i * .04, .42 + i * .04));
            cards[i].style.opacity = e;
            cards[i].style.transform = 'translate3d(0,' + ((1 - e) * 150 - out * 70) + 'px,0) rotateX(' + ((1 - e) * 22) + 'deg) scale(' + (.9 + .1 * e - out * .06) + ')';
            var cp = eo(seg(p, .30 + i * .04, .56 + i * .03));
            counters[i].textContent = fmt(Math.round(targets[i] * cp));
        }

        /* --- scene 3 : iris wipe + judul bab --- */
        var ir = eio(seg(p, .70, .93));
        iris.style.clipPath = 'circle(' + (ir * 150) + '% at 50% 58%)';
        var ch = eo(seg(p, .82, .96));
        chapter.style.opacity = ch;
        chapter.style.transform = 'translate3d(0,' + ((1 - ch) * 50) + 'px,0) scale(' + (.93 + .07 * ch) + ')';
    }

    function drawItems(y, sy) {
        var lag = sy - y; /* selisih posisi nyata vs posisi yang diperhalus */
        for (var i = 0; i < items.length; i++) {
            var el = items[i], r = el.getBoundingClientRect(), top = r.top + lag;
            var delay = parseFloat(el.getAttribute('data-delay') || 0) / 1000 * .25;
            var t = clamp((vh * .97 - top) / (vh * .34) - delay);
            var e = eo(t);
            if (el.hasAttribute('data-clip')) {
                el.style.opacity = clamp(e * 2);
                el.style.clipPath = 'inset(' + ((1 - e) * 46) + '% ' + ((1 - e) * 12) + '% ' + ((1 - e) * 0) + '% ' + ((1 - e) * 12) + '% round 12px)';
                el.style.transform = 'translate3d(0,' + ((1 - e) * 36) + 'px,0)';
            } else {
                var dir = el.getAttribute('data-dir');
                var dx = dir === 'right' ? (1 - e) * 60 : 0;
                el.style.opacity = e;
                el.style.transform = 'translate3d(' + dx + 'px,' + ((1 - e) * 54) + 'px,0)';
            }
        }
        for (var j = 0; j < paras.length; j++) {
            var pe = paras[j], pr = pe.parentElement.getBoundingClientRect(), mid = pr.top + lag + pr.height / 2 - vh / 2;
            if (Math.abs(mid) > vh * 1.4) continue;
            pe.style.transform = 'translate3d(0,' + (-mid * parseFloat(pe.getAttribute('data-parallax'))) + 'px,0)';
        }
    }

    function frame() {
        var sy = window.scrollY;
        vy += (sy - vy) * .13;
        if (Math.abs(sy - vy) < .15) vy = sy;
        drawFilm(vy);
        drawItems(vy, sy);
        if (vy !== sy) { requestAnimationFrame(frame); } else { running = false; }
    }
    function kick() { if (!running) { running = true; requestAnimationFrame(frame); } }

    window.addEventListener('scroll', kick, { passive: true });
    window.addEventListener('resize', function () { measure(); kick(); });
    window.addEventListener('load', function () { measure(); kick(); });
    measure(); vy = window.scrollY; drawFilm(vy); drawItems(vy, vy); kick();
})();
</script>
@endpush
