// Globale Variablen:
let slideIndex = 1;
let currentMainImageIndex = 1; // Standardmäßig das erste Bild

// Öffnet das Modal
function openModal() {
  document.getElementById("imageModal").style.display = "block";
}

// Schließt das Modal
function closeModal() {
  document.getElementById("imageModal").style.display = "none";
}

// Ändert den Slide um n Schritte (n kann positiv oder negativ sein)
function plusSlides(n) {
  showSlides(slideIndex + n);
}

// Zeigt den Slide mit Index n an
function showSlides(n) {
  const slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) { 
    slideIndex = 1;
  } else if (n < 1) {
    slideIndex = slides.length;
  } else {
    slideIndex = n;
  }
  // Alle Slides ausblenden:
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  // Den aktuellen Slide anzeigen:
  slides[slideIndex - 1].style.display = "block";
}

// Optional: Schließt das Modal, wenn außerhalb des Inhalts geklickt wird.
window.onclick = function(event) {
  const modal = document.getElementById("imageModal");
  if (event.target === modal) {
    closeModal();
  }
}

// Hilfsfunktion zum Aktualisieren des Query-Parameters:
function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    } else {
        return uri + separator + key + "=" + value;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var variantButtons = document.querySelectorAll('.variant-button');
    var stockStatusElement = document.querySelector('.stock-status-detail');

    function updateStockStatus(stock) {
        if (!stockStatusElement) return;

        if (stock > 100) {
            stockStatusElement.innerHTML = '<span class="status-dot green"></span> Mehr als 100 Stück auf Lager';
        } else if (stock > 50) {
            stockStatusElement.innerHTML = '<span class="status-dot green"></span> Mehr als 50 Stück auf Lager';
        } else if (stock > 5) {
            stockStatusElement.innerHTML = '<span class="status-dot green"></span> Mehr als 5 Stück auf Lager';
        } else if (stock > 0) {
            stockStatusElement.innerHTML = '<span class="status-dot orange"></span> Nur noch ' + stock + ' Stück auf Lager';
        } else {
            stockStatusElement.innerHTML = '<span class="status-dot red"></span> Nicht auf Lager';
        }
    }

    variantButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            if (this.disabled) return;

            // Alle Buttons deaktivieren
            variantButtons.forEach(function (btn) {
                btn.classList.remove('active');
            });
            // Klick-Button aktivieren
            this.classList.add('active');

            var articleNumber = this.getAttribute('data-article-number');
            var price = parseFloat(this.getAttribute('data-price'));
            var oldPrice = parseFloat(this.getAttribute('data-old-price'));
            var stock = parseInt(this.getAttribute('data-stock'), 10);

            // Preis aktualisieren
            document.getElementById('productPrice').textContent = '€ ' + price.toFixed(2).replace('.', ',');
            document.querySelector('.product-detail-old-price .price').textContent = '€ ' + oldPrice.toFixed(2).replace('.', ',');

            // Einsparungen berechnen
            var savingsInfo = document.getElementById('savingsInfo');
            if (oldPrice > price) {
                var savings = oldPrice - price;
                var savingsPercent = (savings / oldPrice) * 100;
                savingsInfo.textContent = 'Sie sparen: € ' + savings.toFixed(2).replace('.', ',') + ' (' + Math.round(savingsPercent) + '%)';
            } else {
                savingsInfo.textContent = '';
            }

            // Artikelnummer aktualisieren
            document.getElementById('artikelnummer').textContent = articleNumber;

            // Lagerbestand aktualisieren
            updateStockStatus(stock);

            // URL-Parameter "number" aktualisieren
            var newUrl = new URL(window.location.href);
            newUrl.searchParams.set('number', articleNumber);
            window.history.replaceState({}, '', newUrl);
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var relatedSlider = document.getElementById('relatedSlider');
    var upBtn = document.getElementById('relatedUpBtn');
    var downBtn = document.getElementById('relatedDownBtn');

    // Beispiel: Wir nehmen an, dass jedes kleine Produkt-Item (rendered with product-item-small) eine Höhe von ca. 260px hat.
    var itemHeight = 260; // <-- Passe diesen Wert ggf. an (inklusive eventuell vorhandener Margins/Paddings)
    
    var currentIndex = 0;
    var totalItems = relatedSlider.children.length;
    var visibleItems = 2; // Es sollen zwei Produkte gleichzeitig sichtbar sein.
    var maxIndex = totalItems - visibleItems;  // Höchster Startindex, damit immer 2 Items sichtbar sind.

    upBtn.addEventListener('click', function () {
        if (currentIndex > 0) {
            currentIndex--;
            updateSlider();
        }
    });

    downBtn.addEventListener('click', function () {
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateSlider();
        }
    });

    function updateSlider() {
        var translateY = -currentIndex * itemHeight;
        relatedSlider.style.transform = 'translateY(' + translateY + 'px)';
    }
});

document.addEventListener('DOMContentLoaded', function () {
    var recSlider = document.getElementById('recommendationsSlider');
    var sliderContainer = document.getElementById('recommendationsSliderContainer');
    var leftBtn = document.getElementById('recLeftBtn');
    var rightBtn = document.getElementById('recRightBtn');

    // Bestimme die Breite eines Items inkl. Margin (angenommener Wert, ggf. anpassen)
    var firstItem = document.querySelector('.slider-item');
    var itemWidth = firstItem ? firstItem.offsetWidth + 15 : 315; // 15px margin-right
    var currentScroll = 0;

    // Gesamtbreite des Track berechnen
    var totalWidth = recSlider.scrollWidth;
    var containerWidth = sliderContainer.offsetWidth;
    var maxScroll = totalWidth - containerWidth;

    leftBtn.addEventListener('click', function () {
        currentScroll = Math.max(0, currentScroll - itemWidth);
        recSlider.style.transform = 'translateX(-' + currentScroll + 'px)';
    });

    rightBtn.addEventListener('click', function () {
        currentScroll = Math.min(maxScroll, currentScroll + itemWidth);
        recSlider.style.transform = 'translateX(-' + currentScroll + 'px)';
    });
});
