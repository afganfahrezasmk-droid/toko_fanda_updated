<?php
include 'header.php';
include '../koneksi.php';
/** @var mysqli $koneksi */

session_name('PELANGGAN_SESSION');
session_start();

$flash_success = $_SESSION['flash_success'] ?? null;
unset($_SESSION['flash_success']);
?>
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

.toast-success {
    transition: all 0.4s ease;

    position: fixed;
    top: 90px;
    right: 20px;
    z-index: 9999;

    display: flex;
    align-items: center;
    gap: 10px;

    padding: 14px 16px;
    min-width: 260px;

    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(14px);

    border: 1px solid rgba(255,255,255,0.15);
    border-left: 4px solid #2ecc71;

    color: #ffffff;
    border-radius: 14px;

    box-shadow: 0 15px 40px rgba(0,0,0,0.3);

    animation: slideIn .5s ease;
    font-size: 14px;
}

.toast-success span {
    font-size: 18px;
}

@keyframes slideIn {
    from {
        transform: translateX(40px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

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

/* TOAST NOTIFICATION */
.toast {
  position: fixed;
  bottom: 30px;
  right: 30px;
  background: rgba(232, 180, 109, 0.95);
  color: var(--esp);
  padding: 16px 24px;
  border-radius: 8px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.2);
  z-index: 9999;
  animation: slideInToast 0.4s ease;
  font-weight: 500;
  font-size: 0.9rem;
}

@keyframes slideInToast {
  from {
    opacity: 0;
    transform: translateX(100px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes slideOutToast {
  from {
    opacity: 1;
    transform: translateX(0);
  }
  to {
    opacity: 0;
    transform: translateX(100px);
  }
}

.toast.out {
  animation: slideOutToast 0.4s ease;
}

/* ══════════════════════════════════════
   HERO — Teks di tengah, gambar natural shape (PNG transparan)
══════════════════════════════════════ */
.hero{min-height:100vh;background:var(--esp-2);position:relative;overflow:hidden;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:120px 64px 90px;text-align:center}

/* Gambar hias hero — wrapper untuk fly-in, inner untuk float */
.hf-wrap{position:absolute;pointer-events:none;z-index:1}

/* 
  PERUBAHAN 1: .hf-img tidak lagi border-radius:50%
  Pakai object-fit:contain agar gambar PNG transparan tampil natural
  Pakai filter:drop-shadow agar shadow ngikutin bentuk gambar
*/
.hf-img{
  object-fit:contain;
  display:block;
  filter:drop-shadow(0 20px 40px rgba(0,0,0,.45));
}

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

/* FLOAT setelah fly-in */
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
.ticker-item{
    display:flex;
    align-items:center;
    gap:20px;
    padding:0 22px;
    white-space:nowrap;
    color:var(--gold);
    font-size:.7rem;
    font-weight:500;
    letter-spacing:.14em;
    text-transform:uppercase;
    opacity:.92;
    transition:all .3s ease;
    text-shadow:0 0 8px rgba(255,255,255,.08);
}
.ticker-dot{
    width:5px;
    height:5px;
    border-radius:50%;
    background:var(--gold);
    box-shadow:0 0 10px rgba(255,215,120,.7);
    animation:pulse 2s infinite;
}
@keyframes marquee{
    from{transform:translateX(0)}
    to{transform:translateX(-50%)}
}
@keyframes pulse{
    0%{transform:scale(1);opacity:1}
    50%{transform:scale(1.5);opacity:.6}
    100%{transform:scale(1);opacity:1}
}

/* ══════════════════════════════════════
   MENU SECTION — Pink bg, gambar lingkaran, zoom hover
══════════════════════════════════════ */
.menu-section{padding:90px 64px 100px;background:var(--blush)}
.menu-head{text-align:center;margin-bottom:20px}
.menu-head .stag{display:block;font-size:.68rem;font-weight:500;letter-spacing:.22em;text-transform:uppercase;color:var(--brown);margin-bottom:8px}
.menu-head .sh{font-family:'Kaushan Script',cursive;font-size:clamp(40px,5vw,68px);color:var(--esp);line-height:1}
.menu-desc{text-align:center;font-size:.92rem;line-height:1.8;color:var(--brown);max-width:560px;margin:0 auto 58px;font-style:italic}

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
  width:clamp(160px,18vw,230px);
  height:clamp(160px,18vw,230px);
  position:relative;
  flex-shrink:0;
  border-radius:50%;
  overflow:hidden;
  transition: transform .45s var(--ease), box-shadow .45s var(--ease);
}

.c-card:hover .c-img-wrap{
  transform:scale(1.08) translateY(-8px);
  box-shadow:0 24px 60px rgba(74,37,16,.28);
}

.c-img-wrap img{
  width:100%;
  height:100%;
  object-fit:cover;
  border-radius:50%;
  transition:transform .6s var(--es);
}

.c-card:hover .c-img-wrap img{
  transform:scale(1.08);
}

.c-stok{
  position:absolute;
  top:10px;
  right:-10px;
  z-index:20;
  font-size:.58rem;
  font-weight:700;
  letter-spacing:.08em;
  text-transform:uppercase;
  padding:7px 13px;
  border-radius:999px;
  box-shadow:0 8px 20px rgba(0,0,0,.18);
}
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
  cursor: pointer;
}
.c-card:hover .c-add{opacity:1;transform:translateY(0)}
.c-add:hover{background:var(--car)}
.c-add svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5}

.see-all-wrap{text-align:center;margin-top:48px}
.see-all{display:inline-flex;align-items:center;gap:8px;color:var(--esp);font-size:.88rem;font-weight:600;letter-spacing:.04em;border-bottom:1.5px solid var(--esp);padding-bottom:2px;transition:gap .3s,color .3s}
.see-all:hover{gap:14px;color:var(--car);border-color:var(--car)}
.see-all svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2.2}

/* ══════════════════════════════════════
   MENU FAVORIT
══════════════════════════════════════ */
.favmenu-section{
  padding:96px 64px 100px;
  background:var(--white);
  position:relative;
  overflow:hidden;
}
.favmenu-section::before{
  content:'';position:absolute;width:600px;height:600px;
  border-radius:50%;top:-200px;right:-180px;
  background:radial-gradient(circle, rgba(245,206,204,.35) 0%, transparent 65%);
  pointer-events:none;
}
.favmenu-section::after{
  content:'';position:absolute;width:400px;height:400px;
  border-radius:50%;bottom:-150px;left:-120px;
  background:radial-gradient(circle, rgba(232,180,109,.12) 0%, transparent 65%);
  pointer-events:none;
}

.favmenu-head{
  text-align:center;
  margin-bottom:16px;
  position:relative;z-index:1;
}
.favmenu-head .stag{
  display:block;font-size:.68rem;font-weight:500;
  letter-spacing:.22em;text-transform:uppercase;
  color:var(--car);margin-bottom:10px;
}
.favmenu-head .sh{
  font-family:'Playfair Display',serif;
  font-size:clamp(36px,5vw,62px);
  font-weight:900;color:var(--esp);line-height:1.05;
}
.favmenu-head .sh em{font-style:italic;color:var(--brown)}
.favmenu-sub{
  text-align:center;font-size:.92rem;line-height:1.8;
  color:var(--muted);max-width:520px;margin:0 auto 68px;
  font-style:italic;position:relative;z-index:1;
}

.favmenu-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:16px 32px;
  position:relative;z-index:1;
}

