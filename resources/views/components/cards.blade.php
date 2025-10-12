@props(['highlights'=> false, 'wide'=> false])


<div @class(['highlights' => $highlights, 'wide' => $wide, 'cards', 'flex items-center justify-between'])>
    {{$slot}}
</div> 