<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Toko Kue Fanda — Freshly Baked, Made With Love</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
<style>
:root{
  --esp:    #1C0A00;
  --esp-2:  #2D1507;
  --brown:  #4A2510;
  --car:    #C07B3A;
  --gold:   #E8B46D;
  --cream:  #F8F2E5;
  --cream2: #EFE3CE;
  --blush:  #F5CECC;
  --blush2: #EDB8B4;
  --white:  #FFFCF7;
  --muted:  #9B7A5A;
  --r:      20px;
  --pill:   100px;
  --ease:   cubic-bezier(.22,.68,0,1.2);
  --es:     cubic-bezier(.25,.46,.45,.94);
}
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--esp);overflow-x:hidden;cursor:none}
img{display:block;max-width:100%;height:auto}
a{text-decoration:none}ul{list-style:none}
button{font-family:inherit;cursor:none;border:none}

/* CURSOR */
#cur{position:fixed;width:11px;height:11px;background:var(--car);border-radius:50%;pointer-events:none;z-index:9999;transform:translate(-50%,-50%);transition:width .2s,height .2s;mix-blend-mode:multiply}
#cur-r{position:fixed;width:42px;height:42px;border:2px solid var(--car);border-radius:50%;pointer-events:none;z-index:9998;transform:translate(-50%,-50%);opacity:.4;transition:width .3s var(--es),height .3s var(--es)}
body.h #cur{width:18px;height:18px}
body.h #cur-r{width:60px;height:60px;opacity:.18}
::-webkit-scrollbar{width:4px}
::-webkit-scrollbar-thumb{background:var(--car);border-radius:2px}

/* NAVBAR */
.nav{position:fixed;top:0;left:0;right:0;z-index:900;padding:22px 64px;display:flex;align-items:center;justify-content:space-between;transition:all .4s var(--es)}
.nav.stuck{padding:13px 64px;background:rgba(28,10,0,.94);backdrop-filter:blur(18px)}
.nav-logo{font-family:'Kaushan Script',cursive;font-size:1.6rem;color:var(--white)}
.nav-links{display:flex;gap:34px}
.nav-links a{font-size:.82rem;font-weight:400;letter-spacing:.05em;color:rgba(255,252,247,.65);position:relative;transition:color .3s}
.nav-links a::after{content:'';position:absolute;bottom:-3px;left:0;width:0;height:1.5px;background:var(--gold);transition:width .35s var(--es)}
.nav-links a:hover{color:var(--white)}
.nav-links a:hover::after{width:100%}
.nav-r{display:flex;gap:10px;align-items:center}
.nav-icon{width:40px;height:40px;border-radius:50%;border:1.5px solid rgba(255,252,247,.2);background:transparent;display:flex;align-items:center;justify-content:center;transition:all .3s;position:relative}
.nav-icon:hover{background:rgba(255,252,247,.12);border-color:rgba(255,252,247,.5)}
.nav-icon svg{width:18px;height:18px;stroke:var(--white);fill:none;stroke-width:1.6}
.cart-badge{position:absolute;top:-4px;right:-4px;width:18px;height:18px;border-radius:50%;background:var(--gold);color:var(--esp);font-size:.6rem;font-weight:700;display:flex;align-items:center;justify-content:center}
.btn-keluar{padding:10px 24px;border-radius:var(--pill);background:transparent;color:var(--white);font-size:.82rem;font-weight:500;border:1.5px solid rgba(255,252,247,.35);transition:all .3s}
.btn-keluar:hover{background:var(--white);color:var(--esp)}

/* ══════════════════════════════════════
   HERO — Teks di tengah, roti terbang masuk
══════════════════════════════════════ */
.hero{min-height:100vh;background:var(--esp-2);position:relative;overflow:hidden;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:120px 64px 90px;text-align:center}

/* Roti terbang — wrapper untuk fly-in, inner untuk float */
.hf-wrap{position:absolute;pointer-events:none;z-index:1}
.hf-img{border-radius:50%;object-fit:cover;display:block;box-shadow:0 24px 60px rgba(0,0,0,.5)}

/* Posisi akhir masing-masing */
.hf-wrap.tl{top:-2%;left:-1%}
.hf-wrap.tr{top:2%;right:-1%}
.hf-wrap.bl{bottom:0%;left:3%}
.hf-wrap.br{bottom:2%;right:2%}
.hf-wrap.ml{top:42%;left:-2%;transform:translateY(-50%)}
.hf-wrap.mr{top:42%;right:-2%;transform:translateY(-50%)}

.hf-wrap.tl .hf-img{width:clamp(170px,16vw,240px);height:clamp(170px,16vw,240px)}
.hf-wrap.tr .hf-img{width:clamp(190px,18vw,270px);height:clamp(190px,18vw,270px)}
.hf-wrap.bl .hf-img{width:clamp(155px,14vw,215px);height:clamp(155px,14vw,215px)}
.hf-wrap.br .hf-img{width:clamp(175px,16vw,250px);height:clamp(175px,16vw,250px)}
.hf-wrap.ml .hf-img{width:clamp(110px,10vw,155px);height:clamp(110px,10vw,155px)}
.hf-wrap.mr .hf-img{width:clamp(120px,11vw,165px);height:clamp(120px,11vw,165px)}