.fav-card{
  display:flex;flex-direction:column;align-items:center;
  cursor:none;
  opacity:0;transform:translateY(28px);
}
.fav-card.show{animation:cardIn .65s var(--es) forwards}
.fav-card:nth-child(2).show{animation-delay:.1s}
.fav-card:nth-child(3).show{animation-delay:.2s}
.fav-card:nth-child(4).show{animation-delay:.3s}

.fav-img-ring{
  width:clamp(180px,20vw,260px);
  height:clamp(180px,20vw,260px);
  border-radius:50%;
  background:var(--blush);
  display:flex;align-items:center;justify-content:center;
  overflow:hidden;
  position:relative;
  transition:transform .45s var(--ease),box-shadow .45s;
  box-shadow:0 8px 32px rgba(74,37,16,.12);
  cursor: pointer;
}
.fav-card:hover .fav-img-ring{
  transform:translateY(-10px) scale(1.05);
  box-shadow:0 22px 52px rgba(74,37,16,.22);
}

.fav-img-ring img{
  width:100%;height:100%;
  object-fit:cover;
  transition:transform .6s var(--es);
}
.fav-card:hover .fav-img-ring img{transform:scale(1.1)}

.fav-rank{
  position:absolute;top:14px;left:14px;
  width:28px;height:28px;border-radius:50%;
  background:var(--esp);color:var(--gold);
  font-size:.65rem;font-weight:700;
  display:flex;align-items:center;justify-content:center;
  letter-spacing:0;
}

