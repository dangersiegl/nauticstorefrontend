// Sorgt dafür, dass showToast überall verfügbar ist
function showToast(msg, isSuccess = true) {
  let toast = document.createElement('div');
  toast.textContent = msg;
  toast.className = 'wishlist-toast ' + (isSuccess ? 'success' : 'error');
  document.body.appendChild(toast);
  // Ein klein wenig Delay, damit die CSS-Animation greifen kann
  setTimeout(() => toast.classList.add('visible'), 10);
  setTimeout(() => {
    toast.classList.remove('visible');
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

// mobile navigation
document.addEventListener('DOMContentLoaded', function () {
    // Elemente referenzieren
    const mobileBurgerBtn = document.getElementById('mobile-burger-btn');
    const mobileCloseBtn = document.getElementById('mobile-close-btn');
    const navMobileOverlay = document.getElementById('nav-mobile-overlay');
    const mainCatsView = document.getElementById('mobile-main-categories');
    const subCatsView = document.getElementById('mobile-subcategories');
    const subCatBackBtn = document.getElementById('mobile-subcat-back');
    const subCatList = document.getElementById('mobile-subcat-list');
    const subCatTitle = document.getElementById('mobile-subcat-title');

    // Menü öffnen
    mobileBurgerBtn.addEventListener('click', () => {
        navMobileOverlay.classList.add('active');
        mainCatsView.style.display = 'block'; // Hauptkategorien anzeigen
        subCatsView.style.display = 'none';  // Unterkategorien ausblenden
    });

    // Menü schließen
    mobileCloseBtn.addEventListener('click', () => {
        navMobileOverlay.classList.remove('active');
    });

    // Zurück zur Hauptkategorien-Ansicht
    subCatBackBtn.addEventListener('click', () => {
        mainCatsView.style.display = 'block';
        subCatsView.style.display = 'none';
        subCatList.innerHTML = ''; // Unterkategorien leeren
    });

    // Hauptkategorie-Klick-Handler
    function loadSubCategories(category) {
        subCatTitle.textContent = category.name; // Setzt den Titel

        subCatList.innerHTML = ''; // Liste leeren
        category.subcategories.forEach(subcat => {
            const subLi = document.createElement('li');
            subLi.className = 'subcat-item';
            subLi.innerHTML = `
                <button class="mobile-cat-btn">
                    ${subcat.name}
                    <span class="arrow">▼</span>
                </button>
            `;

            // Unter-Unterkategorien
            if (subcat.subcategories && Array.isArray(subcat.subcategories)) {
                const nestedUl = document.createElement('ul');
                nestedUl.className = 'nested-subcat-list';
                nestedUl.style.display = 'none'; // Initial versteckt

                subcat.subcategories.forEach(subsubcat => {
                    const nestedLi = document.createElement('li');
                    nestedLi.innerHTML = `
                        <button class="mobile-cat-btn">
                            ${subsubcat.name}
                        </button>
                    `;
                    nestedUl.appendChild(nestedLi);
                });

                subLi.appendChild(nestedUl);

                // Pfeil und Anzeige-Logik
                const toggleButton = subLi.querySelector('.mobile-cat-btn');
                toggleButton.addEventListener('click', function () {
                    if (nestedUl.style.display === 'none') {
                        nestedUl.style.display = 'block';
                        toggleButton.querySelector('.arrow').textContent = '▲';
                    } else {
                        nestedUl.style.display = 'none';
                        toggleButton.querySelector('.arrow').textContent = '▼';
                    }
                });
            }

            subCatList.appendChild(subLi);
        });

        // Ansicht wechseln
        mainCatsView.style.display = 'none';
        subCatsView.style.display = 'block';
    }

    // Hauptkategorien initialisieren
    const catButtons = document.querySelectorAll('.mobile-cat-btn');
    catButtons.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            const selectedCat = categoriesJS[index];
            if (selectedCat && selectedCat.subcategories) {
                loadSubCategories(selectedCat);
            }
        });
    });
});

// Hero-Slider-Autoplay
    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.querySelector('.hero-slider');
        const slides = document.querySelectorAll('.hero-slide');
        const prevButton = document.querySelector('.prev-slide');
        const nextButton = document.querySelector('.next-slide');
        let currentIndex = 0;
        const slideCount = slides.length;
        const slideInterval = 7000; // Wechsel alle 7 Sekunden

        function updateSlider() {
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        function showNextSlide() {
            currentIndex = (currentIndex + 1) % slideCount;
            updateSlider();
        }

        function showPrevSlide() {
            currentIndex = (currentIndex - 1 + slideCount) % slideCount;
            updateSlider();
        }

        // Event Listener für Navigation
        nextButton.addEventListener('click', showNextSlide);
        prevButton.addEventListener('click', showPrevSlide);

        // Automatischer Wechsel
        setInterval(showNextSlide, slideInterval);
    });