/* FLY IN animations */
.hf-wrap.tl{animation:flyTL 1.1s .1s cubic-bezier(.22,.68,0,1) forwards}
.hf-wrap.tr{animation:flyTR 1.2s .0s cubic-bezier(.22,.68,0,1) forwards}
.hf-wrap.bl{animation:flyBL 1.1s .25s cubic-bezier(.22,.68,0,1) forwards}
.hf-wrap.br{animation:flyBR 1.2s .15s cubic-bezier(.22,.68,0,1) forwards}
.hf-wrap.ml{animation:flyML 1.0s .35s cubic-bezier(.22,.68,0,1) forwards}
.hf-wrap.mr{animation:flyMR 1.0s .3s cubic-bezier(.22,.68,0,1) forwards}

@keyframes flyTL{from{opacity:0;transform:translate(-130%,-110%) rotate(-20deg)}to{opacity:1;transform:translate(0,0) rotate(-8deg)}}
@keyframes flyTR{from{opacity:0;transform:translate(130%,-100%) rotate(18deg)}to{opacity:1;transform:translate(0,0) rotate(6deg)}}
@keyframes flyBL{from{opacity:0;transform:translate(-120%,110%) rotate(14deg)}to{opacity:1;transform:translate(0,0) rotate(10deg)}}
@keyframes flyBR{from{opacity:0;transform:translate(120%,100%) rotate(-16deg)}to{opacity:1;transform:translate(0,0) rotate(-7deg)}}
@keyframes flyML{from{opacity:0;transform:translateY(-50%) translateX(-120%)}to{opacity:1;transform:translateY(-50%) translateX(0)}}
@keyframes flyMR{from{opacity:0;transform:translateY(-50%) translateX(120%)}to{opacity:1;transform:translateY(-50%) translateX(0)}}

/* FLOAT setelah fly in (pakai delay = durasi fly-in) */
.hf-wrap.tl .hf-img{animation:flt1 7s 1.2s ease-in-out infinite}
.hf-wrap.tr .hf-img{animation:flt2 8s 1.2s ease-in-out infinite}
.hf-wrap.bl .hf-img{animation:flt3 6.5s 1.35s ease-in-out infinite}
.hf-wrap.br .hf-img{animation:flt4 7.5s 1.35s ease-in-out infinite}
.hf-wrap.ml .hf-img{animation:flt5 9s 1.35s ease-in-out infinite}
.hf-wrap.mr .hf-img{animation:flt6 8.5s 1.3s ease-in-out infinite}

@keyframes flt1{0%,100%{transform:translateY(0) rotate(-8deg)}50%{transform:translateY(-18px) rotate(-4deg)}}
@keyframes flt2{0%,100%{transform:translateY(0) rotate(6deg)}50%{transform:translateY(-22px) rotate(10deg)}}
@keyframes flt3{0%,100%{transform:translateY(0) rotate(10deg)}50%{transform:translateY(-14px) rotate(5deg)}}
@keyframes flt4{0%,100%{transform:translateY(0) rotate(-7deg)}50%{transform:translateY(-20px) rotate(-12deg)}}
@keyframes flt5{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
@keyframes flt6{0%,100%{transform:translateY(0)}50%{transform:translateY(-16px)}}

/* Hero center content */
.hero-inner{position:relative;z-index:2}
.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,252,247,.1);border:1px solid rgba(255,252,247,.18);color:var(--gold);font-size:.68rem;font-weight:500;letter-spacing:.18em;text-transform:uppercase;padding:8px 20px;border-radius:var(--pill);margin-bottom:22px;opacity:0;animation:fadeUp .6s .9s forwards}
.bdot{width:6px;height:6px;background:var(--gold);border-radius:50%;animation:blink 2s infinite}
@keyframes blink{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.3;transform:scale(1.6)}}
.hero-name{font-family:'Kaushan Script',cursive;font-size:clamp(72px,13vw,180px);color:var(--blush);line-height:.92;letter-spacing:-.01em;opacity:0;animation:fadeUp .9s .6s var(--es) forwards;position:relative;z-index:2}
.hero-tagline{font-family:'Playfair Display',serif;font-size:clamp(14px,2vw,22px);font-style:italic;color:rgba(255,252,247,.55);margin-top:8px;opacity:0;animation:fadeUp .6s .8s forwards}

/* Tag button "Jelajahi Menu" — seperti di Courante */
.hero-tag{
  display:inline-flex;align-items:center;gap:10px;
  background:var(--white);color:var(--esp);
  font-family:'Playfair Display',serif;font-style:italic;
  font-size:1rem;letter-spacing:.02em;
  padding:14px 32px;border-radius:6px;
  margin-top:32px;
  box-shadow:0 8px 30px rgba(0,0,0,.3);
  cursor:none;transition:transform .3s var(--ease),box-shadow .3s;
  opacity:0;animation:fadeUp .6s 1.05s forwards;
}
.hero-tag:hover{transform:translateY(-3px) rotate(-1deg);box-shadow:0 14px 40px rgba(0,0,0,.4)}
.hero-tag svg{width:16px;height:16px;stroke:var(--car);fill:none;stroke-width:2.5}

.hero-stats{display:flex;gap:52px;justify-content:center;margin-top:60px;padding-top:36px;border-top:1px solid rgba(255,252,247,.1);opacity:0;animation:fadeUp .6s 1.2s forwards}
.stat{display:flex;flex-direction:column;align-items:center;gap:4px}
.stat-n{font-family:'Playfair Display',serif;font-size:2.4rem;font-weight:900;color:var(--blush);line-height:1;letter-spacing:-.02em}
.stat-n sup{font-size:1.2rem;color:var(--gold)}
.stat-l{font-size:.7rem;color:rgba(255,252,247,.4);letter-spacing:.1em;text-transform:uppercase}

@keyframes fadeUp{from{opacity:0;transform:translateY(28px)}to{opacity:1;transform:translateY(0)}}

