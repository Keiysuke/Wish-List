@if(!isset($unique_colors))
    <span class="text-red-500 font-bold">Erreur: Couleurs introuvables</span>
@else
    @section('js')
    @parent
    <script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
    <script>
        document.getElementById('{{ $kind_css_color }}_color').addEventListener('change', change_{{ $kind_css_color }}_color);
        document.getElementById('{{ $kind_css_color }}_variant').addEventListener('change', change_{{ $kind_css_color }}_color);
        
        function change_{{ $kind_css_color }}_color() {
            let border_color = document.getElementById('border_color').value
            let border_cur_variant = document.getElementById('border_variant').value
            let text_color = document.getElementById('text_color').value
            let text_cur_variant = document.getElementById('text_variant').value
            let bg_color = document.getElementById('bg_color').value
            let bg_cur_variant = document.getElementById('bg_variant').value
            my_fetch('{{ route('get_color_variants') }}', {method: 'post', csrf: true}, {
                border_color: border_color,
                border_cur_variant: border_cur_variant,
                text_color: text_color,
                text_cur_variant: text_cur_variant,
                bg_color: bg_color,
                bg_cur_variant: bg_cur_variant,
                kind: '{{ $kind_css_color }}',
            }).then(response => {
                if (response.ok) return response.json();
            }).then(res => {
                document.getElementById('{{ $kind_css_color }}_variant').innerHTML = res.html;
                document.getElementById('content_ex_tag').innerHTML = res.tag;
            });
        }
        change_{{ $kind_css_color }}_color();
    </script>
    @endsection

    @php($titles = ['border' => 'Bordure', 'text' => 'Texte', 'bg' => 'Background'])
    <div class="flex-cols gap-4">
        <div class="flex-cols text-center w-full">
            <h3 class="font-bold @if($kind_css_color === 'border') border-4 border-black @elseif($kind_css_color === 'bg') bg-black text-white @endif ">{{ $titles[$kind_css_color] }}</h3>
            <hr />
        </div>
        <div class="flex w-full gap-4">
            <div class="w-1/2">
                <x-form.label for="{{ $kind_css_color }}_color" block required>Couleur</x-form.label>
                <select name="{{ $kind_css_color }}_color" id="{{ $kind_css_color }}_color" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @php($found = [])
                    @foreach($unique_colors as $color)
                        <option value="{{ $color }}" @if($color === old($kind_css_color.'_color', (isset($tag)? $tag->css_color_details($kind_css_color)->color : -1))) selected @endif>{{ ucFirst($color) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-1/2">
                <x-form.label for="{{ $kind_css_color }}_variant" block required>Variance</x-form.label>
                <select name="{{ $kind_css_color }}_variant" id="{{ $kind_css_color }}_variant" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    <option value="{{ (isset($tag)? $tag->css_color_details($kind_css_color)->variant : -1) }}"></option>
                </select>
            </div>
        </div>
    </div>
@endif