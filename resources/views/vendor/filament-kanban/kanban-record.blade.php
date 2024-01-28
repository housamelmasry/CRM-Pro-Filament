<div
    id="{{ $record['id'] }}"
    wire:click="recordClicked('{{ $record['id'] }}', {{ @json_encode($record) }})"
    class="record transition bg-white dark:bg-gray-700 rounded-lg px-4 py-2 cursor-grab font-medium text-gray-600 dark:text-gray-200"
    style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);"
    @if($record['just_updated'])
        x-data
        x-init="
            $el.classList.add('animate-pulse-twice', 'bg-primary-100', 'dark:bg-primary-800')
            $el.classList.remove('bg-white', 'dark:bg-gray-700')
            setTimeout(() => {
                $el.classList.remove('bg-primary-100', 'dark:bg-primary-800')
                $el.classList.add('bg-white', 'dark:bg-gray-700')
            }, 3000)
        "
    @endif
>
    <div style="font-size: 20px; font-weight: bold;"> <!-- Adjust the font-size as needed -->
        {{ $record['title'] }}
    </div>
    <div style="font-size: 14px; color: 'info' "> <!-- Adjust the font size as needed -->
        {{ $record['description'] }}
    </div>
    <div style="font-size: 16px; color: @if($record['priority'] === 'high') red @elseif($record['priority'] === 'medium') orange @else cyan @endif;">
        @if($record['priority'] === 'high')
            🚨 <!-- Unicode emoji for high priority -->
        @elseif($record['priority'] === 'medium')
            ⚠️ <!-- Unicode emoji for medium priority -->
        @else
            ℹ️ <!-- Unicode emoji for low priority -->
        @endif
        <b>  {{ $record['priority'] }}</b>
    </div>
    <div style="font-size: 14px; ">
        {{ $record['company'] }}
    </div>
</div>