/* TICKER */
.ticker{background:var(--esp);padding:13px 0;overflow:hidden;display:flex;border-top:1px solid rgba(232,180,109,.1)}
.ticker-track{display:flex;width:max-content;animation:marquee 28s linear infinite}
.ticker-track:hover{animation-play-state:paused}
@keyframes marquee{from{transform:translateX(0)}to{transform:translateX(-50%)}}
.ticker-item{display:flex;align-items:center;gap:20px;padding:0 22px;white-space:nowrap;color:var(--gold);font-size:.7rem;font-weight:500;letter-spacing:.14em;text-transform:uppercase}
.ticker-dot{width:4px;height:4px;background:var(--car);border-radius:50%;flex-shrink:0}

/* ══════════════════════════════════════
   MENU SECTION — Pink bg, gambar lingkaran, zoom hover (Image 3 style)
══════════════════════════════════════ */
.menu-section{padding:90px 64px 100px;background:var(--blush)}
.menu-head{text-align:center;margin-bottom:20px}
.menu-head .stag{display:block;font-size:.68rem;font-weight:500;letter-spacing:.22em;text-transform:uppercase;color:var(--brown);margin-bottom:8px}
.menu-head .sh{font-family:'Kaushan Script',cursive;font-size:clamp(40px,5vw,68px);color:var(--esp);line-height:1}
.menu-desc{text-align:center;font-size:.92rem;line-height:1.8;color:var(--brown);max-width:560px;margin:0 auto 58px;font-style:italic}

/* Circular product grid */
.circle-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:32px 24px}
.c-card{
  display:flex;flex-direction:column;align-items:center;
  cursor:none;
  opacity:0;transform:translateY(32px);
}
.c-card.show{animation:cardIn .65s var(--es) forwards}
.c-card:nth-child(2).show{animation-delay:.1s}
.c-card:nth-child(3).show{animation-delay:.18s}
.c-card:nth-child(4).show{animation-delay:.26s}
.c-card:nth-child(5).show{animation-delay:.08s}
.c-card:nth-child(6).show{animation-delay:.16s}
.c-card:nth-child(7).show{animation-delay:.24s}
@keyframes cardIn{to{opacity:1;transform:translateY(0)}}

.c-img-wrap{
  width:clamp(160px,18vw,230px);height:clamp(160px,18vw,230px);
  border-radius:50%;overflow:hidden;position:relative;
  box-shadow:0 12px 40px rgba(74,37,16,.25);
  transition:transform .45s var(--ease),box-shadow .45s;
  flex-shrink:0;
}
.c-card:hover .c-img-wrap{transform:scale(1.1) translateY(-8px);box-shadow:0 24px 60px rgba(74,37,16,.4)}
.c-img-wrap img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--es)}
.c-card:hover .c-img-wrap img{transform:scale(1.08)}
.c-stok{position:absolute;top:12px;right:12px;font-size:.58rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;padding:4px 11px;border-radius:var(--pill)}
.stok-aman{background:rgba(255,252,247,.9);color:var(--esp)}
.stok-tipis{background:rgba(232,180,109,.92);color:var(--esp)}
.stok-habis{background:rgba(200,60,60,.9);color:#fff}
.c-cat{font-size:.62rem;font-weight:600;letter-spacing:.16em;text-transform:uppercase;color:var(--car);margin-top:20px;margin-bottom:4px}
.c-name{font-family:'Playfair Display',serif;font-size:1.18rem;font-weight:700;color:var(--esp);text-align:center;line-height:1.2}
.c-price{font-family:'Playfair Display',serif;font-size:1.15rem;font-style:italic;font-weight:400;color:var(--brown);margin-top:6px}
.c-add{
  margin-top:12px;
  display:inline-flex;align-items:center;gap:7px;
  padding:8px 20px;border-radius:var(--pill);
  background:var(--esp);color:var(--white);
  font-size:.75rem;font-weight:500;
  opacity:0;transform:translateY(6px);
  transition:opacity .3s,transform .3s,background .3s;
}
.c-card:hover .c-add{opacity:1;transform:translateY(0)}
.c-add:hover{background:var(--car)}
.c-add svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5}

/* See all link */
.see-all-wrap{text-align:center;margin-top:48px}
.see-all{display:inline-flex;align-items:center;gap:8px;color:var(--esp);font-size:.88rem;font-weight:600;letter-spacing:.04em;border-bottom:1.5px solid var(--esp);padding-bottom:2px;transition:gap .3s,color .3s}
.see-all:hover{gap:14px;color:var(--car);border-color:var(--car)}
.see-all svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2.2}

/* ══════════════════════════════════════
   PROMO BANNER
══════════════════════════════════════ */
.promo-wrap{padding:0 64px;background:var(--blush);padding-bottom:90px}
.promo{border-radius:24px;background:var(--esp-2);overflow:hidden;display:grid;grid-template-columns:55% 45%;min-height:440px;position:relative}
.promo::before{content:'';position:absolute;width:500px;height:500px;border-radius:50%;top:-160px;left:-120px;background:radial-gradient(circle,rgba(192,123,58,.15) 0%,transparent 65%);pointer-events:none}
.promo-left{padding:60px 56px;display:flex;flex-direction:column;justify-content:center;position:relative;z-index:2}
.promo-tag{display:flex;align-items:center;gap:10px;font-size:.68rem;font-weight:500;letter-spacing:.2em;text-transform:uppercase;color:var(--car);margin-bottom:14px}
.promo-tag::before{content:'';display:block;width:22px;height:1.5px;background:var(--car)}
.promo-h{font-family:'Kaushan Script',cursive;font-size:clamp(38px,5vw,68px);line-height:1.05;color:var(--white);margin-bottom:14px}
.promo-body{font-size:.88rem;line-height:1.8;color:rgba(255,252,247,.45);max-width:340px;margin-bottom:36px}
.btn-promo{display:inline-flex;align-items:center;gap:11px;padding:14px 36px;border-radius:var(--pill);background:var(--blush);color:var(--esp);font-size:.88rem;font-weight:600;width:fit-content;cursor:none;transition:background .3s,color .3s}
.btn-promo:hover{background:transparent;color:var(--white)}
.btn-promo svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;transition:transform .3s}
.btn-promo:hover svg{transform:translateX(5px)}
.promo-right{position:relative;overflow:hidden}
.promo-imgs{position:absolute;inset:0;display:grid;grid-template-rows:1fr 1fr;gap:2px}
.promo-imgs img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--es)}
.promo:hover .promo-imgs img{transform:scale(1.07)}