// Brand-Slider-Autoplay
    document.addEventListener('DOMContentLoaded', () => {
        const sliderContainer = document.querySelector('.brand-slider-container');
        const slides = document.querySelectorAll('.brand-slide');
        const leftArrow = document.querySelector('.left-arrow');
        const rightArrow = document.querySelector('.right-arrow');
        const slideCount = slides.length;
        const slideWidth = slides[0].clientWidth;
        let currentIndex = 0;

        // Dupliziere die Logos am Anfang und Ende für nahtloses Scrollen
        sliderContainer.insertAdjacentHTML('beforeend', sliderContainer.innerHTML);
        sliderContainer.insertAdjacentHTML('afterbegin', sliderContainer.innerHTML);

        function updateSliderPosition() {
            sliderContainer.style.transition = 'transform 0.5s ease-in-out';
            sliderContainer.style.transform = `translateX(-${(currentIndex + slideCount) * slideWidth}px)`;
        }

        // Setze initiale Position
        sliderContainer.style.transform = `translateX(-${slideCount * slideWidth}px)`;

        // Arrow events
        leftArrow.addEventListener('click', () => {
            if (currentIndex <= -slideCount) {
                sliderContainer.style.transition = 'none';
                currentIndex = slideCount - 1;
                sliderContainer.style.transform = `translateX(-${(currentIndex + slideCount) * slideWidth}px)`;
                setTimeout(() => updateSliderPosition(), 50);
            } else {
                currentIndex--;
                updateSliderPosition();
            }
        });

        rightArrow.addEventListener('click', () => {
            if (currentIndex >= slideCount) {
                sliderContainer.style.transition = 'none';
                currentIndex = 0;
                sliderContainer.style.transform = `translateX(-${(currentIndex + slideCount) * slideWidth}px)`;
                setTimeout(() => updateSliderPosition(), 50);
            } else {
                currentIndex++;
                updateSliderPosition();
            }
        });

        // Automatisches Scrollen
        setInterval(() => {
            rightArrow.click();
        }, 3000);
    });

// Scroll-to-Top Button
    document.addEventListener('DOMContentLoaded', function () {
        const scrollTopBtn = document.getElementById('scrollTopBtn');

        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                scrollTopBtn.style.display = 'flex';
            } else {
                scrollTopBtn.style.display = 'none';
            }
        });

        scrollTopBtn.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });

// Mega-Menü: Hover-Effekt für Subkategorien (2. und 3. Spalte + Top Deal)
    document.querySelectorAll('.nav-links-desktop > li.has-megamenu').forEach(navLink => {
    const hoverDelay = 150;  // Zeit in ms, bevor sich das Menü öffnet
    let openTimer, closeTimer;

    function openMegaMenu() {
        // erst mal alle alten aktiven States wegnehmen
        navLink.querySelectorAll('.subcat-list-left li, .sub-subcat-box, .subcat-topdeal-box')
            .forEach(el => el.classList.remove('active'));

        // erste Unterkategorie markieren
        const first = navLink.querySelector('.subcat-list-left li[data-subindex="0"]');
        if (!first) return;
        first.classList.add('active');

        const idx = first.getAttribute('data-subindex');
        // 2. und 3. Spalte auch aktivieren
        navLink.querySelector(`.sub-subcat-box[data-subindex="${idx}"]`)
            ?.classList.add('active');
        navLink.querySelector(`.subcat-topdeal-box[data-subindex="${idx}"]`)
            ?.classList.add('active');

        // jetzt die CSS-Klasse, die es sichtbar macht
        navLink.classList.add('open');
    }

    function closeMegaMenu() {
        clearTimeout(openTimer);
        navLink.classList.remove('open');
        // und State zurücksetzen
        navLink.querySelectorAll('.subcat-list-left li, .sub-subcat-box, .subcat-topdeal-box')
            .forEach(el => el.classList.remove('active'));
    }

    navLink.addEventListener('mouseenter', () => {
        clearTimeout(closeTimer);
        openTimer = setTimeout(openMegaMenu, hoverDelay);
    });

    navLink.addEventListener('mouseleave', () => {
        clearTimeout(openTimer);
        // falls du ein kleines Delay beim Schließen willst, nimm hier setTimeout,
        // sonst ruf closeMegaMenu() direkt auf:
        closeTimer = setTimeout(closeMegaMenu, 50);
    });
});

