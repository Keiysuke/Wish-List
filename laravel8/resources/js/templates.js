(function () {
    setTemplateType = function () {
        document.getElementById('wrap-lk-video-game').classList.add('hidden');
        document.getElementById('wrap-lk-vg-support').classList.add('hidden');
        document.getElementById('wrap-lk-publisher').classList.add('hidden');
        switch (document.getElementById('template-type').value) {
            case 'video_game': 
                document.getElementById('wrap-lk-video-game').classList.remove('hidden');
                document.getElementById('wrap-lk-vg-support').classList.remove('hidden');
                break;
            case 'vg_support': 
                document.getElementById('wrap-lk-vg-support').classList.remove('hidden');
                break;
            case 'publisher': 
                document.getElementById('wrap-lk-publisher').classList.remove('hidden');
                break;
        }
    }
    document.getElementById('template-type').addEventListener('change', setTemplateType);
    setTemplateType();

    initSelect2 = function (selector, placeholder, searchDataType, formatText = (item) => item.label) {
        $(selector).select2({
            placeholder: placeholder,
            allowClear: true,
            ajax: {
                url: $(selector).data('url'),
                dataType: 'json',
                delay: 200,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page,
                        searchDataType: searchDataType
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: formatText(item),
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            }
        });
    }
})()