.fav-name{
  font-family:'Playfair Display',serif;
  font-size:1.1rem;font-weight:700;
  color:var(--esp);text-align:center;
  margin-top:22px;line-height:1.2;
}
.fav-price{
  font-family:'Playfair Display',serif;
  font-size:1.05rem;font-style:italic;
  color:var(--car);margin-top:5px;
}
.fav-stars{
  display:flex;gap:2px;margin-top:6px;
}
.fav-stars span{color:var(--gold);font-size:.72rem}

.favmenu-divider{
  display:flex;align-items:center;gap:18px;
  max-width:320px;margin:60px auto 0;
  position:relative;z-index:1;
}
.favmenu-divider::before,.favmenu-divider::after{
  content:'';flex:1;height:1px;background:var(--cream2);
}
.favmenu-divider-text{
  font-family:'Kaushan Script',cursive;
  font-size:1.1rem;color:var(--muted);white-space:nowrap;
}

/* ══════════════════════════════════════
   TESTIMONIAL
══════════════════════════════════════ */
.testi-section{background:var(--esp-2);overflow:hidden;position:relative}

.testi-slide{
  min-height:75vh;
  display:grid;grid-template-columns:360px 1fr 360px;
  align-items:center;
  padding:80px 0;
  position:relative;
}
.testi-slide:nth-child(even){background:rgba(0,0,0,.12)}

.testi-food{
  width:100%;height:100%;
  display:flex;align-items:flex-end;
  overflow:visible;
  position:relative;
}
.testi-food.left{justify-content:flex-end;}
.testi-food.right{justify-content:flex-start;}
.testi-food img{
  width:clamp(250px,28vw,380px);
  height:clamp(300px,36vw,460px);
  object-fit:contain;
  flex-shrink:0;
  filter:drop-shadow(0 24px 60px rgba(0,0,0,.45));
  transition:transform .6s var(--es), filter .6s var(--es);
}
.testi-food.left img{transform:translate(-15%, 15%) rotate(-8deg)}
.testi-food.right img{transform:translate(15%, 15%) rotate(8deg)}
.testi-slide:hover .testi-food.left img{transform:translate(-10%, 8%) rotate(-5deg);filter:drop-shadow(0 32px 70px rgba(0,0,0,.55))}
.testi-slide:hover .testi-food.right img{transform:translate(10%, 8%) rotate(5deg);filter:drop-shadow(0 32px 70px rgba(0,0,0,.55))}

.testi-label-tag{
  position:absolute;top:40px;left:50%;transform:translateX(-50%);
  background:var(--white);color:var(--esp);
  font-family:'Playfair Display',serif;font-style:italic;font-size:.95rem;
  padding:11px 28px;border-radius:5px;
  box-shadow:0 6px 24px rgba(0,0,0,.25);
  white-space:nowrap;z-index:2;
}

.testi-section-label{
  position:absolute;top:44px;left:64px;
  font-family:'Kaushan Script',cursive;font-size:1.45rem;
  color:rgba(255,252,247,.3);
}

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

.testi-bottom-label{
  text-align:center;padding:40px;
  font-family:'Kaushan Script',cursive;
  font-size:clamp(28px,5vw,56px);
  color:rgba(255,252,247,.12);
  border-top:1px solid rgba(255,252,247,.06);
}

.testi-add-wrap{
    text-align:center;
    padding:50px 20px 70px;
}

.testi-add-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    padding:15px 34px;
    border-radius:999px;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.12);
    backdrop-filter:blur(10px);
    color:var(--white);
    font-size:.85rem;
    font-weight:500;
    letter-spacing:.08em;
    text-transform:uppercase;
    transition:all .35s var(--es);
    text-decoration:none;
    cursor: pointer;
}

