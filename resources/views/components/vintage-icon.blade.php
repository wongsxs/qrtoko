@props(['name', 'class' => 'w-4 h-4'])

@php
    $resPath = resource_path("icons/print/{$name}.svg");
    $pubPath = public_path("icons/print/{$name}.svg");
    $svgContent = '';

    if (file_exists($resPath)) {
        $svgContent = file_get_contents($resPath);
    } elseif (file_exists($pubPath)) {
        $svgContent = file_get_contents($pubPath);
    }

    if ($svgContent) {
        $svgContent = preg_replace('/(width|height)="\d+"/', '', $svgContent);
        $svgContent = preg_replace('/<svg\s+/', '<svg class="w-full h-full" ', $svgContent, 1);
    }
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center justify-center shrink-0 {$class}"]) }}>
    @if($svgContent)
        {!! $svgContent !!}
    @else
        <img src="{{ asset("icons/print/{$name}.svg") }}" class="w-full h-full object-contain" alt="">
    @endif
</span>
