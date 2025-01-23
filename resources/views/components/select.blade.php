@props(['name', 'id'])

<select id="{{ $id }}" name="{{ $name }}"
    class="mt-1 block w-3/12 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
    {{ $slot }}
</select>