.testi-add-btn:hover{
    background:var(--gold);
    color:var(--esp);
    transform:translateY(-4px);
    box-shadow:0 14px 30px rgba(232,180,109,.28);
}

.review-success{
    width:fit-content;
    margin:30px auto 10px;
    padding:14px 26px;
    border-radius:999px;
    background:rgba(232,180,109,.12);
    border:1px solid rgba(232,180,109,.25);
    color:var(--gold);
    font-size:.9rem;
    font-weight:500;
    letter-spacing:.03em;
    backdrop-filter:blur(10px);
    animation:fadeNotif .5s ease;
}

@keyframes fadeNotif{
    from{opacity:0;transform:translateY(-10px)}
    to{opacity:1;transform:translateY(0)}
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
  .favmenu-section{padding:70px 22px 80px}
  .favmenu-grid{grid-template-columns:repeat(2,1fr);gap:24px 16px}
  .testi-slide{grid-template-columns:1fr;padding:60px 22px}
  .testi-food{display:none}
  .testi-section-label{left:22px}
  .gallery-section{padding:70px 0}
  .gallery-head{padding:0 22px 32px}
  .gallery-track{padding:0 22px 10px}
  footer{padding:56px 22px 30px}
  .footer-grid{grid-template-columns:1fr 1fr;gap:32px}
  .footer-bottom{flex-direction:column;gap:8px;text-align:center}
  .toast{bottom:20px;right:20px}
}
</style>
</head>
<body>

<?php if ($flash_success): ?>
<div class="toast-success">
    <span>✅</span>
    <div>
        <?= htmlspecialchars($flash_success) ?>
    </div>
</div>
<?php endif; ?>

<div id="cur"></div>
<div id="cur-r"></div>

<!-- ════ NAVBAR ════ -->
<nav class="nav" id="mainNav">
  <a href="#" class="nav-logo">Toko Kue Fanda</a>
  <ul class="nav-links">
    <li><a href="#">Beranda</a></li>
    <li><a href="#menu">Menu</a></li>
    <li><a href="#tentang">Ulasan</a></li>
    <li><a href="#footer">Kontak</a></li>
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

<!-- ════ HERO ════ -->
<section class="hero" id="beranda">

  <div class="hf-wrap tl">
    <img class="hf-img" src="../gambar/nastar.png" alt="">
  </div>
  <div class="hf-wrap tr">
    <img class="hf-img" src="../gambar/kastengel.png" alt="">
  </div>
  <div class="hf-wrap bl">
    <img class="hf-img" src="../gambar/strawberry_thumbprint.png" alt="">
  </div>
  <div class="hf-wrap br">
    <img class="hf-img" src="../gambar/lidah_kucing.png" alt="">
  </div>
  <div class="hf-wrap ml">
    <img class="hf-img" src="../gambar/kue_kacang.png" alt="">
  </div>
  <div class="hf-wrap mr">
    <img class="hf-img" src="../gambar/sagu_keju.png" alt="">
  </div>

  <?php

/* TOTAL MENU */
$qMenu = mysqli_query($koneksi, "SELECT COUNT(*) as total_menu FROM produk");
$dMenu = mysqli_fetch_assoc($qMenu);

/* RATING RATA-RATA */
$qRating = mysqli_query($koneksi, "SELECT AVG(rating) as rating_avg FROM review WHERE status='tampil'");
$dRating = mysqli_fetch_assoc($qRating);
$rating = number_format($dRating['rating_avg'],1);

/* PELANGGAN PUAS */
$qPelanggan = mysqli_query($koneksi, "SELECT COUNT(DISTINCT orders_id) as total_pelanggan FROM order_items");
$dPelanggan = mysqli_fetch_assoc($qPelanggan);

?>

