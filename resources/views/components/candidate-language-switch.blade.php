@props(['default' => 'jp'])

<div data-candidate-language-switch data-default-language="{{ $default }}"
  class="inline-flex rounded-lg border border-slate-200 bg-white p-1 shadow-sm" role="group"
  aria-label="Pilih bahasa">
  <button type="button" data-candidate-language-button="id"
    class="inline-flex min-w-[6rem] items-center justify-center rounded-md px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-50"
    aria-pressed="false">
    Indonesia
  </button>
  <button type="button" data-candidate-language-button="jp"
    class="inline-flex min-w-[6rem] items-center justify-center rounded-md px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-50"
    aria-pressed="false">
    日本語
  </button>
</div>

@once
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const roots = document.querySelectorAll('[data-candidate-language-root]');

      if (!roots.length) {
        return;
      }

      const applyLanguage = (root, language) => {
        const selectedLanguage = language === 'id' ? 'id' : 'jp';

        root.querySelectorAll('[data-lang]').forEach((element) => {
          element.classList.toggle('hidden', element.dataset.lang !== selectedLanguage);
        });

        root.querySelectorAll('[data-candidate-language-button]').forEach((button) => {
          const isActive = button.dataset.candidateLanguageButton === selectedLanguage;
          button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
          button.classList.toggle('bg-slate-900', isActive);
          button.classList.toggle('text-white', isActive);
          button.classList.toggle('shadow-sm', isActive);
          button.classList.toggle('text-slate-600', !isActive);
        });

        localStorage.setItem('candidate-detail-language', selectedLanguage);
      };

      roots.forEach((root) => {
        const switchers = root.querySelectorAll('[data-candidate-language-switch]');
        const defaultLanguage = switchers[0]?.dataset.defaultLanguage || root.dataset.defaultLanguage || 'jp';
        const savedLanguage = localStorage.getItem('candidate-detail-language');

        applyLanguage(root, savedLanguage || defaultLanguage);

        switchers.forEach((switcher) => {
          switcher.addEventListener('click', (event) => {
            const button = event.target.closest('[data-candidate-language-button]');

            if (!button || !switcher.contains(button)) {
              return;
            }

            applyLanguage(root, button.dataset.candidateLanguageButton);
          });
        });
      });
    });
  </script>
@endonce