/* ══════════════════════════════════════
   TESTIMONIAL — Roti besar di sisi, teks besar (Image 2 & 4 style)
══════════════════════════════════════ */
.testi-section{background:var(--esp-2);overflow:hidden;position:relative}

/* Satu slide testimonial */
.testi-slide{
  min-height:75vh;
  display:grid;grid-template-columns:360px 1fr 360px;
  align-items:center;
  padding:80px 0;
  position:relative;
}
.testi-slide:nth-child(even){background:rgba(0,0,0,.12)}

/* Gambar roti di sisi — besar, seperti Courante */
.testi-food{
  width:100%;height:100%;
  display:flex;align-items:flex-end;
  overflow:hidden;
  position:relative;
}
.testi-food.left{justify-content:flex-end;padding-right:0}
.testi-food.right{justify-content:flex-start;padding-left:0}
.testi-food img{
  width:clamp(250px,28vw,380px);
  height:clamp(300px,36vw,460px);
  object-fit:cover;border-radius:50%;
  box-shadow:0 30px 80px rgba(0,0,0,.5);
  flex-shrink:0;
  transition:transform .6s var(--es);
}
.testi-food.left img{transform:translate(-15%, 15%) rotate(-8deg)}
.testi-food.right img{transform:translate(15%, 15%) rotate(8deg)}
.testi-slide:hover .testi-food.left img{transform:translate(-10%, 8%) rotate(-5deg)}
.testi-slide:hover .testi-food.right img{transform:translate(10%, 8%) rotate(5deg)}

/* Label di atas gambar slide pertama */
.testi-label-tag{
  position:absolute;top:40px;left:50%;transform:translateX(-50%);
  background:var(--white);color:var(--esp);
  font-family:'Playfair Display',serif;font-style:italic;font-size:.95rem;
  padding:11px 28px;border-radius:5px;
  box-shadow:0 6px 24px rgba(0,0,0,.25);
  white-space:nowrap;z-index:2;
}

/* Section label (kiri atas) */
.testi-section-label{
  position:absolute;top:44px;left:64px;
  font-family:'Kaushan Script',cursive;font-size:1.45rem;
  color:rgba(255,252,247,.3);
}

/* Teks tengah testimonial */
.testi-center{
  padding:0 40px;text-align:center;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  position:relative;z-index:1;
}
.testi-sub-label{
  font-family:'Kaushan Script',cursive;
  font-size:clamp(1.2rem,2.5vw,1.8rem);
  color:rgba(255,252,247,.4);
  margin-bottom:20px;
}
.testi-quote-text{
  font-family:'Playfair Display',serif;
  font-size:clamp(22px,3.5vw,46px);
  font-weight:700;line-height:1.2;
  color:var(--white);margin-bottom:28px;
}
.testi-quote-text em{color:var(--gold);font-style:italic}
.testi-name{font-size:.88rem;font-weight:500;color:rgba(255,252,247,.45);letter-spacing:.1em;text-transform:uppercase}
.testi-stars{display:flex;gap:3px;justify-content:center;margin-bottom:6px}
.testi-stars span{color:var(--gold);font-size:.85rem}

/* Section label bawah slide */
.testi-bottom-label{
  text-align:center;padding:40px;
  font-family:'Kaushan Script',cursive;
  font-size:clamp(28px,5vw,56px);
  color:rgba(255,252,247,.12);
  border-top:1px solid rgba(255,252,247,.06);
}

/* ══════════════════════════════════════
   GALLERY
══════════════════════════════════════ */
.gallery-section{padding:90px 0 80px;background:var(--cream2);overflow:hidden}
.gallery-head{padding:0 64px 42px;text-align:left}
.gallery-head .stag{display:block;font-size:.68rem;font-weight:500;letter-spacing:.22em;text-transform:uppercase;color:var(--car);margin-bottom:8px}
.gallery-head .sh{font-family:'Playfair Display',serif;font-size:clamp(34px,4.5vw,58px);font-weight:900;color:var(--esp);line-height:1.05}
.gallery-head .sh em{font-style:italic}
.gallery-track{display:flex;gap:16px;padding:0 64px 10px;overflow-x:auto;-ms-overflow-style:none;scrollbar-width:none}
.gallery-track::-webkit-scrollbar{display:none}
.g-img{flex-shrink:0;width:240px;height:290px;border-radius:18px;overflow:hidden;cursor:none}
.g-img img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--es)}
.g-img:hover img{transform:scale(1.1)}
.gallery-hint{text-align:center;margin-top:18px;font-size:.72rem;color:var(--muted);letter-spacing:.1em}

