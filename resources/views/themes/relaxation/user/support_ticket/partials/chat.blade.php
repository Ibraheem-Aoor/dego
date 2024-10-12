@if(count($ticket->messages) > 0)
    <div class="chats">
        @foreach($ticket->messages as $item)
            @if($item->admin_id == null)
                @if($item->message == null)
                    <div class="chat-box this-side">
                        <div class="text-wrapper">
                            @if(0 < count($item->attachments))
                                <div class="attachment-wrapper">
                                    @foreach($item->attachments as $k=> $file)
                                        <a
                                            class="attachment"
                                            href="{{route('user.ticket.download',encrypt($file->id))}}"
                                        >
                                            <i class="fa fa-file"></i> @lang('File') {{++$k}}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                            <small class="time"> {{dateTime($item->created_at, 'd M, y h:i A')}}</small>
                        </div>
                        <div class="img">
                            <img class="img-fluid" src="{{ getFile(optional($ticket->user)->image_driver, optional($ticket->user)->image) }}" alt="@lang('Chat Image')" />
                        </div>
                    </div>
                @else
                    <div class="chat-box this-side">
                        <div class="text-wrapper">
                            <div class="text">
                                <p>
                                    {{$item->message}}
                                </p>
                            </div>
                            @if(0 < count($item->attachments))
                                <div class="attachment-wrapper">
                                    @foreach($item->attachments as $k=> $file)
                                        <a
                                            class="attachment"
                                            href="{{route('user.ticket.download',encrypt($file->id))}}"
                                        >
                                            <i class="fa fa-file"></i> @lang('File') {{++$k}}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                            <small class="time"> {{dateTime($item->created_at, 'd M, y h:i A')}}</small>
                        </div>
                        <div class="img">
                            <img class="img-fluid" src="{{ getFile(optional($ticket->user)->image_driver, optional($ticket->user)->image) }}" alt="@lang('User Image')" />
                        </div>
                    </div>
                @endif
            @else
                <div class="chat-box opposite-side">
                    <div class="img">
                        <img class="img-fluid" src="{{ getFile(optional($item->admin)->image_driver , optional($item->admin)->image ) }}" alt="@lang('Admin Image')" />
                    </div>
                    <div class="text-wrapper">
                        <div class="text">
                            <p>{{ $item->message }}</p>
                        </div><br>
                        <div class="attachment-wrapper">
                            @foreach($item->attachments as $k=> $file)
                                <a class="attachment"
                                   href="{{route('user.ticket.download',encrypt($file->id))}}">
                                    <i class="fa fa-file"></i> @lang('File') {{++$k}}
                                </a><br>
                            @endforeach
                        </div>
                        <small class="time">{{dateTime($item->created_at, 'd M, y h:i A')}}</small>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif

