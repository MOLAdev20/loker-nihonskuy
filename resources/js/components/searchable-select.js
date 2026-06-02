export default function InitSearchableSelect() {
  const wrappers = document.querySelectorAll("[data-searchable-select]");

  if (!wrappers.length) {
    return;
  }

  fetch("/japan.json")
    .then((response) => response.json())
    .then((data) => {
      const allPrefectures = Array.isArray(data.japan_prefectures) ? data.japan_prefectures : [];

      wrappers.forEach((wrapper) => {
        const toggle = wrapper.querySelector("[data-searchable-select-toggle]");
        const panel = wrapper.querySelector("[data-searchable-select-panel]");
        const search = wrapper.querySelector("[data-searchable-select-search]");
        const list = wrapper.querySelector("[data-searchable-select-list]");
        const valueInput = wrapper.querySelector("[data-searchable-select-value]");
        const label = wrapper.querySelector("[data-searchable-select-label]");

        if (!toggle || !panel || !search || !list || !valueInput || !label) {
          return;
        }

        const renderOptions = (items) => {
          list.innerHTML = "";

          const createOption = (value, text) => {
            const item = document.createElement("button");
            item.type = "button";
            item.className = "w-full cursor-pointer rounded-lg px-3 py-2 text-left hover:bg-slate-100";
            item.textContent = text;
            item.dataset.value = value;
            return item;
          };

          list.appendChild(createOption("", "Semua prefektur"));

          items.forEach((prefecture) => {
            list.appendChild(createOption(prefecture, prefecture));
          });
        };

        const syncLabel = () => {
          const value = valueInput.value || "";
          label.textContent = value || "Semua prefektur";
          label.classList.toggle("text-slate-400", !value);
          label.classList.toggle("text-slate-900", Boolean(value));
        };

        const openPanel = () => {
          panel.classList.remove("hidden");
          toggle.setAttribute("aria-expanded", "true");
          search.focus();
        };

        const closePanel = () => {
          panel.classList.add("hidden");
          toggle.setAttribute("aria-expanded", "false");
          search.value = "";
          renderOptions(allPrefectures);
        };

        renderOptions(allPrefectures);
        syncLabel();

        search.addEventListener("input", () => {
          const query = search.value.trim().toLowerCase();

          if (!query) {
            renderOptions(allPrefectures);
            return;
          }

          const filtered = allPrefectures.filter((prefecture) => String(prefecture).toLowerCase().includes(query));
          renderOptions(filtered);
        });

        toggle.addEventListener("click", (event) => {
          event.stopPropagation();

          if (panel.classList.contains("hidden")) {
            openPanel();
          } else {
            closePanel();
          }
        });

        list.addEventListener("click", (event) => {
          event.preventDefault();
          event.stopPropagation();
          const target = event.target.closest("button");

          if (!target) {
            return;
          }

          valueInput.value = target.dataset.value || "";
          syncLabel();
          closePanel();
        });

        document.addEventListener("click", (event) => {
          if (!wrapper.contains(event.target)) {
            closePanel();
          }
        });
      });
    });
}
