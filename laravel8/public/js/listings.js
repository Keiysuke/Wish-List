/******/ (() => { // webpackBootstrap
/*!**********************************!*\
  !*** ./resources/js/listings.js ***!
  \**********************************/
(function () {
  toggle_filters = function toggle_filters() {
    document.getElementById('content_filters').classList.toggle('hidden');
  };

  Array.from(document.getElementsByClassName('delete_list')).forEach(function (e) {
    e.addEventListener('click', function (e) {
      var id = e.target.dataset.list_id;
      get_fetch('lists/' + id + '/destroy').then(function (res) {
        document.getElementById("list_" + res.deleted_id).remove();
        my_notyf(res);
        if (res.list_id > 0) document.onload = get_products(res.list_id); //There's still one other list
        else {
            //No more list for the user
            document.getElementById("my_lists").innerHTML = "<span>Vous n'avez pas encore créé de liste...</span>";
          }
      });
    });
  });

  leave_list = function leave_list(list_id) {
    get_fetch('lists/' + list_id + '/leave').then(function (res) {
      if (res.success) location.reload();
    });
  };

  download_list = function download_list(list_id) {
    get_fetch('lists/' + list_id + '/download').then(function (res) {
      var link = document.createElement('a');
      link.href = window.URL.createObjectURL(new Blob([res.blob]));
      link.setAttribute('download', res.filename + '.csv');
      document.body.appendChild(link);
      link.click();
    });
  };

  toggleShareList = function toggleShareList(list_id) {
    event.stopPropagation();
    document.getElementById('content_share_lists').classList.toggle('hidden');
    document.getElementById('content_share_lists').classList.toggle('flex');
    document.getElementById('main').classList.toggle('pointer-events-none');
  };

  showShareList = function showShareList(list_id) {
    get_fetch('shared/lists/' + list_id + '/show').then(function (res) {
      if (res.success) {
        document.getElementById('content_share_lists').innerHTML = res.html;
        document.getElementById('content_share_lists').classList.toggle('hidden');
        document.getElementById('content_share_lists').classList.toggle('flex');
        document.getElementById('main').classList.toggle('pointer-events-none');
      }
    });
  };

  shareList = function shareList(list_id) {
    event.stopPropagation();
    var friends = Array();
    Array.from(document.querySelectorAll('[name^="share_friend_"]')).forEach(function (el) {
      if (el.checked) friends.push(parseInt(el.dataset.friendId));
    });

    if (friends.length === 0) {
      notyfJS('Veuillez sélectionner au moins l\'un de vos amis', 'error');
      return;
    }

    my_fetch('lists/share', {
      method: 'post',
      csrf: true
    }, {
      list_id: parseInt(list_id),
      friends: friends
    }).then(function (response) {
      if (response.ok) return response.json();
    }).then(function (res) {
      my_notyf(res);

      if (res.success) {
        document.getElementById('content_share_lists').classList.toggle('flex');
        document.getElementById('content_share_lists').classList.toggle('hidden');
        document.getElementById('main').classList.toggle('pointer-events-none');
      }
    });
  };

  show_messages = function show_messages(res) {
    var messages_content = document.getElementById('messages_content');
    var wrap_list_products = document.getElementById('wrap_list_products');

    if (res.messages_html !== null && res.shared_list) {
      //Il y a des messages
      messages_content.innerHTML = res.messages_html;
      messages_content.classList.remove('hidden');
      wrap_list_products.classList.remove('extend');
      wrap_list_products.classList.add('with_msg');
      scrollDown(document.getElementById('v_list_msg'));
      maj_reactions();
    } else if (!messages_content.classList.contains('hidden')) {
      wrap_list_products.classList.remove('with_msg');
      wrap_list_products.classList.add('extend');
      messages_content.classList.add('hidden');
    }
  };

  toggle_list = function toggle_list(list_id, product_id) {
    my_fetch('lists/toggle_product', {
      method: 'post',
      csrf: true
    }, {
      list_id: parseInt(list_id),
      product_id: parseInt(product_id),
      change_checked: true
    }).then(function (response) {
      if (response.ok) return response.json();
    }).then(function (res) {
      document.getElementById("list_" + list_id + "_product_" + product_id).remove();
      var nb_results = document.getElementById('nb_results').getAttribute('data-nb') - 1;

      if (nb_results > 0) {
        document.getElementById('nb_results').setAttribute('data-nb', nb_results);
        document.getElementById('nb_results').innerHTML = nb_results + ' Résultat(s)';
        document.getElementById('total_price').innerHTML = 'Montant total : ' + res.total_price + ' €';
      } else get_products(list_id);
    });
  };

  get_products = function get_products(list_id) {
    var old_list_id = document.getElementById('list_selected').value;
    if (old_list_id == list_id) return;
    get_fetch('lists/' + list_id + '/products/show').then(function (products) {
      if (document.getElementById('list_selected').value != '' && document.getElementById('list_' + document.getElementById('list_selected').value) != undefined) document.getElementById('list_' + document.getElementById('list_selected').value).classList.toggle('selected');
      document.getElementById('list_selected').value = list_id;
      document.getElementById('list_' + list_id).classList.toggle('selected');
      document.getElementById('content_results').innerHTML = products.html;
      extendListMsg(true);
      show_messages(products);
    });
  };

  show_lists = function show_lists(user_id) {
    var old_user_id = document.getElementById('lists_user_id').value;
    if (old_user_id == user_id) return;

    if (user_id == 0) {
      document.getElementById('title_others_lists').classList.add('active');
      document.getElementById('title_my_lists').classList.remove('active');
    } else {
      document.getElementById('title_others_lists').classList.remove('active');
      document.getElementById('title_my_lists').classList.add('active');
    }

    document.getElementById('lists_user_id').value = user_id;
    get_fetch('lists/users/' + user_id).then(function (lists) {
      document.getElementById('wrap_lists').innerHTML = lists.html;
      get_products(lists.first_list_id);
    });
  };
})();
/******/ })()
;