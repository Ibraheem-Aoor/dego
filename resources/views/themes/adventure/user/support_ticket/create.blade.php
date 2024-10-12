@extends($theme.'layouts.user')
@section('title',trans('Create Ticket'))
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Dashboard')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-capitalize" href="{{ route('page','/') }}">@lang('home')</a></li>
                    <li class="breadcrumb-item active">@lang('Support Ticket Create')</li>
                </ol>
            </nav>
        </div>
        <div class="row card p-3 d-flex align-items-center justify-content-center">
            <div class="col-lg-10 col-sm-12">
                <div class="card-body">
                    <div class="search-bar">
                        <form class="form-row" action="{{route('user.ticket.store')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group mb-2">
                                    <label>@lang('Subject')</label>
                                    <input class="form-control" type="text" name="subject"
                                           value="{{old('subject')}}" placeholder="@lang('Enter Subject')">
                                    @error('subject')
                                    <div class="error text-danger">@lang($message) </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-2">
                                    <label>@lang('Message')</label>
                                    <textarea class="form-control ticket-box" name="message" rows="5"
                                              id="textarea1"
                                              placeholder="@lang('Enter Message')">{{old('message')}}</textarea>
                                    @error('message')
                                    <div class="error text-danger">@lang($message) </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12" id="form-group-container">
                                <div class="form-group mb-2">
                                    <div id="image-preview"></div>
                                    <label for="file-input" id="file-label" class="form-control ticketText d-none">@lang('Choose Files')</label>
                                    <input type="file" name="attachments[]"
                                           class="form-control ticketText"
                                           id="file-input"
                                           multiple
                                    >
                                    @error('attachments')
                                        <span class="text-danger">{{trans($message)}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="cmn-btn">
                                        <span>@lang('Submit')</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('script')
    <script>
        document.getElementById('file-input').addEventListener('change', function(event) {
            const preview = document.getElementById('image-preview');
            const fileInput = this;
            const fileLabel = document.getElementById('file-label');
            const formGroupContainer = document.getElementById('form-group-container');
            const files = Array.from(event.target.files);

            formGroupContainer.style.display = files.length ? 'block' : 'none';
            fileLabel.style.display = files.length ? 'block' : 'none';
            fileLabel.textContent = `${files.length} file(s) selected`;

            preview.innerHTML = '';

            files.forEach((file, index) => {
                const container = document.createElement('div');
                container.className = 'preview-container';
                container.style.cssText = 'position:relative;display:inline-block;margin:10px;';

                const closeIcon = document.createElement('span');
                closeIcon.innerHTML = '&times;';
                closeIcon.className = 'close-icon';
                closeIcon.style.cssText = 'position:absolute;top:5px;right:5px;cursor:pointer;background:rgba(255,255,255,0.8);border-radius:50%;padding:2px 5px;z-index:1;font-size:15px;';
                closeIcon.onclick = () => {
                    files.splice(index, 1);
                    previewImages({ target: { files } });
                };

                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.cssText = 'height:100px;width:100px;border-radius:15px;';
                    container.appendChild(img);
                } else {
                    const div = document.createElement('div');
                    div.textContent = file.name;
                    div.style.cssText = 'padding:20px;border:1px solid #ccc;border-radius:15px;width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;';
                    container.appendChild(div);
                }

                container.appendChild(closeIcon);
                preview.appendChild(container);
            });

            const dataTransfer = new DataTransfer();
            files.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;
        });
    </script>
@endpush
