@props(['amount'])
<span class="price">
    <img src="/images/Saudi_Riyal_Symbol.svg" alt="SAR" style="height: 1em; margin-right: 2px; vertical-align: middle;">
    @if(!empty($amount) && is_numeric($amount))
        {{ number_format((float)$amount, 2) }}
    @endif
</span>