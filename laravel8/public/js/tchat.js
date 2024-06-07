/******/ (() => { // webpackBootstrap
/*!*******************************!*\
  !*** ./resources/js/tchat.js ***!
  \*******************************/
(function () {
  document.addEventListener('click', function (event) {
    closeMsgMenu();
  });
  /**
   * Permet la suppression d'un ou tous les messages du tchat de la liste
   * @param {int} msgId - Identifiant du message à supprimer si != 0
  */

  delListMsg = function delListMsg(msgId) {
    if (confirm('Confirmer la suppression ?')) {
      var listId = document.getElementById('list-selected').value;
      var url = msgId == 0 ? 'lists/' + listId + '/delete/messages' : 'lists/messages/' + msgId + '/delete';
      getFetch(url).then(function (res) {
        my_notyf(res);

        if (res.html) {
          document.getElementById('content-msg').innerHTML = res.html;
          maj_reactions();
        } else {
          var listMsgReaction = document.getElementById('list-msg-reaction');

          if (listMsgReaction.value == msgId) {
            listMsgReaction.value = 0;
          }

          document.getElementById('list-msg-' + msgId).parentNode.remove();
        }
      });
    }
  };
  /**
   * Etend ou réduit la zone de tchat / du détail des listes
   * @param {boolean} reset - True -> Réduit la zone de tchat
  */


  extendListMsg = function extendListMsg() {
    var reset = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
    var msgContent = document.getElementById('content-msg');
    var wrapListProducts = document.getElementById('wrap-list-products');

    if (reset) {
      msgContent.classList.remove('extend');
      wrapListProducts.classList.remove('with-msg');
    } else {
      msgContent.classList.toggle('extend');
      wrapListProducts.classList.toggle('with-msg');
    }
  };
  /**
   * Envoi le message écrit par l'utilisateur dans la liste en cours
  */


  sendMsg = function sendMsg() {
    var msg = document.getElementById('list-msg-to-send');

    if (msg.value === '') {
      notyfJS('Votre message ne peut être vide', 'error');
      return;
    }

    myFetch('lists/messages/send', {
      method: 'post',
      csrf: true
    }, {
      list_id: parseInt(document.getElementById('list-selected').value),
      message: msg.value,
      answer_to_id: parseInt(document.getElementById('list-answer-id').value)
    }).then(function (response) {
      if (response.ok) return response.json();
    }).then(function (res) {
      document.getElementById('v-list-msg').insertAdjacentHTML('beforeend', res.message);
      msg.value = '';

      if (document.getElementById('list-answer-id').value > 0) {
        cancelReply();
      } else {
        scrollDown(document.getElementById('v-list-msg'));
      }
    });
  };
  /**
   * Configure les informations pour répondre à un message
   * @param {int} msgId - Identifiant du message auquel on répond
   * @param {int} name - Nom de l'utilisateur à qui l'on répond
  */


  replyTo = function replyTo(msgId, name) {
    document.getElementById('list-answer-to').classList.remove('hidden');
    document.getElementById('list-answer-to').firstElementChild.innerHTML = name;
    document.getElementById('list-answer-id').value = msgId;
    document.getElementById('list-msg-' + msgId).classList.add('answering');
  };
  /**
   * Annule la préparation à la réponse d'un message
  */


  cancelReply = function cancelReply() {
    var answerId = document.getElementById('list-answer-id').value;

    if (answerId > 0) {
      document.getElementById('list-answer-to').classList.add('hidden');
      document.getElementById('list-answer-id').value = 0;
      document.getElementById('list-msg-' + answerId).classList.remove('answering');
    }
  };
  /**
   * Dés/Epingle un message sur une liste
   * @param {int} msgId - Identifiant du message à dés/épingler
  */


  pin_msg = function pin_msg(msgId) {
    var pinMsg = document.getElementById('pin-msg-icon-' + msgId);
    var action = pinMsg.classList.contains('is-pin') ? 'unpin' : 'pin';
    getFetch('lists/messages/' + msgId + '/' + action).then(function (res) {
      pinMsg.classList[action == 'pin' ? 'add' : 'remove']('is-pin');
      pinMsg.parentNode.classList[action == 'pin' ? 'add' : 'remove']('is-pin');
      my_notyf(res);
    });
  };
  /** 
   * Configure un message pour y ajouter des réactions
   * @param {int} msgId - Identifiant du message
  */


  toggleEmojiMsg = function toggleEmojiMsg(msgId) {
    var active = true;
    var listMsgReaction = document.getElementById('list-msg-reaction');
    var prevId = listMsgReaction.value;

    if (prevId == 0) {
      //On clique pour la première fois
      document.getElementById('reactionIcon' + msgId).classList.add('active');
    } else {
      if (prevId != msgId) {
        //On désactive le précédent et active celui cliqué
        document.getElementById('reactionIcon' + prevId).classList.remove('active');
        document.getElementById('reactionIcon' + msgId).classList.add('active');
      } else {
        //Il s'agit du précédent message donc on vérifie l'état du bouton
        if (document.getElementById('reactionIcon' + msgId).classList.contains('active')) {
          document.getElementById('reactionIcon' + msgId).classList.remove('active');
          active = false;
        } else {
          document.getElementById('reactionIcon' + msgId).classList.add('active');
        }
      }
    }

    listMsgReaction.value = msgId;
    toggleEmojiKeyboard(active);
  };
  /** 
   * Ouvre/ferme le clavier des emojis
   * @param {boolean|int} - Si -1 -> Ouvre le clavier sans se soucier de son précédent état
  */


  toggleEmojiKeyboard = function toggleEmojiKeyboard(openIt) {
    var keyboard = document.getElementById('list-msg-emoji-sections');

    if (openIt == -1) {
      keyboard.classList.toggle('show');
      Array.from(document.getElementsByClassName('btn-emoji-kbd')).forEach(function (e) {
        e.classList.toggle('hidden');
      });
      return;
    }

    document.getElementById('emoji-off').classList.add('hidden');
    document.getElementById('emoji-on').classList.remove('hidden');
    keyboard.classList.add('show');

    if (!openIt) {
      document.getElementById('emoji-off').classList.remove('hidden');
      document.getElementById('emoji-on').classList.add('hidden');
      keyboard.classList.remove('show');
    }
  };
  /** 
   * Annule toutes les actions possibles du menu des messages
  */


  resetMsgActions = function resetMsgActions() {
    cancelReply();
  };
  /** 
   * Ferme le menu des actions d'un message
  */


  closeMsgMenu = function closeMsgMenu() {
    document.getElementById('list-msg-menu').classList.add('hidden');
  };
  /**
   * Ouvre le menu des actions d'un message
   * @param {event} e - évènément cliqué
   * @param {int} msgId - Identifiant du message
   * @param {string} yours - Message de l'utilisateur ou non
   * @param {boolean} pin - Indique si le message était épinglé ou non
   * @param {string} answerTo - Nom de l'utilisateur qui a envoyé ce message
  */


  openMsgMenu = function openMsgMenu(e, msgId, yours, pin, answerTo) {
    resetMsgActions();
    var x = e.clientX;
    var y = e.clientY + window.scrollY; //Prise en compte de la scrollbar

    myFetch('lists/messages/menu/show', {
      method: 'post',
      csrf: true
    }, {
      msg_id: parseInt(msgId),
      yours: yours == '' ? false : yours,
      pin: pin == '' ? false : pin,
      answer_to: answerTo
    }).then(function (response) {
      if (response.ok) return response.json();
    }).then(function (res) {
      document.getElementById('list-msg-menu').innerHTML = res.html;
      document.getElementById('list-msg-menu').classList.remove('hidden');
      document.getElementById('list-msg-menu').style.left = x + 'px';
      document.getElementById('list-msg-menu').style.top = y + 'px';
    });
  };
  /** 
   * Ajoute/Enlève une réaction au message préselectionné
   * @param {event} event - évènément cliqué
  */


  reactionClicked = function reactionClicked(event) {
    var datas = event.target.dataset;
    var msgId = datas.messageId == undefined ? document.getElementById('list-msg-reaction').value : datas.messageId;
    var emojiId = datas.emojiId == undefined ? datas.id : datas.emojiId;
    var reactionElement = document.getElementById('msg-' + msgId + '-reaction-' + emojiId);
    getFetch('lists/messages/' + msgId + '/emojis/' + emojiId).then(function (res) {
      if (!res.created) {
        removeReaction(res.nb_users, reactionElement, msgId);
      } else {
        if (reactionElement == undefined) {
          //On rajoute l'emoji aux autres
          document.getElementById('list-msg-' + msgId).querySelector('div.v-line-reactions').innerHTML = res.reactionsHTML;
          requestAnimationFrame(function () {
            reactionElement = document.getElementById('msg-' + msgId + '-reaction-' + emojiId);
            addReaction(reactionElement, msgId, true);
          });
        } else {
          addReaction(reactionElement, msgId);
        }
      }
    });
  };
  /** 
   * Ajoute une réaction à un message
   * @param {int} emojiId - Identifiant de l'emoji
   * @param {int} msgId - Identifiant du message
   * @param {boolean} justRefreshed - Indique si les réactions viennent d'être rafrachies ou non
  */


  addReaction = function addReaction(emojiId, msgId) {
    var justRefreshed = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
    emojiId.classList.add('grow-up');
    setTimeout(function () {
      emojiId.classList.remove('grow-up');
    }, 1000);
    var span_user = document.getElementById('list-msg-' + msgId).querySelector('div.v-line-reactions span:last-child');
    var nb_users = justRefreshed ? span_user.innerHTML : parseInt(span_user.innerHTML) + 1;
    span_user.innerHTML = nb_users;
    maj_reactions();
  };
  /** 
   * Retire une réaction à un message (avec effet si c'était le dernier utilisateur sur cette réaction)
   * @param {int} emojiId - Identifiant de l'emoji
   * @param {int} msgId - Identifiant du message
   * @param {string} nbUsers - Nombre d'utilisateurs restants pour cette réaction
  */


  removeReaction = function removeReaction(nbUsers, emojiId, msgId) {
    if (nbUsers == '') {
      emojiId.classList.add('grow-down');
      setTimeout(function () {
        emojiId.classList.remove('grow-down');
        emojiId.remove();
      }, 1000);
    }

    var span_user = document.getElementById('list-msg-' + msgId).querySelector('div.v-line-reactions span:last-child');
    span_user.innerHTML = span_user.innerHTML > 1 ? span_user.innerHTML - 1 : '';
  };
  /** 
   * Charge (1 fois) ou affiche la vue de la section des emojis demandée
   * @param {event} event - évènement
   * @param {int} sectionId - Identifiant de la section
  */


  showEmojiSection = function showEmojiSection(event, sectionId) {
    event = 'sectionId' in event.target.dataset ? event.target.parentNode : event.target;
    if (event.dataset.loaded == 'true') return;
    getFetch('tchat/sections/' + sectionId + '/show').then(function (res) {
      event.dataset.loaded = true;
      document.getElementById('emoji-kbd-section' + sectionId).innerHTML = res.html;
      Array.from(document.getElementById('emoji-kbd-section' + sectionId).getElementsByClassName('msg-reaction')).forEach(function (e) {
        e.addEventListener('click', reactionClicked);
      });
    });
  };
  /** 
   * Gère le changement des sections d'emojis
   * @param {event} event - évènement cliqué
  */


  EmojiSectionChanged = function EmojiSectionChanged(event) {
    var cur_section = document.getElementById('list-msg-emoji-section-id');
    var prev_id = cur_section.value;
    var datas = event.target.dataset;
    var id = 'sectionId' in datas ? datas.sectionId : datas.id;
    if (prev_id == id) return;
    showEmojiSection(event, id); //On affiche la nouvelle section et cache la précédente

    if (prev_id > 0) {
      document.getElementById('emoji-kbd-section' + prev_id).classList.remove('show');
    }

    cur_section.value = id;
    document.getElementById('emoji-kbd-section' + id).classList.add('show');
  };
  /** 
   * Met a jour les réactions des messages visibles
  */


  maj_reactions = function maj_reactions() {
    // addEventListeners(e, ['click', 'mouseover', 'mouseout'], (e) => {
    Array.from(document.getElementsByClassName('msg-reaction')).forEach(function (e) {
      e.addEventListener('click', reactionClicked);
    });
    var prevSectionId = document.getElementById('list-msg-emoji-section-id').value;
    var sections = document.getElementsByClassName('emoji-section-title');
    Array.from(sections).forEach(function (e) {
      e.addEventListener('click', EmojiSectionChanged); //On simule le clic sur chaque section à cet endroit car la page aura normalement été complètement chargée

      e.click();
    }); //On affiche la précédente section sélectionnée ou la 1ère si c'est la première fois

    sections[prevSectionId == 0 ? prevSectionId : prevSectionId - 1].click();
  };
  /** 
   * Affiche le message
  */


  showMsg = function showMsg() {
    var listId = document.getElementById('list-selected').value;
    var showPin = !document.getElementById('show-pin').classList.contains('active');
    var type = showPin ? 'pinned' : 'all';
    getFetch('lists/' + listId + '/messages/show/' + type).then(function (res) {
      document.getElementById('v-list-msg').innerHTML = res.html;
      document.getElementById('show-pin').classList.toggle('active');
    });
  };
  /** 
   * Joue un effet sur un message
   * @param {int} msgId - Identifiant du message flashé
  */


  flashOriginalMsg = function flashOriginalMsg(msgId) {
    var msg = document.getElementById('list-msg-' + msgId);
    msg.classList.add('flash');
    setTimeout(function () {
      msg.classList.remove('flash');
    }, 1500);
  };
})();
/******/ })()
;