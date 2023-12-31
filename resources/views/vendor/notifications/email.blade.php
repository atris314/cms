@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('بااحترام'),<br>
یابانه
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
    @lang( " این ایمیل به صورت خودکار ارسال شده است از پاسخگویی به آن خودداری نمایید.")
{{--@lang(--}}
{{--    "اگر برای کلیک روی دکمه \":actionText\"  دچار مشکل شدید\n".--}}
{{--    'این لینک را کپی و در مرورگر خود جایگزاری کنید:',--}}
{{--    [--}}
{{--        'actionText' => $actionText,--}}
{{--    ]--}}
{{--) --}}
{{--<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>--}}
@endslot
@endisset
@endcomponent
