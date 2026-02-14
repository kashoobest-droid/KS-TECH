@php
    $offerEnds = $offer->ends_at ? \Carbon\Carbon::parse($offer->ends_at)->format('c') : null;
    $offerStarts = $offer->starts_at ? \Carbon\Carbon::parse($offer->starts_at)->format('M j, Y') : null;
    $uniqueId = 'offer_countdown_' . $offer->id;
@endphp
<div class="offer-card-modern" data-offer-id="{{ $offer->id }}">
    <div class="offer-card-modern__inner">
        <div class="offer-card-modern__media">
            <img
                src="{{ $offer->image_path ? (filter_var($offer->image_path, FILTER_VALIDATE_URL) ? $offer->image_path : asset($offer->image_path)) : 'https://via.placeholder.com/120x120?text=Gift' }}"
                alt="{{ $offer->gift_name }}"
                class="offer-card-modern__img"
                loading="lazy"
                width="72"
                height="72"
            />
            <span class="offer-card-modern__badge">Free gift</span>
        </div>
        <div class="offer-card-modern__body">
            <span class="offer-card-modern__label">{{ $offer->offer_name ?? 'Special Offer' }}</span>
            <h6 class="offer-card-modern__title">{{ \Illuminate\Support\Str::limit($offer->gift_name, 50) }}</h6>
            @if($offer->description)
                <p class="offer-card-modern__desc">{{ \Illuminate\Support\Str::limit($offer->description, 100) }}</p>
            @endif
            @if($offerEnds)
                <div class="offer-card-modern__countdown">
                    <span class="offer-card-modern__countdown-label">Ends in</span>
                    <span id="{{ $uniqueId }}" class="offer-card-modern__countdown-value" data-ends-at="{{ $offerEnds }}">--:--:--</span>
                </div>
            @elseif($offerStarts)
                <div class="offer-card-modern__meta">Started {{ $offerStarts }}</div>
            @endif
        </div>
    </div>
</div>