<!-- Konten tengah -->
<div class="hero-inner">

    <h1 class="hero-name">Toko Kue Fanda</h1>

    <a href="#menu" class="hero-tag">
        Jelajahi Menu
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    </a>

    <div class="hero-stats">

        <div class="stat">
            <span class="stat-n">
                <span class="ctr" data-to="<?= $dMenu['total_menu']; ?>">0</span>
                <sup>+</sup>
            </span>
            <span class="stat-l">Menu Pilihan</span>
        </div>

        <div class="stat">
            <span class="stat-n"><?= $rating; ?><sup>★</sup></span>
            <span class="stat-l">Rating Pelanggan</span>
        </div>

        <div class="stat">
            <span class="stat-n">
                <span class="ctr" data-to="<?= $dPelanggan['total_pelanggan']; ?>">0</span>
                <sup>+</sup>
            </span>
            <span class="stat-l">Produk Terjual</span>
        </div>

    </div>

</div>
</section>

<!-- TICKER -->
<div class="ticker" aria-hidden="true">
  <div class="ticker-track">
    <div class="ticker-item">Fresh Baked Daily<span class="ticker-dot"></span></div>
    <div class="ticker-item">Premium Quality<span class="ticker-dot"></span></div>
    <div class="ticker-item">Rating Pelanggan 4.9★<span class="ticker-dot"></span></div>
    <div class="ticker-item">Dipanggang Dengan Cinta<span class="ticker-dot"></span></div>
    <div class="ticker-item">Bahan Pilihan Berkualitas<span class="ticker-dot"></span></div>
    <div class="ticker-item">Manisnya Bikin Nagih<span class="ticker-dot"></span></div>
    <div class="ticker-item">Produk Terlaris Setiap Hari<span class="ticker-dot"></span></div>
    <div class="ticker-item">Favorit Keluarga Indonesia<span class="ticker-dot"></span></div>
    <div class="ticker-item">Resep Homemade Spesial<span class="ticker-dot"></span></div>
    <div class="ticker-item">Lembut, Renyah & Fresh<span class="ticker-dot"></span></div>
    <div class="ticker-item">Cocok Untuk Hampers & Hadiah<span class="ticker-dot"></span></div>
    <div class="ticker-item">Pesan Mudah & Cepat<span class="ticker-dot"></span></div>
  </div>
</div>

<!-- ════ MENU SECTION ════ -->
<section class="menu-section" id="menu">
  <div class="menu-head reveal">
    <span class="stag">Menu Unggulan Kami</span>
    <h2 class="sh">Langsung dari Dapur Kami</h2>
  </div>
  <p class="menu-desc reveal">Dari kue kering renyah hingga brownies fudgy yang pekat — setiap item dibuat dari bahan pilihan, dipanggang segar setiap hari.</p>

  <div class="circle-grid" id="circleGrid">

    <?php
    $query = mysqli_query($koneksi, "SELECT * FROM produk");

    while($data = mysqli_fetch_assoc($query)){

        $stok = $data['stok'];

        if($stok > 20){
            $class_stok = "stok-aman";
            $text_stok = "Stok $stok";
        }elseif($stok > 0){
            $class_stok = "stok-tipis";
            $text_stok = "Stok Tipis";
        }else{
            $class_stok = "stok-habis";
            $text_stok = "Stok Habis";
        }
    ?>

    <div class="c-card">
      <div class="c-img-wrap">

        <img src="../gambar/<?= $data['gambar']; ?>" 
            alt="<?= $data['nama_produk']; ?>" 
            loading="lazy">

      </div>

      <span class="c-cat">
        <?php
          if($data['kategori_id'] == 1){
              echo "Kue Kering";
          }elseif($data['kategori_id'] == 2){
              echo "Kue Basah";
          }elseif($data['kategori_id'] == 3){
              echo "Cookies";
          }elseif($data['kategori_id'] == 4){
              echo "Cake & Brownies";
          }elseif($data['kategori_id'] == 5){
              echo "Snack Manis";
          }else{
              echo "Kategori Tidak Ada";
          }
        ?>
      </span>

      <h3 class="c-name"><?= $data['nama_produk']; ?></h3>

      <span class="c-price">Rp <?= number_format($data['harga'],0,',','.'); ?></span>

      <span class="c-stok <?= $class_stok ?>"><?= $text_stok ?></span>

      <button class="c-add btn-add-cart" 
        data-produk-id="<?= $data['produk_id']; ?>" 
        data-nama="<?= $data['nama_produk']; ?>" 
        data-harga="<?= $data['harga']; ?>" 
        data-gambar="<?= $data['gambar']; ?>"
        data-stok="<?= $stok; ?>">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah
      </button>

    </div>

    <?php } ?>

    </div>
  </div>

  <div class="see-all-wrap reveal">
    <a href="keranjang.php" class="see-all">
      Pesan Sekarang
      <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
  </div>
