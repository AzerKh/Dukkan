@extends('layouts.app')

@section('title', 'Chat avec ' . $contact->name)

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-4">
        <a href="{{ route('chat.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold">← Retour</a>
        <div class="w-10 h-10 rounded-full gradient-bg flex items-center justify-center text-white font-bold">
            {{ strtoupper(substr($contact->name, 0, 1)) }}
        </div>
        <div>
            <div class="font-bold text-gray-800">{{ $contact->name }}</div>
            <div class="text-xs text-gray-400">{{ $contact->email }}</div>
        </div>
    </div>

    {{-- Messages --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div id="chat-box" class="p-4 space-y-3 overflow-y-auto" style="height:440px;">
            @foreach($messages as $msg)
                <div class="flex {{ $msg->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                    <div class="px-4 py-2 rounded-2xl max-w-xs lg:max-w-sm break-words text-sm shadow-sm
                        {{ $msg->sender_id == Auth::id()
                            ? 'gradient-bg text-white'
                            : 'bg-gray-100 text-gray-800' }}">
                        {{ $msg->body }}
                        <div class="text-right mt-1 opacity-60" style="font-size:0.65rem">
                            {{ $msg->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Input --}}
        <div class="border-t p-4 flex gap-3">
            <input type="text" id="msg-input"
                   class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-purple-400"
                   placeholder="Écrire un message...">
            <button id="send-btn"
                    class="btn-primary text-white px-6 py-2.5 rounded-xl font-semibold text-sm">
                Envoyer
            </button>
        </div>
    </div>
</div>

<script>
    const AUTH_ID    = {{ Auth::id() }};
    const CONTACT_ID = {{ $contact->id }};
    const SEND_URL   = "{{ route('chat.send') }}";
    const FETCH_URL  = "{{ route('chat.fetch') }}";
    const CSRF       = "{{ csrf_token() }}";
    let lastId       = {{ $messages->last()?->id ?? 0 }};

    const chatBox = document.getElementById('chat-box');
    const input   = document.getElementById('msg-input');
    const sendBtn = document.getElementById('send-btn');

    function scrollBottom() { chatBox.scrollTop = chatBox.scrollHeight; }
    scrollBottom();

    function buildBubble(msg) {
        const isMine = msg.sender_id == AUTH_ID;
        const div = document.createElement('div');
        div.className = `flex ${isMine ? 'justify-end' : 'justify-start'}`;
        div.innerHTML = `
            <div class="px-4 py-2 rounded-2xl max-w-xs lg:max-w-sm break-words text-sm shadow-sm ${isMine ? 'gradient-bg text-white' : 'bg-gray-100 text-gray-800'}">
                ${msg.body}
                <div class="text-right mt-1 opacity-60" style="font-size:0.65rem">${msg.created_at}</div>
            </div>`;
        return div;
    }

    async function sendMessage() {
        const body = input.value.trim();
        if (!body) return;
        input.value = '';
        sendBtn.disabled = true;

        try {
            const res  = await fetch(SEND_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ receiver_id: CONTACT_ID, body })
            });
            const data = await res.json();
            if (data.success) {
                chatBox.appendChild(buildBubble(data.message));
                scrollBottom();
                lastId = data.message.id;
            }
        } finally {
            sendBtn.disabled = false;
            input.focus();
        }
    }

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', e => { if (e.key === 'Enter') sendMessage(); });

    setInterval(async () => {
        try {
            const res  = await fetch(`${FETCH_URL}?contact_id=${CONTACT_ID}&last_id=${lastId}`);
            const msgs = await res.json();
            msgs.forEach(msg => {
                chatBox.appendChild(buildBubble(msg));
                lastId = msg.id;
            });
            if (msgs.length) scrollBottom();
        } catch(e) {}
    }, 3000);
</script>
@endsection