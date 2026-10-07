/**
 * Popup konfirmasi bertema FreshWash.
 * Menggantikan kotak confirm() bawaan browser pada tautan/tombol yang memakai
 * opsi 'confirm' dari CakePHP (Form->postLink), tanpa mengubah perilaku form.
 *
 * Atribut opsional pada tautan:
 *   data-confirm-title  Judul popup
 *   data-confirm-ok     Teks tombol konfirmasi
 *   data-confirm-type   "danger" (merah) atau "info" (biru, bawaan)
 *   data-open-url       Tab baru yang dibuka saat konfirmasi ditekan (mis. link WhatsApp)
 */
(function () {
    'use strict';

    var nativeConfirm = window.confirm;
    var root, box, iconEl, titleEl, msgEl, okBtn, cancelBtn;
    var pending = null;
    var lastFocus = null;
    var hideTimer = null;

    function build() {
        if (root) {
            return;
        }
        root = document.createElement('div');
        root.className = 'fw-modal';
        root.hidden = true;
        root.innerHTML =
            '<div class="fw-modal-box" role="alertdialog" aria-modal="true" ' +
            'aria-labelledby="fw-modal-title" aria-describedby="fw-modal-msg">' +
            '<span class="fw-modal-ico"></span>' +
            '<h3 id="fw-modal-title"></h3>' +
            '<p id="fw-modal-msg"></p>' +
            '<div class="fw-modal-act">' +
            '<button type="button" class="fw-modal-cancel">Batal</button>' +
            '<button type="button" class="fw-modal-ok">Ya</button>' +
            '</div></div>';
        document.body.appendChild(root);

        box = root.querySelector('.fw-modal-box');
        iconEl = root.querySelector('.fw-modal-ico');
        titleEl = root.querySelector('h3');
        msgEl = root.querySelector('p');
        okBtn = root.querySelector('.fw-modal-ok');
        cancelBtn = root.querySelector('.fw-modal-cancel');

        okBtn.addEventListener('click', accept);
        cancelBtn.addEventListener('click', close);
        root.addEventListener('mousedown', function (e) {
            if (e.target === root) {
                close();
            }
        });
        root.addEventListener('keydown', onKey);
    }

    // Teks bawaan CakePHP ("Are you sure you want to delete # 3?") dijadikan bahasa Indonesia.
    function localize(text) {
        var d = /^Are you sure you want to delete # ?(\S+?)\?$/i.exec(text);
        return d ? 'Yakin ingin menghapus data #' + d[1] + '? Tindakan ini tidak bisa dibatalkan.' : text;
    }

    function getMessage(el) {
        return localize(readMessage(el));
    }

    function readMessage(el) {
        var m = el.getAttribute('data-confirm-message');
        if (m) {
            return m;
        }
        var oc = el.getAttribute('onclick') || '';
        var r = /confirm\(\s*("(?:[^"\\]|\\.)*"|'(?:[^'\\]|\\.)*')\s*\)/.exec(oc);
        if (!r) {
            return 'Lanjutkan tindakan ini?';
        }
        var s = r[1];
        if (s.charAt(0) === '"') {
            try {
                return JSON.parse(s);
            } catch (err) { /* pakai teks mentah di bawah */ }
        }
        return s.slice(1, -1);
    }

    function open(el) {
        build();
        clearTimeout(hideTimer);

        var message = getMessage(el);
        var type = el.getAttribute('data-confirm-type') ||
            (/hapus|delete/i.test(message) ? 'danger' : 'info');
        var danger = type === 'danger';

        root.classList.toggle('danger', danger);
        iconEl.innerHTML = '<i data-lucide="' + (danger ? 'trash-2' : 'refresh-cw') + '"></i>';
        titleEl.textContent = el.getAttribute('data-confirm-title') ||
            (danger ? 'Hapus data ini?' : 'Konfirmasi tindakan');
        msgEl.textContent = message;
        okBtn.textContent = el.getAttribute('data-confirm-ok') || (danger ? 'Ya, hapus' : 'Ya, lanjutkan');
        if (window.lucide && window.lucide.createIcons) {
            window.lucide.createIcons();
        }

        pending = el;
        lastFocus = document.activeElement;
        root.hidden = false;
        // Paksa reflow supaya animasi masuk berjalan.
        void root.offsetWidth;
        root.classList.add('show');
        (danger ? cancelBtn : okBtn).focus();
    }

    function close() {
        if (!root || root.hidden) {
            return;
        }
        pending = null;
        root.classList.remove('show');
        hideTimer = setTimeout(function () {
            root.hidden = true;
        }, 180);
        if (lastFocus && lastFocus.focus) {
            lastFocus.focus();
        }
    }

    function accept() {
        var el = pending;
        close();
        if (!el) {
            return;
        }
        // Opsional: buka tab baru (mis. WhatsApp) tepat saat user menekan tombol konfirmasi.
        // Dilakukan di sini agar dihitung sebagai aksi user dan tidak diblokir browser.
        var url = el.getAttribute('data-open-url');
        if (url) {
            window.open(url, '_blank', 'noopener');
        }
        // Klik ulang elemen asli: confirm() dibuat langsung "ya",
        // sehingga handler bawaan CakePHP tetap yang mengirim form.
        el.__fwOk = true;
        window.confirm = function () {
            return true;
        };
        try {
            el.click();
        } finally {
            window.confirm = nativeConfirm;
        }
    }

    function onKey(e) {
        if (e.key === 'Escape') {
            e.preventDefault();
            close();
            return;
        }
        if (e.key === 'Tab') {
            var first = cancelBtn;
            var last = okBtn;
            if (e.shiftKey && document.activeElement === first) {
                e.preventDefault();
                last.focus();
            } else if (!e.shiftKey && document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }
    }

    // Fase capture: berjalan sebelum onclick bawaan dari CakePHP.
    document.addEventListener('click', function (e) {
        var el = e.target.closest ? e.target.closest('[data-confirm-message], [onclick*="confirm("]') : null;
        if (!el) {
            return;
        }
        if (el.__fwOk) {
            el.__fwOk = false;
            return;
        }
        e.preventDefault();
        e.stopImmediatePropagation();
        open(el);
    }, true);
})();