/* ══════════════════════════════════════
   FOOTER
══════════════════════════════════════ */
footer{background:var(--esp);padding:76px 64px 38px;border-top:1px solid rgba(232,180,109,.08)}
.footer-grid{display:grid;grid-template-columns:1.6fr 1fr 1fr 1fr;gap:52px;margin-bottom:52px;padding-bottom:48px;border-bottom:1px solid rgba(255,252,247,.08)}
.f-logo{font-family:'Kaushan Script',cursive;font-size:1.75rem;color:var(--gold);display:block;margin-bottom:14px}
.f-desc{font-size:.85rem;line-height:1.8;color:rgba(255,252,247,.36);max-width:230px;margin-bottom:22px}
.f-social{display:flex;gap:10px}
.f-soc{width:38px;height:38px;border-radius:50%;border:1.5px solid rgba(255,252,247,.15);display:flex;align-items:center;justify-content:center;transition:all .3s;cursor:none}
.f-soc:hover{background:var(--car);border-color:var(--car)}
.f-soc svg{width:15px;height:15px;stroke:rgba(255,252,247,.5);fill:none;stroke-width:1.6;transition:stroke .3s}
.f-soc:hover svg{stroke:#fff}
.f-col-title{font-size:.85rem;font-weight:500;color:var(--white);margin-bottom:18px}
.f-links{display:flex;flex-direction:column;gap:9px}
.f-links a{font-size:.8rem;color:rgba(255,252,247,.35);transition:color .3s,padding-left .3s;cursor:none}
.f-links a:hover{color:var(--gold);padding-left:5px}
.footer-bottom{display:flex;align-items:center;justify-content:space-between}
.f-copy{font-size:.78rem;color:rgba(255,252,247,.22)}
.f-copy strong{color:rgba(255,252,247,.5);font-weight:500}

/* REVEAL */
.reveal{opacity:0;transform:translateY(34px);transition:opacity .7s var(--es),transform .7s var(--es)}
.reveal.in{opacity:1;transform:translateY(0)}
.reveal-l{opacity:0;transform:translateX(-36px);transition:opacity .7s var(--es),transform .7s var(--es)}
.reveal-l.in{opacity:1;transform:translateX(0)}

/* RESPONSIVE */
@media(max-width:960px){
  .nav{padding:14px 22px}
  .nav.stuck{padding:12px 22px}
  .nav-links{display:none}
  .hero{padding:100px 22px 80px}
  .hf-wrap.ml,.hf-wrap.mr{display:none}
  .hf-wrap.tl .hf-img,.hf-wrap.tr .hf-img{width:120px;height:120px}
  .hf-wrap.bl .hf-img,.hf-wrap.br .hf-img{width:110px;height:110px}
  .menu-section{padding:70px 22px 80px}
  .circle-grid{grid-template-columns:repeat(2,1fr);gap:24px 16px}
  .promo-wrap{padding:0 22px 70px}
  .promo{grid-template-columns:1fr}
  .promo-right{height:200px}
  .promo-left{padding:40px 28px}
  .testi-slide{grid-template-columns:1fr;padding:60px 22px}
  .testi-food{display:none}
  .testi-section-label{left:22px}
  .gallery-section{padding:70px 0}
  .gallery-head{padding:0 22px 32px}
  .gallery-track{padding:0 22px 10px}
  footer{padding:56px 22px 30px}
  .footer-grid{grid-template-columns:1fr 1fr;gap:32px}
  .footer-bottom{flex-direction:column;gap:8px;text-align:center}
}
</style>
</head>
<body>

<div id="cur"></div>
<div id="cur-r"></div>

<!-- ════ NAVBAR ════ -->
<nav class="nav" id="mainNav">
  <a href="#" class="nav-logo">Toko Kue Fanda</a>
  <ul class="nav-links">
    <li><a href="#">Beranda</a></li>
    <li><a href="#menu">Menu</a></li>
    <li><a href="#footer">Kontak</a></li>
    <li><a href="#tentang">Ulasan</a></li>
  </ul>
  <div class="nav-r">
    <button class="nav-icon" title="Keranjang" onclick="window.location.href='order_tambah.php'">
      <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
      <span class="cart-badge" id="cartBadge">0</span>
    </button>
    <button class="nav-icon" title="Akun" onclick="window.location.href='akun.php'">
      <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    </button>
    <button class="btn-keluar" onclick="window.location.href='../index.php'">Keluar</button>
  </div>
</nav>

<!-- ════ HERO — Teks tengah + roti terbang masuk ════ -->
<section class="hero" id="beranda">

  <!-- Roti kiri atas -->
  <div class="hf-wrap tl">
    <img class="hf-img" src="../gambar/nastar.jpeg" alt="">
  </div>
  <!-- Roti kanan atas -->
  <div class="hf-wrap tr">
    <img class="hf-img" src="../gambar/kastangel.jpeg" alt="">
  </div>
  <!-- Roti kiri bawah -->
  <div class="hf-wrap bl">
    <img class="hf-img" src="../gambar/brownis.jpeg" alt="">
  </div>
  <!-- Roti kanan bawah -->
  <div class="hf-wrap br">
    <img class="hf-img" src="../gambar/chocolate_butter.jpeg" alt="">
  </div>
  <!-- Roti kiri tengah -->
  <div class="hf-wrap ml">
    <img class="hf-img" src="../gambar/putri_salju.jpeg" alt="">
  </div>
  <!-- Roti kanan tengah -->
  <div class="hf-wrap mr">
    <img class="hf-img" src="../gambar/strawberry_thumb.jpeg" alt="">
  </div>

  <!-- Konten tengah -->
  <div class="hero-inner">
    <div class="hero-badge"><span class="bdot"></span>Fresh Baked Daily · Semarang</div>
    <h1 class="hero-name">Toko Kue Fanda</h1>
    <p class="hero-tagline">Artisanal Bakery &amp; Kue Buatan Tangan</p>
    <a href="#menu" class="hero-tag">
      Jelajahi Menu
      <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
    <div class="hero-stats">
      <div class="stat">
        <span class="stat-n"><span class="ctr" data-to="7">0</span><sup>+</sup></span>
        <span class="stat-l">Menu Pilihan</span>
      </div>
      <div class="stat">
        <span class="stat-n">4.9<sup>★</sup></span>
        <span class="stat-l">Rating</span>
      </div>
      <div class="stat">
        <span class="stat-n"><span class="ctr" data-to="100">0</span><sup>+</sup></span>
        <span class="stat-l">Pelanggan Puas</span>
      </div>
    </div>
  </div>
</section>

<!-- TICKER -->
<div class="ticker" aria-hidden="true">
  <div class="ticker-track">
    <div class="ticker-item">Fresh Baked Daily<span class="ticker-dot"></span></div>
    <div class="ticker-item">Premium Quality<span class="ticker-dot"></span></div>
    <div class="ticker-item">Pengiriman ke Seluruh Wilayah<span class="ticker-dot"></span></div>
    <div class="ticker-item">Rating 4.9 Bintang<span class="ticker-dot"></span></div>
    <div class="ticker-item">Dipanggang Dengan Cinta<span class="ticker-dot"></span></div>
    <div class="ticker-item">Fresh Baked Daily<span class="ticker-dot"></span></div>
    <div class="ticker-item">Premium Quality<span class="ticker-dot"></span></div>
    <div class="ticker-item">Pengiriman ke Seluruh Wilayah<span class="ticker-dot"></span></div>
    <div class="ticker-item">Rating 4.9 Bintang<span class="ticker-dot"></span></div>
    <div class="ticker-item">Dipanggang Dengan Cinta<span class="ticker-dot"></span></div>
  </div>
</div>

<!-- ════ MENU — Pink bg, lingkaran, zoom hover ════ -->
<section class="menu-section" id="menu">
  <div class="menu-head reveal">
    <span class="stag">Menu Unggulan Kami</span>
    <h2 class="sh">Langsung dari Dapur Kami</h2>
  </div>
  <p class="menu-desc reveal">Dari kue kering renyah hingga brownies fudgy yang pekat — setiap item dibuat dari bahan pilihan, dipanggang segar setiap hari.</p>

  <div class="circle-grid" id="circleGrid">

    <div class="c-card">
      <div class="c-img-wrap">
        <span class="c-stok stok-aman">Stok 47</span>
        <img src="../gambar/nastar.jpeg" alt="Nastar Klasik" loading="lazy">
      </div>
      <span class="c-cat">Kue Kering</span>
      <h3 class="c-name">Nastar Klasik</h3>
      <span class="c-price">Rp 85.000</span>
      <button class="c-add btn-add-cart" data-name="Nastar Klasik">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah
      </button>
    </div>

    <div class="c-card">
      <div class="c-img-wrap">
        <span class="c-stok stok-aman">Stok 38</span>
        <img src="../gambar/kastangel.jpeg" alt="Kastengel Keju" loading="lazy">
      </div>
      <span class="c-cat">Kue Kering</span>
      <h3 class="c-name">Kastengel Keju</h3>
      <span class="c-price">Rp 60.000</span>
      <button class="c-add btn-add-cart" data-name="Kastengel Keju">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah
      </button>
    </div>

    <div class="c-card">
      <div class="c-img-wrap">
        <span class="c-stok stok-aman">Stok 40</span>
        <img src="../gambar/putri_salju.jpeg" alt="Putri Salju" loading="lazy">
      </div>
      <span class="c-cat">Kue Kering</span>
      <h3 class="c-name">Putri Salju</h3>
      <span class="c-price">Rp 80.000</span>
      <button class="c-add btn-add-cart" data-name="Putri Salju">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah
      </button>
    </div>

    <div class="c-card">
      <div class="c-img-wrap">
        <span class="c-stok stok-aman">Stok 53</span>
        <img src="../gambar/chocolate_butter.jpeg" alt="Chocolate Butter Cookies" loading="lazy">
      </div>
      <span class="c-cat">Cookies</span>
      <h3 class="c-name">Chocolate Butter Cookies</h3>
      <span class="c-price">Rp 70.000</span>
      <button class="c-add btn-add-cart" data-name="Chocolate Butter Cookies">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah
      </button>
    </div>

    <div class="c-card">
      <div class="c-img-wrap">
        <span class="c-stok stok-tipis">Stok Tipis</span>
        <img src="../gambar/brownis.jpeg" alt="Brownies Panggang" loading="lazy">
      </div>
      <span class="c-cat">Cake & Brownies</span>
      <h3 class="c-name">Brownies Panggang</h3>
      <span class="c-price">Rp 95.000</span>
      <button class="c-add btn-add-cart" data-name="Brownies Panggang">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah
      </button>
    </div>

    <div class="c-card">
      <div class="c-img-wrap">
        <span class="c-stok stok-aman">Stok 49</span>
        <img src="../gambar/palm_cheese.jpeg" alt="Palm Cheese Cookies" loading="lazy">
      </div>
      <span class="c-cat">Cookies</span>
      <h3 class="c-name">Palm Cheese Cookies</h3>
      <span class="c-price">Rp 75.000</span>
      <button class="c-add btn-add-cart" data-name="Palm Cheese Cookies">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah
      </button>
    </div>

    <div class="c-card">
      <div class="c-img-wrap">
        <span class="c-stok stok-aman">Stok 52</span>
        <img src="../gambar/strawberry_thumb.jpeg" alt="Strawberry Thumb" loading="lazy">
      </div>
      <span class="c-cat">Cookies</span>
      <h3 class="c-name">Strawberry Thumb</h3>
      <span class="c-price">Rp 72.000</span>
      <button class="c-add btn-add-cart" data-name="Strawberry Thumb">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah
      </button>
    </div>

  </div>

  <div class="see-all-wrap reveal">
    <a href="keranjang.php" class="see-all">
      Pesan Sekarang
      <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
  </div>
</section>

<!-- ════ PROMO BANNER ════ -->
<div class="promo-wrap">
  <div class="promo reveal" id="promoBanner">
    <div class="promo-left">
      <span class="promo-tag">Promo Spesial</span>
      <h2 class="promo-h">Beli 3 Item,<br>Gratis Ongkir!</h2>
      <p class="promo-body">Dapatkan gratis ongkos kirim untuk setiap pembelian minimal 3 item. Berlaku setiap hari ke seluruh wilayah Semarang.</p>
      <a href="#menu" class="btn-promo">
        Pesan Sekarang
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
      </a>
    </div>
    <div class="promo-right">
      <div class="promo-imgs">
        <img src="../gambar/kastangel.jpeg" alt="" loading="lazy">
        <img src="../gambar/brownis.jpeg" alt="" loading="lazy">
      </div>
    </div>
  </div>
</div>

<!-- ════ TESTIMONIAL — Roti besar di sisi, teks besar (Image 2 & 4 style) ════ -->
<section class="testi-section" id="tentang">

  <!-- Label kiri atas -->
  <div class="testi-section-label">Toko Kue Fanda</div>

  <!-- Slide 1 — seperti Image 2 -->
  <div class="testi-slide">
    <div class="testi-food left">
      <img src="../gambar/nastar.jpeg" alt="Nastar" loading="lazy">
    </div>
    <div class="testi-center">
      <div class="testi-label-tag">Kata Pelanggan Kami</div><br><br><br><br><br><br>
      <div class="testi-sub-label">Dari Tetangga Kami</div>
      <p class="testi-quote-text">"Nastar Klasiknya lembut banget, isian nanasnya pas. Udah langganan tiap minggu, <em>gak pernah kecewa!</em>"</p>
      <div class="testi-stars"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
      <span class="testi-name">Niny — Pelanggan Setia</span>
    </div>
    <div class="testi-food right">
      <img src="../gambar/kastangel.jpeg" alt="Kastengel" loading="lazy">
    </div>
  </div>

  <!-- Slide 2 — seperti Image 4 -->
  <div class="testi-slide">
    <div class="testi-food left">
      <img src="../gambar/brownis.jpeg" alt="Brownies" loading="lazy">
    </div>
    <div class="testi-center">
      <div class="testi-sub-label">Dari Tetangga Kami</div>
      <p class="testi-quote-text">"Brownies Panggang-nya <em>juara!</em> Fudgy, coklat pekat, cocok buat oleh-oleh atau hadiah ulang tahun."</p>
      <div class="testi-stars"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
      <span class="testi-name">Agan — Food Enthusiast</span>
    </div>
    <div class="testi-food right">
      <img src="../gambar/chocolate_butter.jpeg" alt="Cookies" loading="lazy">
    </div>
  </div>

  <!-- Slide 3 -->
  <div class="testi-slide">
    <div class="testi-food left">
      <img src="../gambar/strawberry_thumb.jpeg" alt="Strawberry" loading="lazy">
    </div>
    <div class="testi-center">
      <div class="testi-sub-label">Dari Tetangga Kami</div>
      <p class="testi-quote-text">"Kastengel Keju-nya gurih dan <em>renyah banget.</em> Packaging cantik, pengiriman cepat. My go-to kue premium!"</p>
      <div class="testi-stars"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
      <span class="testi-name">Ayuna — Pelanggan Setia</span>
    </div>
    <div class="testi-food right">
      <img src="../gambar/putri_salju.jpeg" alt="Putri Salju" loading="lazy">
    </div>
  </div>

  <div class="testi-bottom-label">Dapur Kami, Untuk Kamu</div>
</section>

<!-- ════ GALLERY ════ -->
<section class="gallery-section">
  <div class="gallery-head reveal">
    <span class="stag">Galeri</span>
    <h2 class="sh">Dari <em>Dapur Kami</em></h2>
  </div>
  <div class="gallery-track">
    <div class="g-img"><img src="../gambar/dapur.jpeg" alt="" loading="lazy"></div>
    <div class="g-img"><img src="../gambar/alat_bahan.jpeg" alt="" loading="lazy"></div>
    <div class="g-img"><img src="../gambar/bahan_bahan.jpeg" alt="" loading="lazy"></div>
    <div class="g-img"><img src="../gambar/kastangel_oven.jpeg" alt="" loading="lazy"></div>
    <div class="g-img"><img src="../gambar/kukis.jpeg" alt="" loading="lazy"></div>
    <div class="g-img"><img src="../gambar/setoberi_thumb.jpeg" alt="" loading="lazy"></div>
    <div class="g-img"><img src="../gambar/nastar_toples.jpeg" alt="" loading="lazy"></div>
  </div>
  <p class="gallery-hint">← Geser untuk lihat lebih →</p>
</section>

<!-- ════ FOOTER ════ -->
<footer id="footer">
  <div class="footer-grid">
    <div>
      <span class="f-logo">Toko Kue Fanda</span>
      <p class="f-desc">Kue premium buatan tangan, dipanggang segar setiap hari dengan bahan-bahan pilihan terbaik.</p>
      <div class="f-social">
        <a href="#" class="f-soc"><svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>
        <a href="#" class="f-soc"><svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
        <a href="#" class="f-soc"><svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg></a>
      </div>
    </div>
    <div>
      <h4 class="f-col-title">Menu</h4>
      <ul class="f-links">
        <li><a href="#">Kue Kering</a></li>
        <li><a href="#">Kue Basah</a></li>
        <li><a href="#">Cookies</a></li>
        <li><a href="#">Cake &amp; Brownies</a></li>
        <li><a href="#">Snack Manis</a></li>
      </ul>
    </div>
    <div>
      <h4 class="f-col-title">Info</h4>
      <ul class="f-links">
        <li><a href="#">Tentang Kami</a></li>
        <li><a href="#">Cara Order</a></li>
        <li><a href="#">FAQ</a></li>
        <li><a href="#">Promo</a></li>
      </ul>
    </div>
    <div>
      <h4 class="f-col-title">Kontak</h4>
      <ul class="f-links">
        <li><a href="#">📍 Semarang, Jawa Tengah</a></li>
        <li><a href="#">📞 +62 812-3456-7890</a></li>
        <li><a href="#">✉️ hello@tokokuefanda.id</a></li>
        <li><a href="#">⏰ Buka Setiap Hari</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <span class="f-copy">© 2025 <strong>Toko Kue Fanda</strong>. All rights reserved.</span>
    <span class="f-copy">Made with ❤️ in Semarang</span>
  </div>
</footer>

<script>
/* CURSOR */
const cur=document.getElementById('cur'),curR=document.getElementById('cur-r');
let mx=0,my=0,rx=0,ry=0;
document.addEventListener('mousemove',e=>{mx=e.clientX;my=e.clientY;cur.style.left=mx+'px';cur.style.top=my+'px'});
(function loop(){rx+=(mx-rx)*.1;ry+=(my-ry)*.1;curR.style.left=rx+'px';curR.style.top=ry+'px';requestAnimationFrame(loop)})();
document.querySelectorAll('a,button,.c-card,.g-img,.testi-slide').forEach(el=>{
  el.addEventListener('mouseenter',()=>document.body.classList.add('h'));
  el.addEventListener('mouseleave',()=>document.body.classList.remove('h'));
});

/* NAVBAR */
const nav=document.getElementById('mainNav');
window.addEventListener('scroll',()=>nav.classList.toggle('stuck',window.scrollY>55),{passive:true});

/* SCROLL REVEAL */
const io=new IntersectionObserver(entries=>{
  entries.forEach(e=>{
    if(!e.isIntersecting)return;
    const t=e.target;
    if(t.classList.contains('c-card')){t.classList.add('show')}
    else{t.classList.add('in')}
    io.unobserve(t);
  });
},{threshold:0.12});
document.querySelectorAll('.c-card,.reveal,.reveal-l').forEach(el=>io.observe(el));

/* COUNTER */
const cio=new IntersectionObserver(entries=>{
  entries.forEach(e=>{
    if(!e.isIntersecting)return;
    e.target.querySelectorAll('.ctr').forEach(el=>{
      const tgt=+el.dataset.to,dur=1800,s=performance.now();
      const tick=n=>{const t=Math.min((n-s)/dur,1);el.textContent=Math.floor((1-Math.pow(1-t,3))*tgt);if(t<1)requestAnimationFrame(tick)};
      requestAnimationFrame(tick);
    });
    cio.unobserve(e.target);
  });
},{threshold:.5});
const st=document.querySelector('.hero-stats');if(st)cio.observe(st);

/* CART */
let cart = JSON.parse(localStorage.getItem('fanda_cart')) || {};

function updateBadge(){

  const badge = document.getElementById('cartBadge');

  let total = 0;

  Object.values(cart).forEach(item => {
    total += item.qty;
  });

  badge.textContent = total;
}

updateBadge();

document.querySelectorAll('.btn-add-cart').forEach(btn => {

  btn.addEventListener('click', () => {

    const card = btn.closest('.c-card');

    const nama = card.querySelector('.c-name').innerText;

    const hargaText = card.querySelector('.c-price').innerText;

    const harga = parseInt(
      hargaText.replace('Rp','')
                .replace(/\./g,'')
                .replace(/\s/g,'')
    );

    const gambar = card.querySelector('img').getAttribute('src');

    // cari id produk berdasarkan nama
    let produkId = null;

    switch(nama){

      case 'Nastar Klasik':
        produkId = 1;
      break;

      case 'Kastengel Keju':
        produkId = 2;
      break;

      case 'Putri Salju':
        produkId = 3;
      break;

      case 'Chocolate Butter Cookies':
        produkId = 4;
      break;

      case 'Brownies Panggang':
        produkId = 5;
      break;

      case 'Palm Cheese Cookies':
        produkId = 6;
      break;

      case 'Strawberry Thumb':
        produkId = 7;
      break;

    }

    if(produkId === null) return;

    if(cart[produkId]){

      cart[produkId].qty += 1;

    } else {

      cart[produkId] = {
        nama: nama,
        harga: harga,
        gambar: gambar,
        qty: 1
      };

    }

    localStorage.setItem('fanda_cart', JSON.stringify(cart));

    btn.style.background='var(--gold)';
    btn.style.color='var(--esp)';

    setTimeout(()=>{
      btn.style.background='';
      btn.style.color='';
    },350);

    updateBadge();

    setTimeout(()=>{
      window.location.href='order_tambah.php';
    },420);

  });

});
</script>
</body>
</html>