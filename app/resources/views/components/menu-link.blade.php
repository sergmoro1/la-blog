@props(['href', 'active'])

<li {{ $attributes->class(['active' => $active]) }}>
    <a href={{ $href }}>
        {{ $slot }}
    </a>
</li>
