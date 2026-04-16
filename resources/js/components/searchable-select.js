export default function InitSearchableSelect(){
  fetch('/japan.json')
  .then(response => response.json())
  .then(data => {
    const wrapper = document.getElementById('select-location');
    const toggle = document.getElementById('japan-pref-toggle');
    const panel = document.getElementById('japan-pref-panel');
    const search = document.getElementById('japan-pref-search');
    const list = document.getElementById('japan-pref-list');
    const valueInput = document.getElementById('japan-pref-value');
    const label = document.getElementById('japan-pref-label');
    const allPrefectures = Array.isArray(data.japan_prefectures) ? data.japan_prefectures : [];

    const renderOptions = (items) => {
      list.innerHTML = '';
      const allItem = document.createElement('button');
      allItem.type = 'button';
      allItem.className =
        'w-full text-left cursor-pointer rounded-lg px-3 py-2 hover:bg-slate-100';
      allItem.textContent = 'Semua prefektur';
      allItem.dataset.value = '';
      list.appendChild(allItem);

      items.forEach(prefecture => {
        const item = document.createElement('button');
        item.type = 'button';
        item.className =
          'w-full text-left cursor-pointer rounded-lg px-3 py-2 hover:bg-slate-100';
        item.textContent = prefecture;
        item.dataset.value = prefecture;
        list.appendChild(item);
      });
    };

    renderOptions(allPrefectures);

    search.addEventListener('input', () => {
      const query = search.value.trim().toLowerCase();
      if (!query) {
        renderOptions(allPrefectures);
        return;
      }
      const filtered = allPrefectures.filter((prefecture) =>
        String(prefecture).toLowerCase().includes(query)
      );
      renderOptions(filtered);
    });

    const openPanel = () => {
      panel.classList.remove('hidden');
      toggle.setAttribute('aria-expanded', 'true');
      search.focus();
    };

    const closePanel = () => {
      panel.classList.add('hidden');
      toggle.setAttribute('aria-expanded', 'false');
      search.value = '';
      renderOptions(allPrefectures);
    };

    toggle.addEventListener('click', (event) => {
      event.stopPropagation();
      if (panel.classList.contains('hidden')) {
        openPanel();
      } else {
        closePanel();
      }
    });

    list.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();
      const target = event.target.closest('button');
      if (!target) return;
      const value = target.dataset.value || '';
      valueInput.value = value;
      label.textContent = value || 'Semua prefektur';
      label.classList.toggle('text-slate-400', !value);
      label.classList.toggle('text-slate-900', !!value);
      closePanel();
    });

    document.addEventListener('click', (event) => {
      if (!wrapper.contains(event.target)) {
        closePanel();
      }
    });
  });
}