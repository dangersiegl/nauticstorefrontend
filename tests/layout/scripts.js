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
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('.nav-links-desktop > li.has-megamenu');
        const leftItems = document.querySelectorAll('.subcat-list-left li[data-subindex]');

        navLinks.forEach(navLink => {
            navLink.addEventListener('mouseenter', () => {
                navLink.querySelectorAll('.subcat-list-left li').forEach(li => li.classList.remove('active'));
                navLink.querySelectorAll('.sub-subcat-box').forEach(box => box.classList.remove('active'));
                navLink.querySelectorAll('.subcat-topdeal-box').forEach(box => box.classList.remove('active'));

                const firstSubcat = navLink.querySelector('.subcat-list-left li');
                const firstIndex = firstSubcat ? firstSubcat.getAttribute('data-subindex') : null;

                if (firstSubcat) {
                    firstSubcat.classList.add('active');
                }
                if (firstIndex !== null) {
                    const firstBox = navLink.querySelector(`.sub-subcat-box[data-subindex="${firstIndex}"]`);
                    const firstDealBox = navLink.querySelector(`.subcat-topdeal-box[data-subindex="${firstIndex}"]`);
                    if (firstBox) firstBox.classList.add('active');
                    if (firstDealBox) firstDealBox.classList.add('active');
                }
            });
        });

        // Hover-Logik
        leftItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                const parentMenu = item.closest('.mega-menu');
                parentMenu.querySelectorAll('.subcat-list-left li').forEach(li => li.classList.remove('active'));
                parentMenu.querySelectorAll('.sub-subcat-box').forEach(box => box.classList.remove('active'));
                parentMenu.querySelectorAll('.subcat-topdeal-box').forEach(box => box.classList.remove('active'));

                item.classList.add('active');
                const index = item.getAttribute('data-subindex');
                const targetSubSubcat = parentMenu.querySelector(`.sub-subcat-box[data-subindex="${index}"]`);
                const targetTopDeal = parentMenu.querySelector(`.subcat-topdeal-box[data-subindex="${index}"]`);
                if (targetSubSubcat) targetSubSubcat.classList.add('active');
                if (targetTopDeal) targetTopDeal.classList.add('active');
            });
        });
    });

// Scroll/Sticky-Verhalten Desktop & Mobile ============= 
    document.addEventListener('DOMContentLoaded', () => {
        const topBar         = document.getElementById('topBar');          
        const mainHeader     = document.getElementById('mainHeader');  
        const navMobileTopbar= document.getElementById('navMobileTopbar');

        let lastScrollY = window.scrollY;

        // Funktion zur dynamischen Höhenberechnung
        function getHeights() {
            const mainHeaderHeight = mainHeader.offsetHeight || 0;
            const topBarHeight     = topBar.offsetHeight     || 0;
            return { mainHeaderHeight, topBarHeight };
        }

        function updateScroll() {
            const currentScroll         = window.scrollY;
            const windowWidth           = window.innerWidth;
            const { mainHeaderHeight, topBarHeight } = getHeights();

            if (windowWidth > 1023) {
                // ===================== Desktop-Verhalten =====================
                if (currentScroll > topBarHeight) {
                    mainHeader.classList.add('desktop-sticky');
                    // Body Padding einfügen, damit nichts springt
                    document.body.style.paddingTop = mainHeaderHeight + topBarHeight + 'px';
                } else {
                    mainHeader.classList.remove('desktop-sticky');
                    document.body.style.paddingTop = '0';
                }
            } else {
                // ===================== Mobile-Verhalten =====================
                if (currentScroll > lastScrollY && currentScroll > 30) {
                    // ===== Scrollrichtung nach unten =====
                    // Top-Bar & Main-Header ausblenden
                    topBar.classList.add('mobile-hidden');
                    mainHeader.classList.add('mobile-hidden');

                    // Main-Header soll nicht fixiert sein:
                    mainHeader.classList.remove('mobile-fixed-mainheader');

                    // navMobileTopbar fixiert an top=0
                    navMobileTopbar.classList.add('mobile-fixed-navtopbar');
                    navMobileTopbar.style.top = "0px";

                } else if (currentScroll < lastScrollY) {
                    // ===== Scrollrichtung nach oben =====
                    // Main-Header wieder anzeigen & fixieren
                    mainHeader.classList.remove('mobile-hidden');
                    mainHeader.classList.add('mobile-fixed-mainheader'); 
                    
                    // Nav-Mobile-Topbar bleibt fixiert, 
                    // aber soll standardmäßig unter Main-Header sitzen
                    navMobileTopbar.classList.add('mobile-fixed-navtopbar');
                    navMobileTopbar.style.top = mainHeaderHeight + "px";

                    // Wenn ganz oben, dann auch Top-Bar wieder einblenden
                    if (currentScroll <= 30) {
                        topBar.classList.remove('mobile-hidden');

                        // Hier könntest du den Main-Header ggf. _nicht_
                        // mehr als "fixed" haben (z.B. wenn ganz oben):
                        mainHeader.classList.remove('mobile-fixed-mainheader');

                        // Nav-Mobile-Topbar etwas tiefer setzen, 
                        // damit sie unter Main-Header + Top-Bar liegt
                        navMobileTopbar.style.top = (mainHeaderHeight + topBarHeight) + "px";
                        mainHeader.style.marginBottom = "60px";
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