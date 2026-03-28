const STORAGE_KEY = 'items';

type TodoItem = { id: number; text?: string; title?: string };

let state = {
  items: JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]') as TodoItem[],
};

const root = document.getElementById('app')!;

function getItemLabel(item: TodoItem): string {
  return ((item && (item.title || item.text)) || '(untitled)').trim();
}

const setState = (patch: Partial<typeof state> | ((s: typeof state) => Partial<typeof state>)) => {
  state = {
    ...state,
    ...(typeof patch === 'function' ? patch(state) : patch),
  };
  localStorage.setItem(STORAGE_KEY, JSON.stringify(state.items));
  render();
};

function render() {
  root.innerHTML = '';
  const main = document.createElement('main');

  const list = state.items.reduce(
    (html, item) =>
      `${html}
        <li id="${item.id}">
          ${getItemLabel(item)}
          <button data-remove>✘</button>
        </li>`,
    '',
  );

  main.innerHTML = `<form>
      <input placeholder="Todo…" />
      <button type="submit">Add</button>
    </form>
    <ul>${list}</ul>`;

  const form = main.querySelector('form')!;

  form.onsubmit = (e: SubmitEvent) => {
    e.preventDefault();
    const input = main.querySelector('input') as HTMLInputElement;
    const text = (input.value || '').trim();
    if (!text) return;
    setState((s) => ({
      items: [...s.items, { id: Date.now(), text }],
    }));
    input.value = '';
  };

  main.onclick = (e: MouseEvent) => {
    const button = e.target as HTMLElement | null;
    if (!button?.matches?.('[data-remove]')) return;
    const id = button.closest('li')?.getAttribute('id');
    setState((s) => ({
      items: s.items.filter((x) => x.id !== Number(id)),
    }));
  };

  root.appendChild(main);
}

render();

export {};
