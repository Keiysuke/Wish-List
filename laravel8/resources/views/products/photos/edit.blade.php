@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_product_photos', $product) }}
@endsection

@section('js')
<script>
    function updateNbPhotos(add = true, v = -1){ //Change nb_photos in the "select"
        var nb_photos = document.getElementById('nb-photos');
        if(v >= 0 && v <= 9){
            nb_photos.selectedIndex = v;
            uploadPhotos(nb_photos.value);
        }else{
            if(add) nb_photos.selectedIndex = ((nb_photos.value >= 10)? 9 : nb_photos.value++);
            else nb_photos.selectedIndex = ((nb_photos.value <= 1)? 0 : (nb_photos.value - 2));
            uploadPhotos(nb_photos.value);
        }
    }
    
    function uploadPhotos(nb){
        for(var i = 1; i <= 10; i++){
            if(i <= nb){
                document.getElementById('content-photo-'+i).classList.add('block');
                document.getElementById('content-photo-'+i).classList.remove('hidden');
            }else{
                document.getElementById('content-photo-'+i).classList.add('hidden');
                document.getElementById('content-photo-'+i).classList.remove('block');
            }
        }
    }

    var loadFile = function(event, i) {
        URL.revokeObjectURL(event.target.files[0]);
        document.getElementById('img-'+i).src = URL.createObjectURL(event.target.files[0]);
    };
</script>
@endsection

@section('content')
<x-Notification type="success" msg="{{ session('info') }}"/>

@php($dir = config('images.path_products').'/'.$product->id.'/')
@php($nb_photos = old('nb_photos', ((count($photos) > 0))? count($photos) : 1))
<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('productPhotos.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="relative flex border-b-2 mb-4">
            <h1>Edition des photos d'un produit
                <x-products.search_photo id="icon-find-photo" search="{{ $product->label }}" class="title-icon absolute right-0 flex inline-flex gap-2"/>
            </h1>
            <hr/>
        </div>

        <div class="flex justify-center">
            <div class="w-1/3">
                <x-Form.Label for="nb-photos" block>Nombre de photos à lier</x-Form.Label>
                <div class="flex gap-2">
                    <x-svg.minus_circle class="icon-lg icon-clickable" onClick="updateNbPhotos(false);"/>
                    <select name="nb_photos" id="nb-photos" value="{{ $nb_photos }}" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent" onChange="uploadPhotos(this.value)">
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" @if($nb_photos == $i) selected @endif>{{ $i }}</option>
                        @endfor
                    </select>
                    <x-svg.plus_circle class="icon-lg icon-clickable" onClick="updateNbPhotos();"/>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-5 my-4">
            @for ($i = 1; $i <= 10; $i++)
                <div id="content-photo-{{ $i }}" class="flex justify-center mb-4 {{ ($i <= $nb_photos)? '' : 'hidden' }}">
                    <input type="file" accept="image/*" id="photo-{{ $i }}" name="photo_{{ $i }}" class="hidden" onchange="loadFile(event, {{ $i }})">
                    <div class="flex flex-col items-center gap-4">
                        <div class="inline-flex">
                            <x-svg.big.picture class="icon"/>
                            <label class="custom-file-label cursor-pointer" for="photo-{{ $i }}" data-browse="Parcourir">{{ (count($photos) >= $i)? 'Changer l\'image' : 'Choisissez une image' }}</label>
                        </div>
                        <label for="photo-{{ $i }}" class="cursor-pointer"><img id="img-{{ $i }}" class="border max-w-40 max-h-52" src="{{ (count($photos) >= $i)? asset($dir.$photos->firstWhere('ordered', $i)->label) : 'https://place-hold.it/160x120' }}"/></label>
                        @if(count($photos) >= $i && $i > 1)
                            <div class="inline-flex items-center gap-1">
                                <input type="checkbox" name="del_photo_{{ $i }}" id="del-photo-{{ $i }}" {{ old('del_photo_'.$i) === 'on' ? 'checked' : '' }}/>
                                <label for="del-photo-{{ $i }}">
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
            <x-Form.Btn type="submit">Modifier les photos</x-Form.Btn>
            <x-Form.Cancel href="{{ route('products.show', $product->id) }}"/>
        </div>
    </form>
    </div>
@endsection