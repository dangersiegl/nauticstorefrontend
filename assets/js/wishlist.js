document.addEventListener('DOMContentLoaded',function(){
  const base = window.NS.baseUrl;
  const lang = window.NS.lang;

  const body = document.querySelector('#wl-body');
  const sortSel = document.getElementById('wl-sort');
  const filtAvail = document.getElementById('wl-filter-available');
  const filtPrice = document.getElementById('wl-filter-pricechange');

   if (typeof Swiper !== 'undefined') {
    new Swiper('.recently-slider', {
      slidesPerView: 4,
      spaceBetween: 16,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        0:   { slidesPerView: 1 },
        576: { slidesPerView: 2 },
        768: { slidesPerView: 3 },
        992: { slidesPerView: 4 }
      }
    });

    new Swiper('.randoms-slider', {
      slidesPerView: 4,
      spaceBetween: 16,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        0:   { slidesPerView: 1 },
        576: { slidesPerView: 2 },
        768: { slidesPerView: 3 },
        992: { slidesPerView: 4 }
      }
    });
  }

  // Sortieren + Filtern
  function refresh() {
    let rows = Array.from(body.rows);
    // Filter
    rows.forEach(r => {
      let ok = true;
      if(filtAvail.checked && r.dataset.available==='0') ok=false;
      if(filtPrice.checked && r.dataset.priceChanged==='0') ok=false;
      r.style.display = ok ? '' : 'none';
    });
    // Sort
    rows = rows.filter(r=> r.style.display!=='none');
    const cmp = {
      'added_desc': (a,b)=> b.dataset.added - a.dataset.added,
      'added_asc' : (a,b)=> a.dataset.added - b.dataset.added,
      'price_asc' : (a,b)=> a.dataset.currentPrice - b.dataset.currentPrice,
      'price_desc': (a,b)=> b.dataset.currentPrice - a.dataset.currentPrice
    }[ sortSel.value ];
    rows.sort(cmp);
    rows.forEach(r=> body.appendChild(r));
  }
  [sortSel,filtAvail,filtPrice].forEach(el=>el.addEventListener('change',refresh));
  refresh();

  // Entfernen
  body.addEventListener('click', async e=>{
    if(!e.target.matches('.btn-remove')) return;
    const id = e.target.dataset.id;
    if(!confirm(lang==='en'?'Remove from wishlist?':'Aus Merkliste entfernen?')) return;
    let res = await fetch(`${base}/account/removewishlist`,{
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:`id=${id}`
    });
    let j = await res.json();
    if(j.status==='ok'){
      // Zeile raus
      e.target.closest('tr').remove();
    }
  });

  // In Warenkorb
  body.addEventListener('click', async e=>{
    if(!e.target.matches('.btn-addcart')) return;
    const tr = e.target.closest('tr');
    const qty = tr.querySelector('.wl-qty').value;
    const pid = e.target.dataset.product,
          vid = e.target.dataset.variant;
    // hier Deinen Cart-Add-Endpoint aufrufen
    let res = await fetch(`${base}/cart/add`,{
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:`product_id=${pid}&variant_id=${vid}&quantity=${qty}`
    });
    let j = await res.json();
    alert(j.message || (lang==='en'?'Added to cart':'In Warenkorb gelegt'));
  });

});
