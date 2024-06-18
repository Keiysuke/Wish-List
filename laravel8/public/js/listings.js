/******/ (() => { // webpackBootstrap
/*!**********************************!*\
  !*** ./resources/js/listings.js ***!
  \**********************************/
(function () {
  toggle_filters = function toggle_filters() {
    document.getElementById('content-filters').classList.toggle('hidden');
  };

  Array.from(document.getElementsByClassName('delete-list')).forEach(function (e) {
    e.addEventListener('click', function (e) {
      var listId = e.target.dataset.list_id;
      getFetch('lists/' + listId + '/destroy').then(function (res) {
        document.getElementById("list-" + res.deletedId).remove();
        myNotyf(res);
        if (res.list_id > 0) document.onload = getProducts(res.listId); //There's still one other list
        else {
            //No more list for the user
            document.getElementById("my-lists").innerHTML = "<span>Vous n'avez pas encore créé de liste...</span>";
          }
      });
    });
  });

  leaveList = function leaveList(listId) {
    getFetch('lists/' + listId + '/leave').then(function (res) {
      if (res.success) location.reload();
    });
  };

  downloadList = function downloadList(listId) {
    getFetch('lists/' + listId + '/download').then(function (res) {
      var link = document.createElement('a');
      link.href = window.URL.createObjectURL(new Blob([res.blob]));
      link.setAttribute('download', res.filename + '.csv');
      document.body.appendChild(link);
      link.click();
    });
  };

  toggleShareList = function toggleShareList() {
    event.stopPropagation();
    document.getElementById('content-share-list').classList.toggle('hidden');
    document.getElementById('content-share-list').classList.toggle('flex');
    document.getElementById('main').classList.toggle('pointer-events-none');
  };

  showShareList = function showShareList(listId) {
    getFetch('shared/lists/' + listId + '/show').then(function (res) {
      if (res.success) {
        document.getElementById('content-share-list').innerHTML = res.html;
        document.getElementById('content-share-list').classList.toggle('hidden');
        document.getElementById('content-share-list').classList.toggle('flex');
        document.getElementById('main').classList.toggle('pointer-events-none');
      }
    });
  };

  shareList = function shareList(listId) {
    event.stopPropagation();
    var friends = Array();
    Array.from(document.querySelectorAll('[name^="share_friend_"]')).forEach(function (el) {
      if (el.checked) friends.push(parseInt(el.dataset.friendId));
    });

    if (friends.length === 0) {
      notyfJS('Veuillez sélectionner au moins l\'un de vos amis', 'error');
      return;
    }

    myFetch('lists/share', {
      method: 'post',
      csrf: true
    }, {
      list_id: parseInt(listId),
      friends: friends
    }).then(function (response) {
      if (response.ok) return response.json();
    }).then(function (res) {
      myNotyf(res);

      if (res.success) {
        document.getElementById('content-share-list').classList.toggle('flex');
        document.getElementById('content-share-list').classList.toggle('hidden');
        document.getElementById('main').classList.toggle('pointer-events-none');
      }
    });
  };
  /**
   * Met à jour les mesages affichés dans le tchat
   * @param {object} res - Résultat contenant le html de la liste des messages
   */


  showMessages = function showMessages() {
    var listId = document.getElementById('list-selected').value;
    getFetch('lists/' + listId + '/messages/get').then(function (res) {
      toggleShowMessages(res);
    });
  };
  /**
   * Affiche/Cache la liste des messages
   * @param {object} res - Résultat contenant le html de la liste des messages
   */


  toggleShowMessages = function toggleShowMessages(res) {
    var contentMsg = document.getElementById('content-msg');
    var wrapListProducts = document.getElementById('wrap-list-products');

    if (res.htmlMsg !== null && res.shared_list) {
      //Il y a des messages
      contentMsg.innerHTML = res.htmlMsg;
      contentMsg.classList.remove('hidden');
      wrapListProducts.classList.remove('extend');
      wrapListProducts.classList.add('with-msg');
      scrollDown(document.getElementById('v-list-msg'));
      maj_reactions();
    } else if (!contentMsg.classList.contains('hidden')) {
      wrapListProducts.classList.remove('with-msg');
      wrapListProducts.classList.add('extend');
      contentMsg.classList.add('hidden');
    }
  };
  /**
   * 
   * @param {int} listId - Identifiant de la liste
   * @param {int} productId - Identifiant du produit
   */


  toggleList = function toggleList(listId, productId) {
    myFetch('lists/products/toggle', {
      method: 'post',
      csrf: true
    }, {
      list_id: parseInt(listId),
      product_id: parseInt(productId),
      change_checked: true
    }).then(function (response) {
      if (response.ok) return response.json();
    }).then(function (res) {
      document.getElementById("list-" + listId + "-product-" + productId).remove();
      var nb_results = document.getElementById('nb-results').getAttribute('data-nb') - 1;

      if (nb_results > 0) {
        document.getElementById('nb-results').setAttribute('data-nb', nb_results);
        document.getElementById('nb-results').innerHTML = nb_results + ' Résultat(s)';
        document.getElementById('total-price').innerHTML = 'Montant total : ' + res.total_price + ' €';
      } else getProducts(listId);
    });
  };
  /**
   * Récupère les produits d'une liste
   * @param {int} listId - Identifiant de la liste
   */


  getProducts = function getProducts(listId) {
    var pageChanged = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    var oldListId = document.getElementById('list-selected').value;
    if (oldListId == listId && !pageChanged) return;
    myFetch('lists/' + listId + '/products/show', {
      method: 'post',
      csrf: true
    }, {
      user_id: parseInt(document.getElementById('user-id').value),
      page: document.getElementById('page').value
    }).then(function (response) {
      if (response.ok) return response.json();
    }).then(function (products) {
      if (document.getElementById('list-selected').value != '' && document.getElementById('list-' + document.getElementById('list-selected').value) != undefined) document.getElementById('list-' + document.getElementById('list-selected').value).classList.toggle('selected');
      document.getElementById('list-selected').value = listId;
      document.getElementById('list-' + listId).classList.toggle('selected');
      document.getElementById('content-results').innerHTML = products.html;
      document.getElementById('btn-go-up').click();
      extendListMsg(true);
      toggleShowMessages(products);
    });
  };
  /**
   * Affiche les listes d'un utilisateur
   * @param {int} userId - Identifiant de l'utilisateur dont on affiche les listes
   */


  showLists = function showLists(userId) {
    var oldUserId = document.getElementById('lists-user-id').value;
    if (oldUserId == userId) return;

    if (userId == 0) {
      document.getElementById('title-others-lists').classList.add('active');
      document.getElementById('title-my-lists').classList.remove('active');
    } else {
      document.getElementById('title-others-lists').classList.remove('active');
      document.getElementById('title-my-lists').classList.add('active');
    }

    document.getElementById('lists-user-id').value = userId;
    getFetch('lists/users/' + userId).then(function (lists) {
      document.getElementById('wrap-lists').innerHTML = lists.html;
      getProducts(lists.first_list_id);
    });
  }; // setInterval(showMessages, 5000)

})();
/******/ })()
;