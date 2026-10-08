document.querySelector('.show-password')?.addEventListener('click', function () {
  const input = document.querySelector('#password');
  const isHidden = input.type === 'password';
  input.type = isHidden ? 'text' : 'password';
  this.textContent = isHidden ? '◉' : '○';
});
document.querySelector('#search')?.addEventListener('input', function () {
  const query = this.value.toLowerCase();
  document.querySelectorAll('#items tr').forEach(row => row.hidden = !row.textContent.toLowerCase().includes(query));
});
document.querySelector('#addItem')?.addEventListener('click', () => alert('Next step: connect this button to an Add Item form and MySQL.'));
