@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_product_photos', $product) }}
@endsection

@section('js')
<script>
    function upload_photos(nb){
        for(var i = 1; i <= 10; i++){
            if(i <= nb){
                document.getElementById('content_photo_'+i).classList.add('block');
                document.getElementById('content_photo_'+i).classList.remove('hidden');
            }else{
                document.getElementById('content_photo_'+i).classList.add('hidden');
                document.getElementById('content_photo_'+i).classList.remove('block');
            }
        }
    }

    var loadFile = function(event, i) {
        URL.revokeObjectURL(event.target.files[0]);
        document.getElementById('img_'+i).src = URL.createObjectURL(event.target.files[0]);
    };
</script>
@endsection

@section('content')
<x-notification type="success" msg="{{ session('info') }}"/>

@php($dir = config('images.path_products').'/'.$product->id.'/')
@php($nb_photos = old('nb_photos', ((count($photos) > 0))? count($photos) : 1))
<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('product_photos.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <h1>Edition des photos d'un produit</h1>
        <hr/>

        <div class="flex justify-center">
            <div class="w-1/3">
                <x-form.label for="nb_photos" block>Nombre de photos à lier</x-form.label>
                <select name="nb_photos" id="nb_photos" value="{{ $nb_photos }}" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent" onChange="upload_photos(this.value)">
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" @if($nb_photos == $i) selected @endif>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="grid grid-cols-5 my-4">
            @for ($i = 1; $i <= 10; $i++)
                <div id="content_photo_{{ $i }}" class="flex justify-center mb-4 {{ ($i <= $nb_photos)? '' : 'hidden' }}">
                    <input type="file" accept="image/*" id="photo_{{ $i }}" name="photo_{{ $i }}" class="hidden" onchange="loadFile(event, {{ $i }})">
                    <div class="flex flex-col items-center gap-4">
                        <div class="inline-flex">
                            <x-svg.big.picture class="icon"/>
                            <label class="custom-file-label cursor-pointer" for="photo_{{ $i }}" data-browse="Parcourir">{{ (count($photos) >= $i)? 'Changer l\'image' : 'Choisissez une image' }}</label>
                        </div>
                        <label for="photo_{{ $i }}" class="cursor-pointer"><img id="img_{{ $i }}" class="border w-40" src="{{ (count($photos) >= $i)? asset($dir.$photos->firstWhere('ordered', $i)->label) : 'https://place-hold.it/160x120' }}"/></label>
                        @if(count($photos) >= $i && $i > 1)
                            <div class="inline-flex items-center gap-1">
                                <input type="checkbox" name="del_photo_{{ $i }}" id="del_photo_{{ $i }}" {{ old('del_photo_'.$i) === 'on' ? 'checked' : '' }}/>
                                <label for="del_photo_{{ $i }}" onClick="del_photo({{ $i }});">
                                    <x-svg.trash class="icon-sm"/>
                                </label>
                            </div>
                        @endif
                        @error('photo_'.$i)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endfor
        </div>
        <div class="flex items-center justify-between">
            <x-form.btn type="submit">Modifier les photos</x-form.btn>
            <x-form.cancel href="{{ route('products.show', $product->id) }}"/>
        </div>
    </form>
    </div>
@endsection