<div class="wrap_h1">
    <h1>Conventions Laravel</h1>
    {{-- <x-svg.clipboard_list class="icon-lg"/> --}}
</div>

<x-admin.help.list_helpers>
    <span>Pas de ; en Javascript</span>
    <span>JS : notyf[success](param) => notyf.success(param)</span>
</x-admin.help.list_helpers>

<h3 class="mt-0">1. PHP & Blade</h3>
<x-Window.Coding class="w-10/12" title="Models/Emoji.php">
    <x-Window.Namespace>App\Models<br /></x-Window.Namespace>
    <x-Window.Use>App\Http\Controllers\ProductController;<br /></x-Window.Use>
    <x-Window.Use>Illuminate\Database\Eloquent\Model;<br /></x-Window.Use>
    <x-Window.Use>App\Models\EmojiSection;<br /></x-Window.Use>
    <br />
    <x-Window.Class name="Emoji" extends="Model"/>
    {<br />
        <div class="ml-4 b-0">
            <x-Window.Var protected var="fillable"> = ['propriete_snake_case']</x-Window.Var><br />
            <x-Window.Function public name="functionCamelCase"><x-Window.Var var="kind"/> = 'kbd_off'</x-Window.Function><br />
                <div class="ml-4">
                    <x-Window.Var var="monTag"/> = ['nomTag' => __('Texte à traduire')];<br />
                    <x-Window.Var var="view"/> = view('components.MonComposant')->with(['tag' => $monTag])->render();<br />
                    <br />
                    <x-Window.Var var="maVue"/> = view('ma_vue', compact('monTag'))->render();<br />
                    <x-Window.Return/>response()->json(['success' => true, 'html' => $view, 'vue' => $maVue]);<br />
                </div>
            }<br />
        </div>
    }<br />
</x-Window.Coding>

<h3>2. Le Javascript</h3>
<div class="grid grid-cols-5 gap-4">
    <span class="text-sm">mon-fichier-js.js</span>
    <span class="text-sm">maMethode()</span>
    <span class="text-sm">let/const maVariable</span>
    <span class="text-sm">Array.from()</span>
    <span class="text-sm">Array.forEach(el => { })</span>
</div>

<h3>3. Le HTML & CSS</h3>
<div class="grid grid-cols-5 gap-4">
    <span class="text-sm">my-style.css</span>
    <span class="text-sm">field_name</span>
    <span class="text-sm">#id-de-mon-field</span>
    <span class="text-sm">.ma-classe</span>
    <span class="text-sm">data-ma-propriete-perso</span>
    <span class="text-sm">event.target.dataset.ma_propriete_perso</span>
</div>
