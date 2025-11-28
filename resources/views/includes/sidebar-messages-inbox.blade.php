<style>
    .search::placeholder {
        color: #B0B7C3;
        /* whatever color you want */
        opacity: 1;
        /* ensures full color */
    }
</style>
<div class="w-100 p-3 border-bottom">
    <div class="w-100 d-flex align-items-center justify-content-between">
        <div>
            <span class="h5 align-top font-weight-bold" style="color: #101828;">{{ trans('general.messages') }}</span>
            <small
                style="color: #469DFA; background: {{ $settings->sidebar_bg_color }}; border-radius: 16px; padding: 2px 12px;">{{ $messagesInbox->count() }}</small>
        </div>

        <a href="#" class="h4 text-decoration-none" data-toggle="modal" data-target="#newMessageForm"
            title="{{ trans('general.new_message') }}">
            {{-- <i class="feather icon-edit" --}}
            {{-- style="padding: 5px; border: 1px solid #D0D5DD; border-radius: 8px; color:#475467"></i> --}}
            <div style="padding: 0 8px 4px 8px; border: 1px solid #D0D5DD; border-radius: 8px">
                <img src="/svgs/messages.svg" alt="">
            </div>
        </a>
    </div>

    <div class="mt-3 d-flex form-control align-items-center" style="width: 100%; gap: 8px; border-radius: 8px; border: 1px solid #D0D5DD; padding: 10px 14px; font-size: 16px;">
        <img src="/images/search.png" style="width: 20px; height: 20px;" alt="">
        <input type="text" class="search" placeholder="Search">
    </div>
</div>

@include('includes.messages-inbox')
