/******/ (() => { // webpackBootstrap
/*!*******************************!*\
  !*** ./resources/js/tchat.js ***!
  \*******************************/
(function () {
  document.addEventListener('click', function (event) {
    closeMsgMenu();
  });

  del_list_msg = function del_list_msg(id) {
    event.stopPropagation();

    if (confirm('Confirmer la suppression ?')) {
      var list_id = document.getElementById('list_selected').value;
      var url = id == 0 ? 'lists/' + list_id + '/delete/messages' : 'lists/messages/' + id + '/delete';
      get_fetch(url).then(function (res) {
        my_notyf(res);

        if (res.html) {
          document.getElementById('messages_content').innerHTML = res.html;
        } else {
          document.getElementById('list_msg_' + id).parentNode.remove();
        }
      });
    }
  };

  extendListMsg = function extendListMsg() {
    var reset = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
    var msg_content = document.getElementById('messages_content');
    var wrap_list_products = document.getElementById('wrap_list_products');

    if (reset) {
      msg_content.classList.remove('extend');
      wrap_list_products.classList.remove('with_msg');
    } else {
      msg_content.classList.toggle('extend');
      wrap_list_products.classList.toggle('with_msg');
    }
  };

  send_msg = function send_msg() {
    var msg = document.getElementById('list_msg_to_send');

    if (msg.value === '') {
      notyfJS('Votre message ne peut être vide', 'error');
      return;
    }

    my_fetch('lists/messages/send', {
      method: 'post',
      csrf: true
    }, {
      listing_id: parseInt(document.getElementById('list_selected').value),
      message: msg.value,
      answer_to_id: parseInt(document.getElementById('list_answer_id').value)
    }).then(function (response) {
      if (response.ok) return response.json();
    }).then(function (res) {
      document.getElementById('v_list_msg').insertAdjacentHTML('beforeend', res.message);
      msg.value = '';

      if (document.getElementById('list_answer_id').value > 0) {
        cancelReply();
      } else {
        scrollDown(document.getElementById('v_list_msg'));
      }
    });
  };

  replyTo = function replyTo(id, name) {
    document.getElementById('list_answer_to').classList.remove('hidden');
    document.getElementById('list_answer_to').firstElementChild.innerHTML = name;
    document.getElementById('list_answer_id').value = id;
    document.getElementById('list_msg_' + id).classList.add('answering');
  };

  cancelReply = function cancelReply() {
    var answer_id = document.getElementById('list_answer_id').value;

    if (answer_id > 0) {
      document.getElementById('list_answer_to').classList.add('hidden');
      document.getElementById('list_answer_id').value = 0;
      document.getElementById('list_msg_' + answer_id).classList.remove('answering');
    }
  };

  pin_msg = function pin_msg(id) {
    var pin_msg = document.getElementById('pin_msg_icon_' + id);
    var action = pin_msg.classList.contains('is_pin') ? 'unpin' : 'pin';
    get_fetch('lists/messages/' + id + '/' + action).then(function (res) {
      pin_msg.classList[action == 'pin' ? 'add' : 'remove']('is_pin');
      pin_msg.parentNode.classList[action == 'pin' ? 'add' : 'remove']('is_pin');
      my_notyf(res);
    });
  };
  /** 
   * (Des)Active the emoji msg btn and open the Emoji Keyboard if it's closed
  */


  toggleEmojiMsg = function toggleEmojiMsg(id) {
    var active = true;
    var list_msg_reaction = document.getElementById('list_msg_reaction');
    var prev_id = list_msg_reaction.value;

    if (prev_id == 0) {
      //On clique pour la première fois
      document.getElementById('react_msg_icon_' + id).classList.add('active');
    } else {
      if (prev_id != id) {
        //On désactive le précédent et active celui cliqué
        document.getElementById('react_msg_icon_' + prev_id).classList.remove('active');
        document.getElementById('react_msg_icon_' + id).classList.add('active'); //Il s'agit du précédent message donc on vérifie l'état du bouton
      } else {
        if (document.getElementById('react_msg_icon_' + id).classList.contains('active')) {
          document.getElementById('react_msg_icon_' + id).classList.remove('active');
          active = false;
        } else {
          document.getElementById('react_msg_icon_' + id).classList.add('active');
        }
      }
    }

    list_msg_reaction.value = id;
    toggleEmojiKeyboard(active);
  };
  /** 
   * Open or close the Emojis Keyboard
  */


  toggleEmojiKeyboard = function toggleEmojiKeyboard(openIt) {
    var keyboard = document.getElementById('list_msg_emoji_sections');

    if (openIt == -1) {
      keyboard.classList.toggle('show');
      Array.from(document.getElementsByClassName('btn_emoji_kbd')).forEach(function (e) {
        e.classList.toggle('hidden');
      });
      return;
    }

    document.getElementById('emoji_off').classList.add('hidden');
    document.getElementById('emoji_on').classList.remove('hidden');
    keyboard.classList.add('show');

    if (!openIt) {
      document.getElementById('emoji_off').classList.remove('hidden');
      document.getElementById('emoji_on').classList.add('hidden');
      keyboard.classList.remove('show');
    }
  };
  /** 
   * Cancel every msg menu's actions that can be done in time
  */


  resetMsgActions = function resetMsgActions() {
    cancelReply();
  };

  closeMsgMenu = function closeMsgMenu() {
    document.getElementById('list_msg_menu').classList.add('hidden');
  };
  /** 
   * Open the Msg menu's actions
  */


  openMsgMenu = function openMsgMenu(e, msg_id, yours, pin, answer_to) {
    resetMsgActions();
    var x = e.clientX;
    var y = e.clientY + window.scrollY; //Prise en compte de la scrollbar

    my_fetch('lists/messages/menu/show', {
      method: 'post',
      csrf: true
    }, {
      msg_id: parseInt(msg_id),
      yours: yours == '' ? false : yours,
      pin: pin,
      answer_to: answer_to
    }).then(function (response) {
      if (response.ok) return response.json();
    }).then(function (res) {
      document.getElementById('list_msg_menu').innerHTML = res.html;
      document.getElementById('list_msg_menu').classList.remove('hidden');
      document.getElementById('list_msg_menu').style.left = x + 'px';
      document.getElementById('list_msg_menu').style.top = y + 'px';
    });
  };

  reactionClicked = function reactionClicked(e) {
    var datas = e.target.dataset;
    var msg_id = datas.messageId == undefined ? document.getElementById('list_msg_reaction').value : datas.messageId;
    var emoji_id = datas.emojiId == undefined ? datas.id : datas.emojiId;
    var e_id = document.getElementById('msg_' + msg_id + '_reaction_' + emoji_id);
    get_fetch('lists/messages/' + msg_id + '/emojis/' + emoji_id).then(function (res) {
      if (!res.created) {
        removeReaction(res.nb_users, e_id, msg_id);
      } else {
        if (e_id == undefined) {
          //On rajoute l'emoji aux autres
          document.getElementById('list_msg_' + msg_id).querySelector('div.vline_reactions').innerHTML = res.reactionsHTML;
          requestAnimationFrame(function () {
            e_id = document.getElementById('msg_' + msg_id + '_reaction_' + emoji_id);
            addReaction(e_id, msg_id, true);
          });
        } else {
          addReaction(e_id, msg_id);
        }
      }
    });
  };

  addReaction = function addReaction(e_id, msg_id) {
    var justRefreshed = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
    e_id.classList.add('growUp');
    setTimeout(function () {
      e_id.classList.remove('growUp');
    }, 1000);
    var span_user = document.getElementById('list_msg_' + msg_id).querySelector('div.vline_reactions span:last-child');
    var nb_users = justRefreshed ? span_user.innerHTML : parseInt(span_user.innerHTML) + 1;
    span_user.innerHTML = nb_users;
    maj_reactions();
  };

  removeReaction = function removeReaction(nb_users, e_id, msg_id) {
    if (nb_users == '') {
      e_id.classList.add('growDown');
      setTimeout(function () {
        e_id.classList.remove('growDown');
        e_id.remove();
      }, 1000);
    }

    var span_user = document.getElementById('list_msg_' + msg_id).querySelector('div.vline_reactions span:last-child');
    span_user.innerHTML = span_user.innerHTML > 1 ? span_user.innerHTML - 1 : '';
  };

  showEmojiSection = function showEmojiSection(el, id) {
    el = 'sectionId' in el.target.dataset ? el.target.parentNode : el.target; //On charge la vue de la section des emojis qui est demandée (1 seule fois chacune)

    if (el.dataset.loaded === true) return;
    get_fetch('tchat/sections/' + id + '/show').then(function (res) {
      el.dataset.loaded = true;
      document.getElementById('emoji_kbd_section_' + id).innerHTML = res.html;
    });
  };

  EmojiSectionChanged = function EmojiSectionChanged(e) {
    var cur_section = document.getElementById('list_msg_emoji_section_id');
    var prev_id = cur_section.value;
    var datas = e.target.dataset;
    var id = 'sectionId' in datas ? datas.sectionId : datas.id;
    if (prev_id == id) return;
    showEmojiSection(e, id); //On affiche la nouvelle section et cache la précédente

    if (prev_id > 0) {
      document.getElementById('emoji_kbd_section_' + prev_id).classList.remove('show');
    }

    cur_section.value = id;
    document.getElementById('emoji_kbd_section_' + id).classList.add('show');
  };

  maj_reactions = function maj_reactions() {
    // addEventListeners(e, ['click', 'mouseover', 'mouseout'], (e) => {
    Array.from(document.getElementsByClassName('msg_reaction')).forEach(function (e) {
      e.addEventListener('click', reactionClicked);
    });
    var sections = document.getElementsByClassName('emoji_section_title');
    Array.from(sections).forEach(function (e) {
      e.addEventListener('click', EmojiSectionChanged); //On simule le clic sur chaque section à cet endroit car la page aura normalement été complètement chargée

      e.click();
    }); //On affiche la 1ere section au chargement

    sections[0].click();
  };

  show_msg = function show_msg() {
    var list_id = document.getElementById('list_selected').value;
    var show_pin = !document.getElementById('show_pin').classList.contains('active');
    var type = show_pin ? 'pinned' : 'all';
    get_fetch('lists/' + list_id + '/messages/show/' + type).then(function (res) {
      document.getElementById('v_list_msg').innerHTML = res.html;
      document.getElementById('show_pin').classList.toggle('active');
    });
  };

  flashOriginalMsg = function flashOriginalMsg(id) {
    var msg = document.getElementById('list_msg_' + id);
    msg.classList.add('flash');
    setTimeout(function () {
      msg.classList.remove('flash');
    }, 1500);
  };
})();
/******/ })()
;