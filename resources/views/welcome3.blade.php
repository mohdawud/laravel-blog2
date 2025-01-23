@php
    $judul = "Ini Judul"
@endphp
<x-halaman-layout :judul="$judul">
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos dolor minus libero rerum dolorem laudantium, obcaecati doloremque voluptate alias saepe!

<x-slot name="tanggal">21 September 2024</x-slot>
<x-slot name="penulis">Deviiid</x-slot>

</x-halaman-layout>


