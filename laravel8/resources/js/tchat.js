(function() {
    document.addEventListener('click', function(event) {
        closeMsgMenu();
    });
    
    del_list_msg = function(id) {
        event.stopPropagation();
        if(confirm('Confirmer la suppression ?')) {
            const list_id = document.getElementById('list_selected').value;
            let url = (id == 0) ? 'lists/' + list_id + '/delete/messages' : 'lists/messages/' + id + '/delete';
            get_fetch(url)
            .then(res => {
                my_notyf(res);
                if (res.html) {
                    document.getElementById('messages_content').innerHTML = res.html;
                } else {
                    document.getElementById('list_msg_' + id).parentNode.remove();
                }
            });
        }
    }

    extendListMsg = function(reset = false) {
        const msg_content = document.getElementById('messages_content');
        const wrap_list_products = document.getElementById('wrap_list_products');
        if (reset) {
            msg_content.classList.remove('extend');
            wrap_list_products.classList.remove('with_msg');
        } else {
            msg_content.classList.toggle('extend');
            wrap_list_products.classList.toggle('with_msg');
        }
    }

    send_msg = function() {
        my_fetch('lists/messages/send', {method: 'post', csrf: true}, {
            listing_id: parseInt(document.getElementById('list_selected').value),
            message: document.getElementById('list_msg_to_send').value,
            answer_to_id: parseInt(document.getElementById('list_answer_id').value),
        }).then(response => {
            if (response.ok) return response.json();
        }).then(res => {
            document.getElementById('v_list_msg').insertAdjacentHTML('beforeend', res.message);
            document.getElementById('list_msg_to_send').value = '';
            
            if (document.getElementById('list_answer_id').value > 0) {
                cancelReply();
            } else {
                scrollDown(document.getElementById('v_list_msg'));
            }
        });
    }

    replyTo = function(id, name) {
        document.getElementById('list_answer_to').classList.remove('hidden');
        document.getElementById('list_answer_to').firstElementChild.innerHTML = name;
        document.getElementById('list_answer_id').value = id;
        document.getElementById('list_msg_' + id).classList.add('answering');
    }
    
    cancelReply = function() {
        const answer_id = document.getElementById('list_answer_id').value;
        if (answer_id > 0) {
            document.getElementById('list_answer_to').classList.add('hidden');
            document.getElementById('list_answer_id').value = 0;
            document.getElementById('list_msg_' + answer_id).classList.remove('answering');
        }
    }
    
    pin_msg = function(id) {
        const pin_msg = document.getElementById('pin_msg_icon_' + id);
        const action = pin_msg.classList.contains('is_pin') ? 'unpin' : 'pin';
        get_fetch('lists/messages/' + id + '/' + action)
        .then(res => {
            pin_msg.classList[(action == 'pin' ? 'add' : 'remove')]('is_pin');
            pin_msg.parentNode.classList[(action == 'pin' ? 'add' : 'remove')]('is_pin');
            my_notyf(res);
        });
    }

    /** 
     * (Des)Active the emoji msg btn and open the Emoji Keyboard if it's closed
    */
    toggleEmojiMsg = function(id) {
        let active = true;
        const list_msg_reaction = document.getElementById('list_msg_reaction');
        const prev_id = list_msg_reaction.value;

        if (prev_id == 0) {//On clique pour la première fois
            document.getElementById('react_msg_icon_' + id).classList.add('active');
            
        } else {
            if (prev_id != id) {//On désactive le précédent et active celui cliqué
                document.getElementById('react_msg_icon_' + prev_id).classList.remove('active');
                document.getElementById('react_msg_icon_' + id).classList.add('active');
                
                //Il s'agit du précédent message donc on vérifie l'état du bouton
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
    }
    
    /** 
     * Open or close the Emojis Keyboard
    */
    toggleEmojiKeyboard = function(openIt) {
        const keyboard = document.getElementById('list_msg_emoji_sections');
        if (openIt == -1) {
            keyboard.classList.toggle('show');
            return;
        }
        keyboard.classList.add('show');
        if (!openIt) {
            keyboard.classList.remove('show');
        }
    }
    
    /** 
     * Cancel every msg menu's actions that can be done in time
    */
    resetMsgActions = function() {
        cancelReply();
    }

    closeMsgMenu= function() {
        document.getElementById('list_msg_menu').classList.add('hidden');
    }

    /** 
     * Open the Msg menu's actions
    */
    openMsgMenu = function(e, msg_id, yours, pin, answer_to) {
        resetMsgActions();
        let x = e.clientX;
        let y = e.clientY + window.scrollY;//Prise en compte de la scrollbar
        my_fetch('lists/messages/menu/show', {method: 'post', csrf: true}, {
            msg_id: parseInt(msg_id),
            yours: (yours == '' ? false : yours),
            pin: pin,
            answer_to: answer_to,
        }).then(response => {
            if (response.ok) return response.json();
        }).then(res => {
            document.getElementById('list_msg_menu').innerHTML = res.html;
            document.getElementById('list_msg_menu').classList.remove('hidden');
            document.getElementById('list_msg_menu').style.left = x + 'px';
            document.getElementById('list_msg_menu').style.top = y + 'px';
        });
    }

    reactionClicked = function(e) {
        const datas = e.target.dataset;
        const msg_id = (datas.messageId == undefined) ? document.getElementById('list_msg_reaction').value : datas.messageId;
        const emoji_id = (datas.emojiId == undefined) ? datas.id : datas.emojiId;
        let e_id = document.getElementById('msg_' + msg_id + '_reaction_' + emoji_id);
        get_fetch('lists/messages/' + msg_id + '/emojis/' + emoji_id)
        .then(res => {
            if (!res.created) {
                removeReaction(res.nb_users, e_id, msg_id);
            } else {
                if (e_id == undefined) {//On rajoute l'emoji aux autres
                    document.getElementById('list_msg_' + msg_id).querySelector('div.vline_reactions').innerHTML = res.reactionsHTML;
                    requestAnimationFrame(function() {
                        e_id = document.getElementById('msg_' + msg_id + '_reaction_' + emoji_id);
                        addReaction(e_id, msg_id, true);
                    })
                } else {
                    addReaction(e_id, msg_id);
                }
            }
        });
    }

    addReaction = function(e_id, msg_id, justRefreshed = false) {
        e_id.classList.add('growUp');
        setTimeout(() => { e_id.classList.remove('growUp'); }, 1000);
        const span_user = document.getElementById('list_msg_' + msg_id).querySelector('div.vline_reactions span:last-child');
        const nb_users = justRefreshed ? span_user.innerHTML : parseInt(span_user.innerHTML) + 1;
        span_user.innerHTML = nb_users;
        maj_reactions();
    }

    removeReaction = function(nb_users, e_id, msg_id) {
        if (nb_users == '') {
            e_id.classList.add('growDown');
            setTimeout(() => {
                e_id.classList.remove('growDown');
                e_id.remove();
            }, 1000);
        }
        const span_user = document.getElementById('list_msg_' + msg_id).querySelector('div.vline_reactions span:last-child');
        span_user.innerHTML = (span_user.innerHTML > 1) ? span_user.innerHTML - 1 : '';
    }

    EmojiSectionChanged = function(e) {
        const cur_section = document.getElementById('list_msg_emoji_section_id');
        const prev_id = cur_section.value;
        const datas = e.target.dataset;
        const id = ('sectionId' in datas) ? datas.sectionId : datas.id;

        if (prev_id == id) return;
        
        if (prev_id != id) {
            document.getElementById('emoji_kbd_section_' + prev_id).classList.remove('show');
            cur_section.value = id;
        }
        document.getElementById('emoji_kbd_section_' + id).classList.add('show');
    }

    maj_reactions = function() {
        // addEventListeners(e, ['click', 'mouseover', 'mouseout'], (e) => {
        Array.from(document.getElementsByClassName('msg_reaction')).forEach(e => {
            e.addEventListener('click', reactionClicked);
        });
        
        Array.from(document.getElementsByClassName('emoji_section_title')).forEach(e => {
            e.addEventListener('click', EmojiSectionChanged);
        });
    }
    
    show_msg = function() {
        const list_id = document.getElementById('list_selected').value;
        const show_pin = !document.getElementById('show_pin').classList.contains('active');
        const type = show_pin ? 'pinned' : 'all';
        get_fetch('lists/' + list_id + '/messages/show/' + type)
        .then(res => {
            document.getElementById('v_list_msg').innerHTML = res.html;
            document.getElementById('show_pin').classList.toggle('active');
        });
    }

    flashOriginalMsg = function(id) {
        const msg = document.getElementById('list_msg_' + id);
        msg.classList.add('flash');
        setTimeout(() => { msg.classList.remove('flash'); }, 1500);
    }
})();
