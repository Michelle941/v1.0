jQuery(function () {

    // this is hack to use global $ instead of closure
    // because jQuery is initialized two times!
    var $ = window.$;

    if (!$('html').hasClass('mobile')) {
        return;
    }

    // modal popup
    var documentBody = $('body'),
        modalContent = $('.modal_popup .modal_content'),
        modalPlaceholder = $('<span style="display:none;"></span>'),
        modalPopup = $('.modal_popup'),
        modalWrapper = $('.modal_wrapper'),
        popupContent = null;

    modalPopup.on('click', '.close', function () {
        modalPopup.trigger('close');
        return false;
    });
    modalPopup.on('click', '.ajax-link', function (event) {
        loadAjaxPopup($(this).attr('href'));
    });
    modalPopup.on('close', function (event) {
        setTimeout(function () {
            if (!event.isDefaultPrevented()) {
                documentBody.removeClass('modal--fullscreen modal--visible');
                if (popupContent) {
                    popupContent.insertBefore(modalPlaceholder);
                }
                popupContent = null;
                modalPlaceholder.remove();
            }
        }, 1);
    });
    modalPopup.on('loading', function () {
        modalPopup.addClass('loading');
    });
    modalPopup.on('loadend', function () {
        modalPopup.removeClass('loading');
    });

    modalWrapper.on('click', function (event) {
        if ($(event.target).is(modalWrapper) && !documentBody.hasClass('modal--fullscreen')) {
            modalPopup.trigger('close');
        }
    });

    documentBody.on('click', '[data-modal]', function () {
        showPopup($($(this).attr('data-modal')));
        return false;
    });

    documentBody.on('click', '.fancybox', function (event) {
        var link = $(this).attr('href');

        if (['#forgot-password', '#join', '#login'].indexOf(link) > -1) {
            showPopup($(link).clone());
            event.preventDefault();
            return false;
        }
    });


    function initPopupSpecificCode() {
        // remove all handlers
        modalContent.off('change click');

        if (modalContent.find('.photo-view').length) {
            initPhotoView();
        }
        if (modalContent.find('#forgot-password, #join-form, #login-form').length) {
            initModalForm();
        }
        if (modalContent.find('#upload-to-party').length) {
            initUploadToParty();
        }
    }

    function initModalForm() {
        documentBody.addClass('modal--fullscreen');

        var container = modalContent.children();
        var form = modalContent.find('form').off('submit');

        new FormValidation(form);
        form.on('submit', function (event) {
            event.preventDefault();
            if ($(this).valid()) {
                modalPopup.trigger('loading');
                if (form.attr('enctype') === 'multipart/form-data') {
                    console.log('ajaxSubmit');
                    form.ajaxSubmit(function (html) {
                        modalPopup.trigger('loadend');
                        container.html(html);
                        initModalForm();
                    });
                } else {
                    $.ajax({
                        complete: function () {
                            modalPopup.trigger('loadend');
                        },
                        data: form.serialize(),
                        method: "POST",
                        success: function (html) {
                            container.html(html);
                            initModalForm();
                        },
                        url: form.attr('action')
                    });
                }
            }
        });
    }

    function initPhotoView() {
        documentBody.addClass('modal--fullscreen');

        modalContent.on('click', '[data-action]', function () {
            var action = $(this).attr('data-action'),
                comment = modalContent.find('textarea'),
                photoId = modalContent.find('.photo-view').attr('data-id'),
                partyId = modalContent.find('.photo-view').attr('data-party');

            switch (action) {
                case 'delete':
                    modalPopup.trigger('loading');
                    $.post('/site/delete-photo/' + photoId, {new : '1'}).done(function () {
                        window.location.reload();
                    });
                    break;
                case 'like':
                    loadAjaxPopup($(this).attr('data-url'));
                    break;
                case 'save':
                    modalPopup.trigger('loading');
                    $.post('/site/save-comment', {
                        id: photoId,
                        model: 'Photo',
                        name: 'comment',
                        obj_id: photoId,
                        party_id: partyId,
                        val: comment.val()
                    }).done(function () {
                        window.location.reload();
                    });
                    break;
                case 'share':
                    (function (share) {
                        if (share.is(':visible')) {
                            modalPopup.trigger('loading');
                            $.post('/site/save-comment', {
                                id: share.attr('data-id') || "",
                                model: 'SharingPhoto',
                                name: 'comment',
                                obj_id: photoId,
                                party_id: partyId,
                                type: 0,
                                val: share.find('textarea').val()
                            }).done(function () {
                                window.location.reload();
                            });
                        } else {
                            share.show();
                            share.find('textarea').get(0).focus();
                        }
                    })(modalPopup.find('.photo-share'));
                    break;
                case 'unshare':
                    if (confirm("Are you sure you want to delete this photo from your profile?\n\nThis photo will still remain in the party album.\nUse the \"SHARE\" button to add this photo back to your profile.")) {
                        modalPopup.trigger('loading');
                        $.post('/site/delete-photo/' + photoId, {new : ''}).done(function () {
                            window.location.reload();
                        });
                    }
                    break;
            }
        });

        modalContent.find('.photo-comment').each(function () {
            var container = $(this),
                comment = container.find('.comment-text'),
                textarea = container.find('textarea');
            if (comment.length) {
                textarea.hide();
            }
            if (textarea.length) {
                comment.on('click', function () {
                    comment.hide();
                    textarea.show();
                    modalContent.find('.button[data-action="save"]').show();
                });
            }
        });
    }

    function initUploadToParty() {
        modalContent.on('change', '.custom-file-input input', function () {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function () {
                    modalPopup.trigger('loading');
                    $('#upload-to-party').ajaxSubmit(function (html) {
                        modalPopup.trigger('loadend');
                        modalContent.empty().html(html);
                        initPopupSpecificCode();

                        // do not allow user to close popup for newly uploaded photo
                        modalPopup.on('close', function (event) {
                            var deleteButton = modalContent.find('[data-action="delete"]');
                            if (deleteButton.length) {
                                event.preventDefault();
                                deleteButton.trigger('click');
                            }
                        });
                    });
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    }

    function loadAjaxPopup(url) {
        documentBody.addClass('loading');
        modalPopup.trigger('loading');

        $.ajax({url: url})
            .complete(function () {
                documentBody.removeClass('loading');
                modalPopup.trigger('loadend');
            })
            .success(function (html) {
                showPopup($($(html).length === 1 ? html : '<div>' + html + '</div>'));
            });
    }

    function showPopup(content) {
        modalPopup.trigger('close');
        modalPopup.trigger('loadend');

        setTimeout(function () {
            if (content) {
                popupContent = $(content);
                modalPlaceholder.insertBefore(popupContent);
                popupContent.appendTo(modalContent.empty());
            }

            documentBody.addClass('modal--visible');
            setTimeout(function () {
                modalContent.scrollTop(0);
                modalPopup.scrollTop(0);
            }, 100);

            initPopupSpecificCode();
        }, 1);
    }


    $('.modal-popups').on('click', '.fancybox-ajax', function () {
        loadAjaxPopup($(this).attr('href'));
        return false;
    });
});