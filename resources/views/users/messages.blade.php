@extends('layouts.app')

@section('title'){{ trans('general.messages') }} -@endsection

@section('content')
<section class="section section-sm pb-0 h-100 section-msg" style="min-height: 100vh;">
  <div class="d-flex h-100" style="width: 100%;">

    {{-- Left: Menu Sidebar - Desktop Only --}}
    {{-- <div class="d-none d-lg-block" 
         style="height: 100vh; border-right: 1px solid #ddd; padding: 20px; width: 15%; flex-shrink: 0;">
      @include('includes.menu-sidebar-home')
    </div> --}}

    {{-- Middle: Message Inbox Sidebar - Always Visible --}}
    <div class="wrapper-msg-inbox border-right" 
         id="messagesContainer"
         style="width: 100%; height: 100vh; flex-shrink: 0; overflow-y: auto;">
      @include('includes.sidebar-messages-inbox')
    </div>

    {{-- Right: Main Message Content - Desktop Only --}}
    <div class="flex-grow-1 h-100 d-none d-lg-block" style="overflow-y: auto;">
      <div class="card w-100 rounded-0 h-100 border-top-0 border-0">
        <div class="content px-4 py-3 d-scrollbars container-msg h-100">

          <div class="d-flex flex-column justify-content-center align-items-center text-center h-100">
            <div class="w-100">
              <h2 class="mb-0 font-montserrat">
                <i class="feather icon-send mr-2"></i> {{ trans('general.messages') }}
              </h2>
              <p class="lead text-muted mt-0">{{ trans('general.messages_subtitle') }}</p>
              <button class="btn btn-primary btn-sm w-small-100" 
                      data-toggle="modal" data-target="#newMessageForm">
                <i class="bi bi-plus-lg mr-1"></i> {{ trans('general.new_message') }}
              </button>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</section>

@include('includes.modal-new-message')
@endsection

@section('javascript')
<script src="{{ asset('js/messages.js') }}?v={{ $settings->version }}"></script>
<script src="{{ asset('js/fileuploader/fileuploader-msg.js') }}?v={{ $settings->version }}"></script>
<script src="{{ asset('js/paginator-messages.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  function handleResize() {
    const messagesContainer = document.getElementById('messagesContainer');
    const mainContent = document.querySelector('.wrapper-msg-inbox + .flex-grow-1');
    
    if (window.innerWidth < 992) {
      messagesContainer.style.width = '100%';
      if (mainContent) {
        mainContent.style.display = 'none';
      }
    } else {
      messagesContainer.style.width = '25%';
      if (mainContent) {
        mainContent.style.display = 'block';
      }
    }
  }
  
  handleResize();
  window.addEventListener('resize', handleResize);
});
</script>
@endsection