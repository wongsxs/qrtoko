@props(['name', 'class' => 'w-4 h-4'])

@php
    $svgPath = public_path("icons/print/{$name}.svg");
    $svgContent = '';
    if (file_exists($svgPath)) {
        $svgContent = file_get_contents($svgPath);
        // Remove fixed width/height so it scales perfectly with Tailwind classes
        $svgContent = preg_replace('/(width|height)="\d+"/', '', $svgContent);
        // Inject w-full h-full into the svg tag
        $svgContent = preg_replace('/<svg\s+/', '<svg class="w-full h-full" ', $svgContent, 1);
    }
@endphp

@if($svgContent)
    <span {{ $attributes->merge(['class' => "inline-flex items-center justify-center shrink-0 {$class}"]) }}>
        {!! $svgContent !!}
    </span>
@endif
