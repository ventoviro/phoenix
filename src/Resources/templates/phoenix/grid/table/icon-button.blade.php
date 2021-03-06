{{-- Part of Phoenix project. --}}

@if (!empty($only_icon))
    <span class="{{ $icon or '' }} has-tooltip icon-button" title="@lang($title)"></span>
@else
    <button type="button"
        class="icon-button grid-boolean-icon disable-on-submit data-state-{{ $value or '' }} btn {{ $options['button_color'] or 'btn-default btn-light btn-sm' }} has-tooltip"
        title="@lang($title)"
        {{ !empty($disabled) ? 'disabled' : null }}

        @if (!empty($options['onclick']))
        onclick="{!! $options['onclick'] !!}"
        @elseif (!empty($options['href']))
        onclick="location.href = '{{ $options['href'] }}'"
        @elseif (!empty($task))
        onclick="{{ $phoenix_js_object }}.Grid.doTask('{{ $task or '' }}', {{ $row or '' }})"
        @endif
    >
        <span class=" icon-button-icon {{ $icon or null }}"></span>

        @if (!empty($options['text']))
            <span class="icon-button-text {{ $options['text_color'] or '' }}">{{ $options['text'] }}</span>
        @endif
    </button>
@endif