// Sub-Kategorie-Hover wieder aktivieren
document.querySelectorAll('.nav-links-desktop > li.has-megamenu .subcat-list-left li').forEach(item => {
  item.addEventListener('mouseenter', () => {
    const parent = item.closest('li.has-megamenu');
    // Alle bisherigen States zurücksetzen
    parent.querySelectorAll('.subcat-list-left li').forEach(li => li.classList.remove('active'));
    parent.querySelectorAll('.sub-subcat-box, .subcat-topdeal-box').forEach(el => el.classList.remove('active'));
    // Diesen Eintrag aktiv setzen
    item.classList.add('active');
    const idx = item.getAttribute('data-subindex');
    // Passende Boxen anzeigen
    parent.querySelector(`.sub-subcat-box[data-subindex="${idx}"]`)?.classList.add('active');
    parent.querySelector(`.subcat-topdeal-box[data-subindex="${idx}"]`)?.classList.add('active');
  });
});


// Scroll/Sticky-Verhalten Desktop & Mobile ============= 
    let lastScrollY = 0; // Standard
    let ticking = false;

    window.addEventListener('load', () => {
        // Beim Seitenladen den aktuellen Scrollwert in lastScrollY übernehmen
        lastScrollY = window.scrollY;

        updateScroll(); // Dann direkt einmal aufrufen
    });

    document.addEventListener('DOMContentLoaded', () => {
        const topBar         = document.getElementById('topBar');          
        const mainHeader     = document.getElementById('mainHeader');  
        const navMobileTopbar= document.getElementById('navMobileTopbar');
        const header         = document.querySelector('header');

        let lastScrollY = window.scrollY;

        // Funktion zur dynamischen Höhenberechnung
        function getHeights() {
            const mainHeaderHeight = mainHeader.offsetHeight || 0;
            const topBarHeight     = topBar.offsetHeight     || 0;
            const navMobileTopbarHeight = navMobileTopbar.offsetHeight     || 0;
            return { mainHeaderHeight, topBarHeight };
        }

        function updateScroll() {
            const currentScroll         = window.scrollY;
            const windowWidth           = window.innerWidth;
            const { mainHeaderHeight, topBarHeight } = getHeights();

            if (windowWidth > 999) {
                // ===================== Desktop-Verhalten =====================
                if (currentScroll > topBarHeight) {
                    mainHeader.classList.add('desktop-sticky');
                    // Body Padding einfügen, damit nichts springt
                    document.body.style.paddingTop = mainHeaderHeight + topBarHeight + 'px';
                    header.style.marginTop = '-' + topBarHeight + 'px';
                } else {
                    mainHeader.classList.remove('desktop-sticky');
                    document.body.style.paddingTop = '0';
                    header.style.marginTop = '0';
                }
            } 
            else {
                // ===================== Mobile-Verhalten =====================
                if (currentScroll > lastScrollY) {
                    // Scrollrichtung nach unten

                    if(currentScroll > topBarHeight + mainHeaderHeight) {
                    
                        navMobileTopbar.classList.add('mobile-fixed-navtopbar');
                        mainHeader.classList.add('mobile-hidden');
                        topBar.classList.add('mobile-hidden');
                        navMobileTopbar.style.top = '';
                        header.style.marginTop = mainHeaderHeight + 'px';
                        navMobileTopbar.style.marginTop = 0;
                    }
                    else if (currentScroll > topBarHeight) {
                        navMobileTopbar.classList.remove('mobile-fixed-navtopbar');
                        mainHeader.classList.remove('mobile-hidden');
                        topBar.classList.add('mobile-hidden');
                        navMobileTopbar.style.top = '';
                        header.style.marginTop = '0';
                        navMobileTopbar.style.marginTop = 0;
                    }
                    else {                
                        topBar.classList.add('mobile-hidden');
                        mainHeader.classList.remove('mobile-hidden');
                        navMobileTopbar.classList.remove('mobile-fixed-navtopbar');
                        navMobileTopbar.style.top = '';
                        header.style.marginTop = '0';
                        navMobileTopbar.style.marginTop = 0;
                    }    
                }
                else if (currentScroll < lastScrollY) {
                    // ===== Scrollrichtung nach oben =====
                    
                    if(currentScroll <= topBarHeight) {

                        topBar.classList.remove('mobile-hidden');
                        mainHeader.classList.remove('mobile-fixed-mainheader');
                        mainHeader.classList.remove('mobile-hidden');
                        navMobileTopbar.classList.remove('mobile-fixed-navtopbar');
                        navMobileTopbar.style.top = '';
                        header.style.marginTop = '0';
                        navMobileTopbar.style.marginTop = 0;
                    }
                    else if(currentScroll <= mainHeaderHeight) {
                        topBar.classList.add('mobile-hidden');
                        mainHeader.classList.remove('mobile-fixed-mainheader');
                        mainHeader.classList.remove('mobile-hidden');
                        navMobileTopbar.classList.remove('mobile-fixed-navtopbar');
                        navMobileTopbar.style.top = '';
                        navMobileTopbar.style.marginTop = 0;
                    }  
                    else {
                        topBar.classList.add('mobile-hidden');
                        mainHeader.classList.add('mobile-fixed-mainheader'); 
                        mainHeader.classList.remove('mobile-hidden');
                        navMobileTopbar.classList.add('mobile-fixed-navtopbar');
                        navMobileTopbar.style.marginTop = mainHeaderHeight -1 + 'px';
                    }
                }
                else
                {
                    // 2) Falls wir NACH dem Laden bereits weiter unten sind:
                    if (currentScroll > (topBarHeight + mainHeaderHeight)) {
                        // Zeige die Nav sofort oben an
                        navMobileTopbar.classList.add('mobile-fixed-navtopbar');
                        mainHeader.classList.add('mobile-hidden');
                    }
                }

                // Scroll-Position aktualisieren (negative Werte vermeiden)
                lastScrollY = Math.max(currentScroll, 0);
            }
        }

        // Throttling der Scroll-Events mit requestAnimationFrame
        let ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    updateScroll();
                    ticking = false;
                });
                ticking = true;
            }
        });

        // Aktualisierung bei Resize und nach dem Laden
        window.addEventListener('resize', updateScroll);
        window.addEventListener('load',   updateScroll);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const langBtn = document.querySelector('.language-switcher .lang-btn');
        const langSwitcher = document.querySelector('.language-switcher');
        const dropdown = langSwitcher.querySelector('.lang-dropdown');
        let isMobile = window.matchMedia('(max-width: 999px)').matches;
    
        // Funktion zum Hinzufügen oder Entfernen des Klick-Event-Listeners basierend auf der Bildschirmgröße
        function handleResize() {
            isMobile = window.matchMedia('(max-width: 999px)').matches;
            if (isMobile) {
                // Füge den Klick-Listener hinzu, wenn er noch nicht vorhanden ist
                if (!langBtn.classList.contains('click-handler')) {
                    langBtn.addEventListener('click', toggleDropdown);
                    langBtn.classList.add('click-handler');
                }
            } else {
                // Entferne den Klick-Listener, wenn er existiert
                if (langBtn.classList.contains('click-handler')) {
                    langBtn.removeEventListener('click', toggleDropdown);
                    langBtn.classList.remove('click-handler');
                    langSwitcher.classList.remove('active'); // Stelle sicher, dass das Dropdown geschlossen ist
                }
            }
        }
    
        // Funktion zum Umschalten des Dropdown-Menüs
        function toggleDropdown(event) {
            event.preventDefault(); // Verhindert Standardaktionen
            event.stopPropagation(); // Verhindert, dass der document-Listener das Dropdown sofort schließt
            langSwitcher.classList.toggle('active');
            console.log('Dropdown toggled:', langSwitcher.classList.contains('active'));
        }
    
        // Initialer Aufruf beim Laden der Seite
        handleResize();
    
        // Event-Listener für Fenstergrößenänderungen
        window.addEventListener('resize', handleResize);
    
        if (isMobile) {
            langBtn.addEventListener('click', toggleDropdown);
            langBtn.classList.add('click-handler');
        }
    
        // Schließen des Dropdowns bei Klick außerhalb (für alle Bildschirmgrößen)
        document.addEventListener('click', function (event) {
            if (!langSwitcher.contains(event.target)) {
                langSwitcher.classList.remove('active');
                console.log('Dropdown closed by clicking outside');
            }
        });
    
        // Verhindert, dass ein Klick innerhalb des Dropdowns es schließt
        dropdown.addEventListener('click', function (event) {
            event.stopPropagation();
            console.log('Clicked inside the dropdown');
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const productItems = document.querySelectorAll('.product-item, .product-item-small');
    
        productItems.forEach(item => {
            const mainImage = item.querySelector('.product-image, .product-image-small'); // Alle Bilder finden
            const thumbnails = item.querySelectorAll('.thumbnails-container .thumbnail');
        
            thumbnails.forEach(thumb => {
                thumb.addEventListener('mouseover', () => {
                    if (mainImage && thumb.dataset.fullsrc) {
                        mainImage.src = thumb.dataset.fullsrc;
                        thumbnails.forEach(t => t.classList.remove('active'));
                        thumb.classList.add('active');
                    }
                });
            });
        });
        
    });

    document.addEventListener('DOMContentLoaded', function() {
        const mobileSliders = document.querySelectorAll('.mobile-image-slider.swiper-container');
    
        mobileSliders.forEach(function(swiperContainer) {
            const images = swiperContainer.querySelectorAll('img');
            let imagesLoaded = 0;
    
            images.forEach(function(img) {
                if (img.complete) {
                    imagesLoaded++;
                    img.classList.add('loaded');
                    if (imagesLoaded === images.length) {
                        initializeSwiper(swiperContainer);
                    }
                } else {
                    img.addEventListener('load', function() {
                        img.classList.add('loaded');
                        imagesLoaded++;
                        if (imagesLoaded === images.length) {
                            initializeSwiper(swiperContainer);
                        }
                    });
                    img.addEventListener('error', function() {
                        img.classList.add('loaded'); // Optional: Fehlerfall auch behandeln
                        imagesLoaded++;
                        if (imagesLoaded === images.length) {
                            initializeSwiper(swiperContainer);
                        }
                    });
                }
            });
    
            function initializeSwiper(container) {
                new Swiper(container, {
                    loop: true,
                    initialSlide: 0,
                    pagination: {
                        el: container.querySelector('.swiper-pagination'),
                        clickable: true,
                    },
                    navigation: false,
                    autoplay: false,
                    spaceBetween: 10,
                    observer: true,
                    observeParents: true,
                    on: {
                        init: function () {
                            console.log('Swiper initialized');
                        },
                        slideChange: function () {
                            console.log('Slide changed to: ', this.activeIndex);
                        },
                    },
                });
            }
        });

    });

    // Event-Delegation für alle Bookmark-Links
    document.body.addEventListener('click', async function(e) {
    const a = e.target.closest('a.bookmark');
    if (!a) return;
    e.preventDefault();

    const pid      = a.dataset.productId;
    const vid      = a.dataset.variantId || '';
    const icon     = a.querySelector('i');
    const lang     = window.NS.lang || 'de';    // 'de' als Fallback
    const baseUrl  = window.NS.baseUrl;

    // Utility: Toast-Meldung anzeigen
    function showToast(msg, isSuccess = true) {
        let t = document.createElement('div');
        t.className = `wishlist-toast ${isSuccess ? 'success' : 'error'}`;
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(() => t.classList.add('visible'), 10);
        setTimeout(() => {
        t.classList.remove('visible');
        setTimeout(() => t.remove(), 300);
        }, 3000);
    }

    // Texte nach Sprache
    const texts = {
        confirmRemove: {
        de: 'Möchten Sie das Produkt wirklich aus der Merkliste entfernen?',
        en: 'Do you really want to remove this product from your wishlist?'
        },
        errRemove: {
        de: 'Kommunikationsfehler beim Entfernen',
        en: 'Communication error while removing'
        },
        errAdd: {
        de: 'Kommunikationsfehler beim Hinzufügen',
        en: 'Communication error while adding'
        }
    };

    const isBookmarked = icon.classList.contains('fas');

    if (isBookmarked) {
        // Entfernen bestätigen
        if (!confirm(texts.confirmRemove[lang])) return;

        // Entfernen-Request
        try {
        const res  = await fetch(`${baseUrl}/account/removewishlist`, {
            method:  'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body:    new URLSearchParams({product_id: pid, variant_id: vid}).toString()
        });
        const json = await res.json();
        if (json.status === 'ok') {
            icon.classList.replace('fas','fa-regular');
            document.querySelector('.wishlist .cart-text').textContent = json.count;
            showToast(json.message, true);
        } else {
            showToast(json.message, false);
        }
        } catch (err) {
        console.error(err);
        showToast(texts.errRemove[lang], false);
        }

    } else {
        // Hinzufügen-Request
        try {
        const res  = await fetch(`${baseUrl}/account/addwishlist`, {
            method:  'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body:    new URLSearchParams({product_id: pid, variant_id: vid}).toString()
        });
        const json = await res.json();
        if (json.status === 'ok') {
            icon.classList.replace('fa-regular','fas');
            document.querySelector('.wishlist .cart-text').textContent = json.count;
            showToast(json.message, true);
        } else {
            showToast(json.message, false);
        }
        } catch (err) {
        console.error(err);
        showToast(texts.errAdd[lang], false);
        }
    }
    });
