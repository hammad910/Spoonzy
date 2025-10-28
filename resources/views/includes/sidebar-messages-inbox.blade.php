<div class="w-100 p-3 border-bottom">
    <div class="w-100 d-flex align-items-center justify-content-between">
        <div>
            <a href="{{ url()->previous() }}" class="h4 mr-1 text-decoration-none">
                <i class="fa fa-arrow-left"></i>
            </a>

            <span class="h5 align-top font-weight-bold">{{ trans('general.messages') }}</span>
            <small
                style="color: {{ $settings->theme_color_pwa }}; background: {{ $settings->sidebar_bg_color }}; border-radius: 8px; padding: 2px 12px;">{{ $messagesInbox->count() }}</small>
        </div>

        <a href="#" class="h4 text-decoration-none" data-toggle="modal" data-target="#newMessageForm"
            title="{{ trans('general.new_message') }}">
            <i class="feather icon-edit"
                style="padding: 5px; border: 1px solid #D0D5DD; border-radius: 8px; color:#475467"></i>
        </a>
    </div>

    <div class="mt-3 d-flex" style="gap: 10px">
		<img src="/img/icon/" alt="">
        <input type="text" class="form-control" placeholder="Search"
            style="width: 100%; border-radius: 8px; border: 1px solid #D0D5DD; padding: 10px 14px; font-size: 15px;">
    </div>
</div>

@include('includes.messages-inbox')
