<div class="sidebar_content" id="left_sidebar_externals">
    <p><x-svg.globe class="icon-sm text-blue-400"/> Liens externes</p>
    <div class="ls_grid-2">
        <div class="rectangle">
            <a href="https://tinypng.com/" title="Tiny PNG" target="_blank"><img src="{{ asset(config('images.icons_externals')).'/tinypng.png' }}"/></a>
        </div>
        <div class="rectangle">
            <a href="https://tinyjpg.com/" title="Tiny JPG" target="_blank"><img src="{{ asset(config('images.icons_externals')).'/tinyjpg.png' }}"/></a>
        </div>
        <div class="rectangle">
            <a href="https://www.chronometre-en-ligne.com/compte-a-rebours.html" title="Chrono" target="_blank"><img src="{{ asset(config('images.icons_externals')).'/chrono.png' }}"/></a>
        </div>
        <div class="rectangle">
            <a href="https://ideas.lego.com/" title="Lego Ideas" target="_blank"><img src="{{ asset(config('images.icons_externals')).'/lego_ideas.png' }}"/></a>
        </div>
        <div class="rectangle bg-white">
            <a href="https://www.google.com/search?q=la%20poste%20colombes&rlz=1C1CHBF_frFR906FR906&oq=la+po&aqs=chrome.0.69i59j69i57j46i199i291i433i512j0i433i512j0i131i433i512j69i60l3.1888j0j1&sourceid=chrome&ie=UTF-8&tbs=lf:1,lf_ui:4&tbm=lcl&sxsrf=ALiCzsb6dKiXBv6Bue0i-5GjZcv50ny1uQ:1652725385178&rflfq=1&num=10&rldimm=3273829765213076558&lqi=ChFsYSBwb3N0ZSBjb2xvbWJlcyIDiAEBSKK00c2cqoCACFolEAAQARgAGAEYAiIRbGEgcG9zdGUgY29sb21iZXMqBggCEAAQAZIBC3Bvc3Rfb2ZmaWNlqgEQEAEqDCIIbGEgcG9zdGUoBA&ved=2ahUKEwiiq_rr0eT3AhUQ3RoKHUTFDS0QvS56BAgEEAE&sa=X&rlst=f#rlfi=hd:;si:3273829765213076558,l,ChFsYSBwb3N0ZSBjb2xvbWJlcyIDiAEBSKK00c2cqoCACFolEAAQARgAGAEYAiIRbGEgcG9zdGUgY29sb21iZXMqBggCEAAQAZIBC3Bvc3Rfb2ZmaWNlqgEQEAEqDCIIbGEgcG9zdGUoBA;mv:[[48.93069020000001,2.2746551],[48.902700599999996,2.2251434]];tbs:lrf:!1m4!1u3!2m2!3m1!1e1!2m1!1e3!3sIAE,lf:1,lf_ui:4" title="La Poste - horaires" target="_blank"><img src="{{ asset(config('images.icons_externals')).'/la_poste.png' }}"/></a>
        </div>
    </div>
    <div class="flex flex-col items-center mt-4 gap-4">
        <div class="flex gap-2">
            <x-svg.big.box class="icon-lg"/><a class="link" href="https://www.amazon.fr/gp/your-account/order-history?ref_=ya_d_c_yo" target="_blank">Commandes Amazon</a>
        </div>
        <div class="flex gap-2">
            <x-form.input name="sb_yt_text" type="text" placeholder="Recherche sur Youtube"/>
            <x-form.btn type="submit" color="red"><x-svg.search class="icon-sm"/></x-form.btn>
        </div>
        <div class="flex gap-2">
            <x-form.input name="sb_psthc_text" type="text" placeholder="Recherche sur PSTHC"/>
            <x-form.btn type="submit" color="yellow"><x-svg.big.trophy class="icon-sm text-black"/></x-form.btn>
        </div>
        <div class="flex gap-2">
            <x-form.input name="sb_offer_text" type="text" placeholder="Dénicher des offres"/>
            <x-form.btn type="submit"><x-svg.big.euro class="icon-sm text-white"/></x-form.btn>
        </div>
    </div>
</div>