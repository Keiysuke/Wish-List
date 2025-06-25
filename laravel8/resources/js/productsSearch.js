(function () {
    toggle_filters = function () {
        document.getElementById('icon-filter').classList.toggle('on');
        if(window.scrollY >= '40'){
            window.scrollTo(0, 0);
            if(document.getElementById('content-filters').classList.contains('hidden')) document.getElementById('content-filters').classList.remove('hidden');
        }else
            document.getElementById('content-filters').classList.toggle('hidden');
    }

    sort = function (order_by) {
        document.getElementById('icon-asc-sort').classList.toggle('hidden');
        document.getElementById('icon-desc-sort').classList.toggle('hidden');
        document.getElementById('order-by').value = order_by;
        document.getElementById('title-order-by').title = (order_by === 'asc')? 'Ordre croissant' : 'Ordre décroissant';
        searchProducts();
    }

    toggle_archived = function () {
        show = document.getElementById('show-archived');
        document.getElementById('show-archived').value = (show.value == 0)? 1 : 0;
        document.getElementById('title-show-archived').title = (show.value == 0)? "{{ __('Show archived') }}" : "{{ __('Hide archived') }}";
        document.getElementById('icon-show-archived').classList.toggle('active');
        searchProducts();
    }

    display_result = function (kind) {
        document.getElementById('result-icon-list').classList.toggle('hidden');
        document.getElementById('result-icon-grid').classList.toggle('hidden');
        document.getElementById('list').value = (kind === 'list')? 'list' : 'grid';
        document.getElementById('icon-list').title = (kind === 'list')? 'Liste' : 'Grille';
        searchProducts();
    }

    change_page = function (nb) {
        document.getElementById('page').value = nb;
        searchProducts();
    }

    searchProducts = function () {
        let websites = Array();
        let tags = Array();
        Array.from(document.getElementsByClassName('filter-website')).forEach(el => {
            if(el.checked) websites.push(el.name);
        });
        Array.from(document.getElementsByClassName('filter-tag')).forEach(el => {
            if(el.checked) tags.push(el.name);
        });
        
        myFetch('../products/filter', {method: 'post', csrf: true}, {
            search_text: document.getElementById('search-text').value,
            sort_by: document.getElementById('sort-by').value,
            order_by: document.getElementById('order-by').value,
            list: document.getElementById('list').value,
            show_archived: document.getElementById('show-archived').value,
            page: document.getElementById('page').value,
            url: document.getElementById('url').value,
            websites: websites,
            no_tag: document.getElementById('no-tag').checked,
            exclusive_tags: document.getElementById('exclusive-tags').checked,
            tags: tags,
            purchased: document.querySelector('input[name="purchased"]:checked').value,
            stock: document.querySelector('input[name="stock"]:checked').value,
            f_nb_results: document.querySelector('input[name="f_nb_results"]:checked').value,
            crowdfunding: document.getElementById('check-crowdfunding').checked ? 1 : 0,
        }).then(response => {
            if (response.ok) {
                document.getElementById('search-text').classList.remove('border');
                return response.json();
            } else {
                if(response.status == 422) {
                    document.getElementById('search-text').classList.add('border');
                    document.getElementById('search-text').classList.add('border-red-500');
                }
                return null;
            }
        }).then(products => {
            document.getElementById('content-results').innerHTML = products.html;
            if(products === null) return;
            document.getElementById('nb-results').innerHTML = products.nb_results+' Résultat(s)';
        });
    }

    document.forms['search-products'].onsubmit = (e) => {
        e.preventDefault();
        document.getElementById('page').value = 1;
        searchProducts();
    }

    window.addEventListener('scroll', () => {
        if(window.scrollY >= '40') document.getElementById('result-bar').setAttribute('class', 'sticky-search-bar on');
        else document.getElementById('result-bar').setAttribute('class', 'sticky-search-bar off');
    });

    document.getElementById('check-all-websites').addEventListener('change', (event) => {
        Array.from(document.getElementsByClassName('filter-website')).forEach(el => {
            el.checked = event.target.checked;
        });
    });

    document.getElementById('check-crowdfunding').addEventListener('change', (event) => {
        Array.from(document.getElementsByClassName('filter-website')).forEach(el => {
            if (event.target.checked) {
                el.checked = el.dataset.cfg == 1;
            } else {
                el.checked = el.dataset.cfg == 0;
            }
        });
    });

    document.getElementById('check-all-tags').addEventListener('change', (event) => {
        Array.from(document.getElementsByClassName('filter-tag')).forEach(el => {
            el.checked = !event.target.checked;
        });
    });
    
    searchProducts();
})()
