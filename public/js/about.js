function fetchMessages() {
    fetch('/chat/fetch')
      .then(res => res.json())
      .then(data => {
        const messagesDiv = document.getElementById('chat-messages');
        messagesDiv.innerHTML = '';

        data.messages.forEach(msg => {
          const messageDiv = document.createElement('div');
          messageDiv.classList.add('chat-message');

          if (msg.from === 'user') {
            messageDiv.classList.add('user');
          } else {
            messageDiv.classList.add('admin');
          }

          messageDiv.innerHTML = `<strong>${msg.name}</strong><br>${msg.message}`;
          messagesDiv.appendChild(messageDiv);
        });

        // Auto scroll to bottom
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
      });
  }

  // Form submit handler
  document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const messageInput = document.getElementById('chat-input');
    const message = messageInput.value.trim();
    if (!message) return;

    fetch(`{{ route('chat.send') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message })
    }).then(res => res.json())
    .then(data => {
        if (data.status === 'sent') {
            messageInput.value = '';
            fetchMessages(); // atau tampilkan langsung chat baru
        }
    });
});
// ============== SCROLL REVEAL ANIMATION ================
const sr = ScrollReveal({
  distance: "200px",
  duration: 3500,
  delay: 200,
  reset: true,
});

sr.reveal(".home-container h3", {
  opacity: 0,  
  scale: 0.8, // Mulai lebih kecil agar efek lebih smooth
  duration: 2500,  
  easing: "ease-in-out",
  beforeReveal: function (el) {
    el.style.opacity = "0"; // Pastikan tidak terlihat di awal
    el.style.transition = "opacity 2s ease-in-out, box-shadow 1.5s ease-in-out"; 
    el.style.boxShadow = "0px 0px 30px rgba(255, 255, 255, 0.9)"; // Cahaya lebih kuat

    setTimeout(() => {
      el.style.opacity = "1"; // Perlahan muncul
    }, 1200); // Delay kecil agar efek smooth

    setTimeout(() => {
      el.style.boxShadow = "none"; // Hilangkan glow setelah muncul
    }, 1500);
  }
});
sr.reveal(".home-container .logo", {
  origin: "top",
  distance: "100px",
  opacity: 0,
  scale: 0.8,
  rotate: { x: 0, y: 180, z: 0 },
  duration: 2500,
  easing: "ease-out"
});
sr.reveal(".home-container .right", {
  opacity: 0,  
  scale: 0.8, // Mulai lebih kecil agar efek lebih smooth
  duration: 2500,  
  easing: "ease-in-out",
  beforeReveal: function (el) {
    el.style.opacity = "0"; // Pastikan tidak terlihat di awal
    el.style.transition = "opacity 2s ease-in-out, box-shadow 1.5s ease-in-out"; 
    el.style.boxShadow = "0px 0px 30px rgba(255, 255, 255, 0.9)"; // Cahaya lebih kuat

    setTimeout(() => {
      el.style.opacity = "1"; // Perlahan muncul
    }, 1200); // Delay kecil agar efek smooth

    setTimeout(() => {
      el.style.boxShadow = "none"; // Hilangkan glow setelah muncul
    }, 1500);
  }
});
sr.reveal(".social-icons-container", {
  opacity: 0,  
  scale: 0.8, // Mulai lebih kecil agar efek lebih smooth
  duration: 2500,  
  easing: "ease-in-out",
  beforeReveal: function (el) {
    el.style.opacity = "0"; // Pastikan tidak terlihat di awal
    el.style.transition = "opacity 2s ease-in-out, box-shadow 1.5s ease-in-out"; 
    el.style.boxShadow = "0px 0px 30px rgba(255, 255, 255, 0.9)"; // Cahaya lebih kuat

    setTimeout(() => {
      el.style.opacity = "1"; // Perlahan muncul
    }, 1200); // Delay kecil agar efek smooth

    setTimeout(() => {
      el.style.boxShadow = "none"; // Hilangkan glow setelah muncul
    }, 1500);
  }
});
sr.reveal(".about-container .title", { origin: "right" });
sr.reveal(".about-container h3", { origin: "bottom" });
sr.reveal(".about-container p", { origin: "bottom" });
sr.reveal(".about-container .left", { origin: "left" });
sr.reveal(".about-container .right", { origin: "right" });
sr.reveal(".menu .title", { origin: "top" });
sr.reveal(".menu .content-1", { origin: "left" });
sr.reveal(".menu .content-2", { origin: "right" });
sr.reveal(".gallery-container", { origin: "bottom" });
sr.reveal(".gallery .title", { origin: "top" });
sr.reveal(".gallery-buttons", { origin: "left" });
sr.reveal(".contact .title", { origin: "top" });
sr.reveal(".contact .row .box", { origin: "right" });
sr.reveal(".contact .row .contact-form", { origin: "left" });