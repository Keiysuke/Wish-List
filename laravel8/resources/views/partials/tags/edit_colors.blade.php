@if(!isset($unique_colors))
    <span class="text-red-500 font-bold">Erreur: Couleurs introuvables</span>
@else
    @section('js')
    <script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
    <script>
        document.querySelector('#border_color').addEventListener('change', change_color);
        document.querySelector('#border_variant').addEventListener('change', change_color);
        
        function change_color() {
            let color = document.querySelector('#border_color').value
            let cur_variant = document.querySelector('#border_variant').value
            my_fetch('{{ route('get_color_variants') }}', {method: 'post', csrf: true}, {
                color: color,
                cur_variant: cur_variant
            }).then(response => {
                if (response.ok) return response.json();
            }).then(res => {
                document.querySelector('#border_variant').innerHTML = res.html;
                document.querySelector('#content_ex_tag').innerHTML = res.tag;
            });
        }
        change_color();
    </script>
    @endsection

    <div class="flex justify-around gap-4">
        <div class="w-1/2">
            <x-form.label for="border_color" block required>Couleur</x-form.label>
            <select name="border_color" id="border_color" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                @php($found = [])
                @foreach($unique_colors as $color)
                    <option value="{{ $color }}" @if($color === old('border_color', (isset($tag)? $tag->border_details()->color : -1))) selected @endif>{{ ucFirst($color) }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-1/2">
            <x-form.label for="border_variant" block required>Variance</x-form.label>
            <select name="border_variant" id="border_variant" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                <option value="{{ (isset($tag)? $tag->border_details()->variant : -1) }}"></option>
            </select>
        </div>
    </div>
@endif