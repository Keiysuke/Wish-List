/******/ (() => { // webpackBootstrap
/*!**********************************!*\
  !*** ./resources/js/products.js ***!
  \**********************************/
(function () {
  changePictures = function changePictures() {
    if (++cur_pict > document.getElementById('nb-max-pict').value) {
      cur_pict = 1;
    }

    document.getElementById('big-img').setAttribute('src', document.getElementById('product-pict_' + cur_pict).getAttribute('src'));
  };

  onPicture = function onPicture(on) {
    if (on) {
      document.getElementById('big-img-zoom').classList.remove('hidden');
      document.getElementById('big-img').classList.add('opacity-30');
    } else {
      document.getElementById('big-img-zoom').classList.add('hidden');
      document.getElementById('big-img').classList.remove('opacity-30');
    }
  };

  showPict = function showPict(i) {
    event.stopPropagation();
    document.getElementById('img-zoom-main').setAttribute('src', document.getElementById('img-zoom-sec' + i).getAttribute('src'));
  };

  toggleZoomPictures = function toggleZoomPictures() {
    var i = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;

    if (document.getElementById('img-zoom-sec' + i) == null) {
      return;
    }

    event.stopPropagation();
    document.getElementById('img-zoom-main').setAttribute('src', document.getElementById('img-zoom-sec' + i).getAttribute('src'));
    document.getElementById('content-img-zoomed').classList.toggle('hidden');
    document.getElementById('main').classList.toggle('pointer-events-none');
  };

  toggle_thumbnail = function toggle_thumbnail(id) {
    document.getElementById('thumbnail-' + id).classList.toggle('mode-recto');
    document.getElementById('thumbnail-' + id).classList.toggle('mode-verso');
  };

  showExpired = function showExpired(e) {
    var inp = document.getElementById('show-expired');

    if (inp.value === 'hide') {
      document.getElementById('show-expired').value = 'show';
      e.title = 'Cacher les liens expirés';
    } else {
      document.getElementById('show-expired').value = 'hide';
      e.title = 'Afficher les liens expirés';
    }

    Array.from(document.getElementsByClassName('li-website expired')).forEach(function (el) {
      el.classList.toggle('hidden');
    });
    document.getElementById('icon-show-expired').classList.toggle('hidden');
    document.getElementById('icon-hide-expired').classList.toggle('hidden');
  };

  document.getElementById('follow-product').addEventListener('click', function (e) {
    var id = document.getElementById('product-id').value;
    getFetch('products/' + id + '/follow').then(function (res) {
      document.getElementById('follow-product').setAttribute('title', res.product.follow ? 'Ne plus suivre' : 'Suivre');
      document.getElementById('follow-product').classList.toggle('on');
      riseIcon(e, 'follow', res.product.follow);
    });
  });
  document.getElementById('archive-product').addEventListener('click', function () {
    var id = document.getElementById('product-id').value;
    getFetch('products/' + id + '/archive').then(function (res) {
      if (res != undefined && res.success) {
        notyfJS(res.product.archived ? 'Produit désarchivé' : 'Produit archivé', 'success');
        document.getElementById('archive-product').setAttribute('title', res.product.archived ? 'Retirer des archives' : 'Archiver');
        document.getElementById('archive-product').classList.toggle('on');
      } else {
        notyfJS('Une erreur est survenue', 'error');
      }
    });
  });

  showHisto = function showHisto(e) {
    document.querySelector('[id="histo-offers-' + e.getAttribute("data-id") + '"]').classList.toggle("icon-on");
    document.querySelector('[id="content-histo-offers-' + e.getAttribute("data-id") + '"]').classList.toggle("hidden");
  }; //Lists Functions


  toggleShowLists = function toggleShowLists() {
    event.stopPropagation();
    document.getElementById('add-to-list').classList.toggle('hidden');
    document.getElementById('main').classList.toggle('pointer-events-none');
  };

  toggleList = function toggleList(listId, productId) {
    var changeChecked = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;
    myFetch('lists/products/toggle', {
      method: 'post',
      csrf: true
    }, {
      list_id: parseInt(listId),
      product_id: parseInt(productId),
      nb: document.getElementById('list-nb-' + listId).value,
      change_checked: changeChecked
    });
  };

  simulateBenef = function simulateBenef(payed, sold) {
    if (!document.getElementById('left-sidebar-help').classList.contains('open')) {
      document.getElementById('icon-help').dispatchEvent(new CustomEvent('click'));
    }

    document.getElementById('ls-benefit-payed').value = payed;
    document.getElementById('ls-benefit-sold').value = sold === undefined ? 0 : sold;
  };
})();
/******/ })()
;