</section>

<!-- ════ MENU FAVORIT ════ -->
<section class="favmenu-section">

  <div class="favmenu-head reveal">
    <span class="stag">Paling Banyak Dipesan</span>
    <h2 class="sh">Menu <em>Favorit</em></h2>
  </div>

  <p class="favmenu-sub reveal">
    Produk terlaris pilihan pelanggan dengan rating terbaik dari toko kami ✨
  </p>

  <div class="favmenu-grid" id="favGrid">

    <?php

    $fav = mysqli_query($koneksi, "

SELECT 
    produk.produk_id,
    produk.nama_produk,
    produk.harga,
    produk.gambar,
    produk.stok,
    COALESCE(SUM(order_items.qty),0) as total_terjual,
    COALESCE(AVG(review.rating),0) as rata_rating

FROM produk

LEFT JOIN order_items
    ON produk.produk_id = order_items.produk_id

LEFT JOIN review
    ON produk.produk_id = review.produk_id
    AND review.status='tampil'

GROUP BY produk.produk_id

ORDER BY total_terjual DESC, rata_rating DESC

LIMIT 4

");

    $rank = 1;

    while($f = mysqli_fetch_assoc($fav)){

    ?>

    <div class="fav-card">

      <div class="fav-img-ring" data-produk-id="<?= $f['produk_id']; ?>" data-nama="<?= $f['nama_produk']; ?>" data-harga="<?= $f['harga']; ?>" data-gambar="<?= $f['gambar']; ?>" data-stok="<?= $f['stok']; ?>" style="cursor: pointer;">

        <span class="fav-rank">#<?= $rank++; ?></span>

        <img 
          src="../gambar/<?= $f['gambar']; ?>" 
          alt="<?= $f['nama_produk']; ?>" 
          loading="lazy"
        >

      </div>

      <h3 class="fav-name"><?= $f['nama_produk']; ?></h3>

      <span class="fav-price">Rp <?= number_format($f['harga'],0,',','.'); ?></span>

      <div class="fav-stars">

        <?php

        $rating = round($f['rata_rating']);

        for($i=1; $i<=5; $i++){

            if($i <= $rating){
                echo "<span>★</span>";
            } else {
                echo "<span>☆</span>";
            }

        }

        ?>

      </div>

    </div>

    <?php } ?>

  </div>

  <div class="favmenu-divider reveal">
    <span class="favmenu-divider-text">
      Favorit pelanggan kami ✨
    </span>
  </div>

</section>

<!-- ════ TESTIMONIAL ════ -->
<section class="testi-section" id="tentang">

<?php if(isset($_GET['review']) && $_GET['review'] == 'success'){ ?>
    <div class="review-success">
        ✨ Review berhasil ditambahkan, terima kasih!
    </div>
<?php } ?>

<div class="testi-section-label">Toko Kue Fanda</div>

<?php
$qReview = mysqli_query($koneksi, "
    SELECT 
        review.*,
        produk.gambar,
        produk.gambar_testi
    FROM review
    LEFT JOIN produk ON review.produk_id = produk.produk_id
    WHERE review.status = 'tampil'
    ORDER BY review.id_review DESC
");

while($r = mysqli_fetch_assoc($qReview)){
?>

<div class="testi-slide">

    <div class="testi-food left">
        <img src="../gambar/<?= $r['gambar_testi']; ?>" loading="lazy">
    </div>

    <div class="testi-center">

        <div class="testi-sub-label">
            Dari Tetangga Kami
        </div>

        <p class="testi-quote-text">
            "<?= $r['review']; ?>"
        </p>

        <div class="testi-stars">
            <?php
            for($i=1; $i<=5; $i++){
                if($i <= $r['rating']){
                    echo "<span>★</span>";
                } else {
                    echo "<span>☆</span>";
                }
            }
            ?>
        </div>

        <span class="testi-name">
            <?= $r['nama_pelanggan']; ?>
        </span>

    </div>

    <div class="testi-food right">
        <img src="../gambar/<?= $r['gambar_testi']; ?>" loading="lazy">
    </div>

</div>

<?php } ?>

<div class="testi-add-wrap">
    <a href="review_tambah.php" class="testi-add-btn">
        + Bagikan Pengalaman Anda
    </a>
</div>

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
        <li><a href="#menu">Kue Kering</a></li>
        <li><a href="#menu">Kue Basah</a></li>
        <li><a href="#menu">Cookies</a></li>
        <li><a href="#menu">Cake &amp; Brownies</a></li>
        <li><a href="#menu">Snack Manis</a></li>
      </ul>
    </div>
    <div>
      <h4 class="f-col-title">Info</h4>
      <ul class="f-links">
        <li><a href="#kontak">Tentang Kami</a></li>
        <li><a href="keranjang.php">Cara Order</a></li>
        <li><a href="#tentang">FAQ</a></li>
        <li><a href="#menu">Menu Favorit</a></li>
      </ul>
    </div>
    <div>
      <h4 class="f-col-title">Kontak</h4>
      <ul class="f-links">
        <li><a href="#">📍 Semarang, Jawa Tengah</a></li>
        <li><a href="#">📞 +62 856-4144-7469</a></li>
        <li><a href="#">✉️ hello@tokokuefanda.id</a></li>
        <li><a href="#">⏰ Buka Setiap Senin - Sabtu</a></li>
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
document.querySelectorAll('a,button,.c-card,.fav-card,.g-img,.testi-slide').forEach(el=>{
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
    if(t.classList.contains('c-card')||t.classList.contains('fav-card')){t.classList.add('show')}
    else{t.classList.add('in')}
    io.unobserve(t);
  });
},{threshold:0.12});
document.querySelectorAll('.c-card,.fav-card,.reveal,.reveal-l').forEach(el=>io.observe(el));

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

