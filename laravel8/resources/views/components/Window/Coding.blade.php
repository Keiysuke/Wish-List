<div class="flex justify-center">
    <div class="{{ $class }}">
        <div class="relative flex flex-col w-full p-2 l-8 text-purple-600 font-bold border-2 border-gray-800 rounded-t-md">
            <div class="flex inline-flex">
                {{ $title }}
                <x-svg.cmd class="absolute right-2 text-black icon-{{ isset($major) ? 'xxl' : 'lg' }}"/>
            </div>
            <div class="text-black text-xs font-normal">{{ $major ?? '' }}</div>
        </div>
        <div class="rounded-b-md py-2 px-4 bg-gray-800 text-white">
            {{ $slot }}
        </div>
    </div>
</div>