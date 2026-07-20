/* ====================================
   ADMIN IMAGE PREVIEW - REUSABLE
   Used in: Site Settings, Category, Products
   ==================================== */

(function() {
    // ════════ LOGO PREVIEW ════════
    const logoInput = document.getElementById('logoInput');
    if (logoInput) {
        logoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('logoPreview');
                    if (preview) {
                        preview.src = event.target.result;
                    } else {
                        const container = document.querySelector('.logo-preview-container');
                        if (container) {
                            container.innerHTML = `<img id="logoPreview" src="${event.target.result}" alt="Logo Preview" class="img-fluid" style="max-height: 120px;">`;
                        }
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // ════════ CATEGORY IMAGE PREVIEW ════════
    function previewCatImage(event) {
        const input = event.target;
        const preview = document.getElementById('catImagePreview');

        if (!preview) return;

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    window.previewCatImage = previewCatImage;

    // ════════ PRODUCT IMAGE PREVIEW ════════
    function previewProductImage(event) {
        const input = event.target;
        const preview = document.getElementById('productImagePreview');

        if (!preview) return;

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    window.previewProductImage = previewProductImage;

    // ════════ MARQUEE ICON PREVIEW ════════
    function previewMarqueeIcon(event) {
        const input = event.target;
        const preview = document.getElementById('marqueeIconPreview');

        if (!preview) return;

        const iconClass = input.value;
        if (iconClass) {
            preview.innerHTML = `<i class="${iconClass}"></i>`;
            preview.style.display = 'block';
        }
    }

    window.previewMarqueeIcon = previewMarqueeIcon;

    // ════════ HERO SLIDER IMAGE PREVIEW ════════
    function previewHeroImage(event) {
        const input = event.target;
        const preview = document.getElementById('heroImagePreview');

        if (!preview) return;

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    window.previewHeroImage = previewHeroImage;

    // ════════ HERO SLIDER VIDEO PREVIEW ════════
    function previewHeroVideo(event) {
        const input = event.target;
        const preview = document.getElementById('heroVideoPreview');

        if (!preview) return;

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    window.previewHeroVideo = previewHeroVideo;
})();
