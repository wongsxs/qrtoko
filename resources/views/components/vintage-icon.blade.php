@props(['name', 'pack' => 'print', 'class' => 'w-4 h-4'])

@php
    $folder = ($pack === 'brand' || $pack === 'brands') ? 'brands' : 'print';
    $resPath = resource_path("icons/{$folder}/{$name}.svg");
    $pubPath = public_path("icons/{$folder}/{$name}.svg");
    $svgContent = '';

    if (file_exists($resPath)) {
        $svgContent = file_get_contents($resPath);
    } elseif (file_exists($pubPath)) {
        $svgContent = file_get_contents($pubPath);
    }

    if ($svgContent) {
        $svgContent = preg_replace('/(width|height)="\d+"/', '', $svgContent);
        $svgContent = preg_replace('/<svg\s+/', '<svg class="w-full h-full" ', $svgContent, 1);
        if ($folder === 'brands' && !str_contains($svgContent, 'fill=')) {
            $svgContent = preg_replace('/<path\s+/', '<path fill="currentColor" ', $svgContent, 1);
        }
    }
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center justify-center shrink-0 {$class}"]) }}>
    @if($svgContent)
        {!! $svgContent !!}
    @else
        <img src="{{ asset("icons/{$folder}/{$name}.svg") }}" class="w-full h-full object-contain" alt="">
    @endif
</span>
