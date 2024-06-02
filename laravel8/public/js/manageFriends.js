/******/ (() => { // webpackBootstrap
/*!***************************************!*\
  !*** ./resources/js/manageFriends.js ***!
  \***************************************/
(function () {
  /**
   * Gère le changement d'onglets sur la sidebar des utilisateurs
   * @param {event} event - évènement cliqué
  */
  setFriendsTab = function setFriendsTab() {
    var event = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
    var tab = event ? event.target.dataset.kind : 'friends';

    switch (tab) {
      case 'friends':
        searchUser();
        break;

      case 'users':
        searchUser(false);
        break;

      case 'my_params':
        break;
    }

    document.getElementById('sbh-friends-icons').dataset.current = tab;
  };
  /**
   * Ferme la fenêtre de profil d'un utilisateur
  */


  closeUserProfile = function closeUserProfile() {
    document.getElementById('user-profile').classList.add('hidden');
    document.getElementById('user-profile').classList.remove('flex');
  };
  /**
   * Affiche la fenetre de profil d'un utilisateur
   * @param {event} event - évènement cliqué
  */


  showUserProfile = function showUserProfile(event) {
    var newId = event.target.dataset.id;
    var w = document.getElementById('user-profile');

    if (newId == w.dataset.userId || w.dataset.userId == 0) {
      w.classList.toggle('hidden');
      w.classList.toggle('flex');
    }

    w.dataset.userId = newId; //On actualise seulement lorsqu'on affiche un autre user

    if (w.classList.contains('flex')) {
      getFetch('user/' + newId + '/profile').then(function (results) {
        document.getElementById('user-datas').innerHTML = results.html;

        if (results.isFriend) {
          document.getElementById('delete-friend').addEventListener('click', removeFriend);
        } else {
          document.getElementById('add-friend').addEventListener('click', addFriend);
        }
      });
    }
  };
  /**
   * Ajoute un utilisateur en ami
   * @param {event} event - évènement cliqué
  */


  addFriend = function addFriend(event) {
    var friendId = event.target.dataset.id;
    getFetch('user/request/user/' + friendId + '/befriend').then(function (results) {
      my_notyf(results);
    });
  };
  /**
   * Retire un utilisateur de ses amis
   * @param {event} event - évènement cliqué
  */


  removeFriend = function removeFriend(event) {
    var userId = event.target.dataset.id;
    getFetch('user/friends/' + userId + '/remove').then(function (results) {
      my_notyf(results);

      if (results.success) {
        closeUserProfile();
        document.getElementById('sb-friend-row-' + results.user_id).remove();
      }
    });
  };
  /**
   * Retire un utilisateur de ses amis
   * @param {boolean} isFriend - évènement cliqué
  */


  searchUser = function searchUser() {
    var isFriend = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
    myFetch('friends/filter', {
      method: 'post',
      csrf: true
    }, {
      name: document.getElementById('search-user').value,
      is_friend: isFriend
    }).then(function (response) {
      if (response.ok) {
        document.getElementById('search-user').classList.remove('border');
        return response.json();
      } else {
        if (response.status == 422) {
          document.getElementById('search-user').classList.add('border');
          document.getElementById('search-user').classList.add('border-red-500');
        }

        return null;
      }
    }).then(function (friends) {
      document.getElementById('friends-content-results').innerHTML = friends.html;
      Array.from(document.getElementsByClassName('friend-row')).forEach(function (el) {
        el.addEventListener('click', showUserProfile);
      });

      if (friends === null) {
        document.getElementById('title-friends-content-results').innerHTML = 'Aucun résultat';
      } else {
        document.getElementById('title-friends-content-results').innerHTML = isFriend ? 'Mes amis (' + friends.nb_results + ')' : 'Ajouter des amis';
      }
    });
  };
})();
/******/ })()
;