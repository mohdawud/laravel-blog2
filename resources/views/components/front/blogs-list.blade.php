@props(['title', 'date', 'user', 'description', 'link'])
<!-- Post preview-->
<div class="post-preview">
    <a href="{{ $link }}">
        <h2 class="post-title">{{ $title }}</h2>
        <h3 class="post-subtitle">
            @if (isset($description))
                {{ $description }}
            @endif
        </h3>
    </a>
    <p class="post-meta">
        Posted by
        <a href="#!">{{ $user }}</a>
        on {{ $date }}
    </p>
</div>
<!-- Divider-->
<hr class="my-4" />