/* ════════════════════════════════════════
   CART MANAGEMENT
════════════════════════════════════════ */

let cart = JSON.parse(localStorage.getItem('fanda_cart')) || {};

function updateBadge(){
  const badge = document.getElementById('cartBadge');
  let total = 0;
  Object.values(cart).forEach(item => { total += item.qty; });
  badge.textContent = total;
}

function showToast(message){
  const toast = document.createElement('div');
  toast.className = 'toast';
  toast.textContent = message;
  document.body.appendChild(toast);
  
  setTimeout(() => {
    toast.classList.add('out');
    setTimeout(() => toast.remove(), 400);
  }, 2000);
}

function addToCart(produkId, nama, harga, gambar, stok){
  if(stok <= 0){
    showToast('❌ Stok habis');
    return;
  }

  if(cart[produkId]){
    cart[produkId].qty += 1;
  } else {
    cart[produkId] = { nama, harga, gambar, qty: 1 };
  }

  localStorage.setItem('fanda_cart', JSON.stringify(cart));
  updateBadge();
  showToast(`✓ ${nama} ditambahkan ke keranjang`);
}

updateBadge();

// EVENT: Tombol tambah di menu regular
document.querySelectorAll('.btn-add-cart').forEach(btn => {
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    const produkId = btn.dataset.produkId;
    const nama = btn.dataset.nama;
    const harga = parseInt(btn.dataset.harga);
    const gambar = btn.dataset.gambar;
    const stok = parseInt(btn.dataset.stok);
    
    addToCart(produkId, nama, harga, gambar, stok);
  });
});

// EVENT: Klik di kartu favorit (fav-img-ring)
document.querySelectorAll('.fav-img-ring').forEach(ring => {
  ring.addEventListener('click', (e) => {
    const produkId = ring.dataset.produkId;
    const nama = ring.dataset.nama;
    const harga = parseInt(ring.dataset.harga);
    const gambar = ring.dataset.gambar;
    const stok = parseInt(ring.dataset.stok);
    
    addToCart(produkId, nama, harga, gambar, stok);
  });
});

</script>

<?php if ($flash_success): ?> 
<script>
setTimeout(() => {
    const toast = document.querySelector('.toast-success');
    if(toast){
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(40px)';
        setTimeout(() => toast.remove(), 400);
    }
}, 5000); // 5 detik
</script>
<?php endif; ?>

</body>
</html>
