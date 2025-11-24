<div class="position-relative mb-2" style="height:50px">

    <div class="position-absolute top-50 start-50 translate-middle d-flex align-items-center justify-content-center rounded d-none d-md-block text-center px-2"
        style="background-color: #f1bdb2; color:#ffffff; max-width:80%; height:50px;">
        @if (isset($partner) && $partner )
            <h2 class="mb-0 text-truncate" style="font-size:24px; line-height: 50px;">Talking with {{ $partner->name }}</h2>
        @else
            <h2 class="mb-0 text-muted" style="font-size:24px; line-height: 50px;">No active conversation</h2>
        @endif
    </div>

    {{--　delete button --}}
    @if (isset($conversation) && $conversation)
        <div class="position-absolute top-50 end-0 translate-middle-y d-flex align-items-center d-none d-md-block">
            <form action="{{ route('conversations.destroy', $conversation->id )}}" method="post" onsubmit="return confirm('Delete this conversation?')">
                @csrf
                @method('DELETE')
                <button type="submit" style="color:#f1bdb2;">Delete &nbsp;<i class="fa-solid fa-trash" style="font-size:35px;"></i></button>
            </form>
        </div>
    @endif
</div>

<div class="message-board mb-3 rounded d-flex flex-column" style="height: calc(100vh - 320px);">
    @if (!isset($conversation))
        <div class="p-4 text-center text-muted">
            Select a conversation to start chatting.
        </div>
    @else
        <div class="messages-list mb-4 p-4 flex-grow-1" style="overflow-y:auto;">
            @foreach ($conversation->messages as $message)
                <div class="d-flex mb-2 {{ $message->sender_id == $user_id ? 'justify-content-end' : 'justify-content-start' }} align-items-start">
                    {{-- if this message is partner, show partnar icon --}}
                    @if ($message->sender_id != $user_id)
                        <div class="chat-avatar me-2">
                            <a href="{{ route('profile.show', $partner->id) }}">
                                <img src="{{ $partner->avatar ?? asset('images/default-avatar.png') }}" 
                                alt="{{ $partner->name }}" 
                                class="rounded-circle" style="width:40px; height:40px; object-fit:cover;">
                            </a>
                        </div>
                    @endif
                    {{-- if this message is login user, don't show icon --}}
                    @if ($message->sender_id == $user_id)
                        <div class="ms-2"></div>
                    @endif

                    <div id="message-{{ $message->id }}" class="chat-message {{ $message->sender_id == $user_id ? 'sent' : 'received' }}">
                    
                        @if ($message->content)
                            <p class="px-1 mb-1">{{ $message->content }}</p>
                        @endif

                        @if ($message->image_path)
                            <img src="{{ asset('storage/'.$message->image_path) }}" alt="image" style="max-width:200px; border-radius:10px; margin-top:5px;">
                        @endif
                        
                        <small class="message-time text-muted d-inline me-2">
                            {{ $message->created_at->format('m/d H:i') }}
                        </small>

                        @if ($message->sender_id == $user_id)
                            @if ($message->read_at)
                                <small class="ms-1" style="font-size: 11px;">Read</small>
                            @endif
                        @endif

                        @if ($message->sender_id == $user_id)
                            <button class="delete-message-btn" data-url="{{ route('messages.destroy', $message->id) }}" style="color:#f1bdb2;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        @endif
                    </div>
                </div>
                

                
            @endforeach
        </div>
    @endif  
</div>

<div class="d-flex w-100">
    @if(isset($conversation))
        <form action="{{ route('messages.store') }}" method="post" id="chatForm" class="d-flex align-items-center w-100 gap-3" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                <input type="text" name="content" id="content" class="form-control" placeholder="Enter a message">

                <input type="file" name="image" id="imageInput" accept="image/*" style="display:none">
                <i class="fa-solid fa-image" id="imageIcon" style="font-size: 38px;cursor:pointer; color: #f1bdb2;"></i>
            
                <button type="submit" class="btn custom-btn">Send</button>
        </form>
    @endif
</div>

{{-- preview --}}
<div id="imagePreviewContainer" class="mt-2" style="display:none; position: relative; width: fit-content;">
    <p class="text-muted mb-1">Preview:</p>
    <div style="position: relative; display:inline-block;">
        <img id="imagePreview" src="" alt="Preview" style="max-width:150px; border-radius:10px; cursor:pointer;">
        <span id="cancelImageBtn">&times;</span>
    </div>
</div>

{{--　modal --}}
<div id="imageModal" class="custom-image-modal-overlay" style="display:none;">
  <div class="custom-image-modal-content">
    <span class="custom-image-close-btn">&times;</span>
    <img id="modalImage" src="" alt="Preview" style="max-width:90%; max-height:80vh; border-radius:10px;">
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const userId = @json(2);
    const messageBoard = document.querySelector(".messages-list");

    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    //  Ajax Message Send
    const chatForm = document.getElementById("chatForm");
    const imageInput = document.getElementById("imageInput");
    const imageIcon = document.getElementById("imageIcon");
    const imagePreview = document.getElementById("imagePreview");
    const imagePreviewContainer = document.getElementById("imagePreviewContainer");
    const imageModal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");
    const cancelImageBtn = document.getElementById("cancelImageBtn");

    // click image
    imageIcon && imageIcon.addEventListener("click", () => imageInput.click());

    // preview
    imageInput.addEventListener("change", function(){
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            imagePreview.src = e.target.result;
            imagePreviewContainer.style.display = "block";
        };
        reader.readAsDataURL(file);
    });

    // show modal
    imagePreview.addEventListener("click", () => {
        modalImage.src = imagePreview.src;
        imageModal.style.display = "flex";
    });

    // clase modal
    document.querySelector(".custom-image-close-btn").onclick = () => imageModal.style.display = "none";

    cancelImageBtn.addEventListener("click", () => {
        imageInput.value = "";
        imagePreviewContainer.style.display = "none";
    });

    // send Ajax
    chatForm.addEventListener("submit", function(e){
        e.preventDefault();

        const formData = new FormData(chatForm);

        fetch(chatForm.action, {
            method: "POST",
            body: formData,
            headers: { "X-CSRF-TOKEN": csrf }
        })
        .then(res => res.json())
        .then(data => {

            if (!data.success) {
                alert(data.error || "Error");
                return;
            }

            // ====== add messege ======
            let msg = data.message;

            let div = document.createElement("div");
            div.id = "message-" + msg.id;
            div.className = "chat-message sent";

            if (msg.content) {
                let p = document.createElement("p");
                p.textContent = msg.content;
                div.appendChild(p);
            }

            if (msg.image_url) {
                let img = document.createElement("img");
                img.src = msg.image_url;
                img.style.maxWidth = "200px";
                img.style.borderRadius = "10px";
                div.appendChild(img);
            }

            let small = document.createElement("small");
            small.className = "message-time text-muted d-inline me-2";
            small.textContent = msg.created_at;
            div.appendChild(small);

            // delete button（Ajax）
            let del = document.createElement("button");
            del.className = "delete-message-btn";
            del.dataset.url = `/messages/destroy/${msg.id}`;
            del.style.color = "#f1bdb2";
            del.innerHTML = `<i class="fa-solid fa-trash"></i>`;
            div.appendChild(del);

            messageBoard.appendChild(div);
            messageBoard.scrollTop = messageBoard.scrollHeight;

            // reset form
            chatForm.reset();
            imagePreviewContainer.style.display = "none";

            // update user list
            refreshConversationList();
        });
    });

    //  Ajax Delete Message
    document.addEventListener("click", function(e) {
        const btn = e.target.closest(".delete-message-btn");
        if (!btn) return; // delete ボタン以外は無視

        const url = btn.dataset.url;  // Bladeで設定したURL
        const messageId = btn.closest(".chat-message").id.split("-")[1];

        console.log("Deleting message ID:", messageId, "URL:", url); // 確認用

        fetch(url, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": csrf,
                "Content-Type": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // 右側のメッセージ削除
                const msgDiv = document.getElementById("message-" + messageId);
                if (msgDiv) msgDiv.remove();

                // 左側リスト更新
                refreshConversationList();
            } else {
                console.error(data.error || "Failed to delete message");
            }
        })
        .catch(err => console.error("Delete Error:", err));
    });

    function refreshConversationList() {
        fetch("{{ route('conversations.refresh_list') }}", {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(res => {
            if (!res.ok) throw new Error("Failed to refresh conversation list");
            return res.text();
        })
        .then(html => {
            const pc = document.querySelector("#conversation-items-pc");
            const mobile = document.querySelector("#conversation-items-mobile");

            if (pc) pc.innerHTML = html;
            if (mobile) mobile.innerHTML = html;
        })
        .catch(err => console.error("List Refresh Error:", err));
    }

    if (messageBoard) {
        messageBoard.scrollTop = messageBoard.scrollHeight;
    }

});

</script>