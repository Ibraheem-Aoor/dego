<form class="form-row mt-4" action="{{ route('user.ticket.reply', $ticket->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="typing-area">
        <div class="img-preview-container">
        </div>
        <div class="input-group">
            <div>
                <button class="upload-img send-file-btn">
                    <i class="fal fa-paperclip"></i>
                    <input class="form-control" name="attachments[]"
                           accept="image/*"
                           type="file"
                           id="attachment"
                           multiple
                           onchange="previewTicketImages(event)"
                    />
                    @if($errors->has('attachments[]'))
                        <div class="error text-danger">@lang($errors->first('attachments[]'))</div>
                    @endif
                </button>
            </div>

            <input type="text" class="form-control" name="message" autocomplete="off"/>
            <button type="submit" class="submit-btn" name="replayTicket" value="1">
                <i class="fal fa-paper-plane"></i>
            </button>
        </div>
    </div>
</form>
@push('style')
    <style>
        .img-preview-container{
            display: flex;
            gap: 15px;
            padding: 10px;
        }
    </style>
@endpush
@push('script')
    <script>
        const previewTicketImages = (event) => {
            const files = event.target.files;
            const imgPreviewContainer = document.querySelector('.img-preview-container');

            imgPreviewContainer.innerHTML = '';

            Array.from(files).forEach(file => {
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '100px';
                        img.style.margin = '5px';

                        const imgContainer = document.createElement('div');
                        imgContainer.classList.add('img-preview');

                        const deleteButton = document.createElement('button');
                        deleteButton.innerHTML = '<i class="fas fa-times"></i>';
                        deleteButton.classList.add('delete');
                        deleteButton.onclick = () => {
                            imgPreviewContainer.removeChild(imgContainer);
                        };

                        imgContainer.appendChild(img);
                        imgContainer.appendChild(deleteButton);
                        imgPreviewContainer.appendChild(imgContainer);
                    };
                    reader.readAsDataURL(file);
                }
            });
        };
    </script>
@endpush
