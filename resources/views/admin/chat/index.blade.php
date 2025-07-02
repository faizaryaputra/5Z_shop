@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-12 gap-4 h-[80vh] p-4">
  <!-- Sidebar User -->
  <div class="col-span-3 bg-white dark:bg-gray-800 rounded-xl shadow overflow-y-auto border border-gray-300 dark:border-gray-700">
    <h2 class="text-md font-semibold p-4 border-b dark:border-gray-700">User Chat</h2>
    <ul id="user-list">
      @foreach ($users as $user)
<li class="user-item px-4 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 flex justify-between items-center"
    data-id="{{ $user->id }}" data-name="{{ $user->name }}">
  <div>
    <div class="font-medium text-gray-900 dark:text-white flex items-center">
      {{ $user->name }}
      @if ($user->has_unread_messages)
        <span class="new-badge ml-2 px-2 py-1 text-xs bg-red-600 text-white rounded-full">NEW</span>
      @endif
    </div>
    <div class="text-sm text-gray-500">{{ $user->email }}</div>
  </div>
</li>
@endforeach
    </ul>
  </div>

  <!-- Chat Box -->
  <div class="col-span-9 bg-white dark:bg-gray-900 rounded-xl shadow flex flex-col border border-gray-300 dark:border-gray-700">
    <div class="p-3 border-b dark:border-gray-700 text-md font-semibold bg-gray-100 dark:bg-gray-800">
      <span id="chat-username">Pilih user untuk mulai chat</span>
    </div>
    <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-2 bg-gray-50 dark:bg-gray-800 relative">
      <div id="loading-chat" class="absolute top-1/2 left-1/2 -translate-x-1/2 text-gray-500 hidden">Loading chat...</div>
    </div>

    <form id="chat-form" class="flex items-center p-3 border-t dark:border-gray-700 bg-gray-100 dark:bg-gray-800">
      @csrf
      <input type="hidden" id="selected-user-id" name="user_id">
      <input type="text" id="chat-input" name="message"
             class="flex-1 p-2 rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white"
             placeholder="Ketik pesan..." autocomplete="off" required>
      <button type="submit"
              class="ml-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Kirim</button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const csrfToken = @json(csrf_token());
  const sendUrl = @json(route('admin.chat.send'));
  const markAsReadUrl = @json(route('admin.chat.markAsRead'));

  let selectedUserId = null;

  const userItems = document.querySelectorAll('.user-item');
  const chatUsername = document.getElementById('chat-username');
  const chatMessages = document.getElementById('chat-messages');
  const chatForm = document.getElementById('chat-form');
  const chatInput = document.getElementById('chat-input');
  const selectedUserInput = document.getElementById('selected-user-id');
  const loadingIndicator = document.getElementById('loading-chat');

  userItems.forEach(item => {
    item.addEventListener('click', function () {
      // Hapus highlight sebelumnya
      userItems.forEach(i => i.classList.remove('bg-blue-100', 'dark:bg-blue-800'));
      this.classList.add('bg-blue-100', 'dark:bg-blue-800');

      // Ambil data user
      selectedUserId = this.dataset.id;
      selectedUserInput.value = selectedUserId;
      chatUsername.textContent = this.dataset.name;

      // Hapus badge NEW (jika ada)
      const badge = this.querySelector('.new-badge');
      if (badge) badge.remove();

      // Tandai sebagai sudah dibaca
      fetch(markAsReadUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ user_id: selectedUserId })
      });

      fetchMessages();
    });
  });

  function fetchMessages() {
    if (!selectedUserId) return;

    loadingIndicator.classList.remove('hidden');

    fetch(`/admin/chat/fetch?user_id=${selectedUserId}`)
      .then(res => res.json())
      .then(messages => {
        chatMessages.innerHTML = '';
        messages.forEach(msg => {
          const wrapper = document.createElement('div'); // wrapper untuk baris baru
wrapper.className = `w-full flex ${msg.is_from_user ? 'justify-end' : 'justify-start'} mb-1`;

const bubble = document.createElement('div');
bubble.className = `px-3 py-3 rounded-lg max-w-[70%] text-[15px] leading-tight break-words ${
  msg.is_from_user ? 'bg-green-200 ml-auto text-right' : 'bg-blue-100 mr-auto text-left'
}`;
bubble.innerHTML = `
  <div>${msg.message}</div>
  <div class="text-xs text-gray-500 mt-1">${new Date(msg.created_at).toLocaleTimeString()}</div>`;

wrapper.appendChild(bubble);
chatMessages.appendChild(wrapper);

        });
        loadingIndicator.classList.add('hidden');
        chatMessages.scrollTop = chatMessages.scrollHeight;
      })
      .catch(() => {
        loadingIndicator.classList.add('hidden');
      });
  }

  chatForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const message = chatInput.value.trim();
    if (!message || !selectedUserId) return;

    fetch(sendUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify({
        user_id: selectedUserId,
        message: message
      })
    })
    .then(async res => {
      if (!res.ok) {
        const text = await res.text();
        throw new Error(text);
      }
      return res.json();
    })
    .then(() => {
      chatInput.value = '';
      fetchMessages();
    })
    .catch(err => {
      console.error("Gagal kirim pesan:", err);
    });
  });
});
</script>
@endpush
