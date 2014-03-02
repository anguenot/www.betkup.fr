var check = [];
(function ($) {
    $.fn.autoSuggest = function (params) {
        var jqXHR = null,
            _defaults = {
                "authorizeBloc":null,
                "authorizeNeededValue":'FR',
                "search_url":"",
                "cancel_url":"",
                "blocName":"",
                "text_no_results":"",
                "min_size":2,
                "blocNameAdd":"",
                "givenZipCode":"",
                "searching_regex":/^[A-Za-z0-9]*$/,
                "delay":200
            },
            opts = $.extend(_defaults, params),
            container = $(this),
            stringSearch = "",
            typewatch = (function () {
                var timer = 0;
                return function (callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                }
            })();

        var authorize = isAuthorized(opts.authorizeBloc, opts.authorizeNeededValue);
        opts.authorizeBloc.unbind('change').bind('change', function () {
            authorize = isAuthorized($(this), opts.authorizeNeededValue);
        });

        container.unbind('keypress keyup').bind('keypress keyup', function (e) {

            var pressedChar = String.fromCharCode(e.which);//get string value for pressed char
            if (opts.searching_regex.test(pressedChar) || e.which == "8" || e.which == "13") {
                if (authorize) {
                    stringSearch = container.val();

                    if (stringSearch.length >= opts.min_size) {
                        showContener();
                        check[opts.blocName] = false;
                        checking();
                        _call(opts.search_url, stringSearch, opts.text_no_results);
                    }
                    else {
                        killAll();
                    }
                }
            }
        });

        function isAuthorized(bloc, neededValue) {
            var isAuthorize = false;

            if (bloc.val() == neededValue) {
                isAuthorize = true
            }
            return isAuthorize;
        }

        function _call(url, cityName, txtNoResults) {
            if (jqXHR != null) {
                jqXHR.abort();
            }

            typewatch(function () {
                jqXHR = $.ajax({
                    type:'GET',
                    url:url,
                    async:true,
                    data:{
                        city_name:cityName
                    },
                    dataType:'json'
                }).done(function (data) {
                        $('#content-search-' + opts.blocName + '-results').empty();
                        if (data && data.length > 0) {
                            showSuggestions(data);
                        } else {
                            txtNoResults = '<p style="color: #CCC; margin-top: 100px; height:25px; width:248px; text-align:center;">' + txtNoResults + '</p>';
                            $('#content-search-' + opts.blocName + '-results').html(txtNoResults);
                        }

                    })
            }, opts.delay);
        }

        function showSuggestions(data) {
            var dataStringify;
            line = '';
            line += '<ul id="ul-result-' + opts.blocName + '" class="result-cities">';
            for (var i = 0; i < data.length; i++) {
                dataStringify = {
                    "name":data[i].name,
                    "departmentId":data[i].departmentId,
                    "zipcode":data[i].zipcode
                };
                line += '<li class="result-cities-li"><a href="javascript:void(0);" data=\'' + escape(JSON.stringify(dataStringify)) + '\'>' + data[i].name.replace("'", "\'") + ' (' + data[i].zipcode + ')</a></li>';
            }
            line += '</ul>';
            $('#content-search-' + opts.blocName + '-results').html(line);
            addEvent();
        }

        function showLoading() {

            var loadingImg = '<div style="display: block; margin-left: auto; margin-right: auto; width: 220px; height: 19px;"><img src="/images/interface/wait_big.gif" width="220" height="19" /></div>';
            $('#content-search-' + opts.blocName + '-results').html(loadingImg);
        }

        function addEvent() {
            $('#ul-result-' + opts.blocName).find('li').hover(function () {
                $(this).addClass('result-cities-li-hover');
            }, function () {
                $(this).removeClass('result-cities-li-hover');
            });

            $('.result-cities-li a').click(function () {
                chooseClick($(this));
            });
        }

        function chooseClick(object) {
            var datas = JSON.parse(unescape(object.attr('data')));

            // Set zipcode or department. Depending of blocName
            if (opts.blocName == 'accountCity') {
                $('#accountCodezip').val(datas.zipcode);
            } else if (opts.blocName == 'accountBirthplace') {
                $('#accountBirthregion').val(datas.departmentId);
            } else {
                console.log('#' + opts.givenZipCode + '' + opts.blocNameAdd);
                $('#' + opts.givenZipCode + '' + opts.blocNameAdd).val(datas.zipcode);
            }

            $('#' + opts.blocName + "" + opts.blocNameAdd).val(datas.name + ' (' + datas.zipcode + ')');
            check[opts.blocName] = true;
            killAll();
        }

        function showContener() {
            $('#content-search-' + opts.blocName + '-results').show('fast');
            showLoading();
        }

        function killAll() {
            if (jqXHR != null) {
                jqXHR.abort();
            }

            $('#content-search-' + opts.blocName + '-results').hide('fast', function () {
                $(this).empty();
            });
            checking();
        }

        function checking() {

            if (check[opts.blocName]) {
                $("#" + opts.blocName).removeClass("formInputVarcharErrorOnlyTicker");
                $("#" + opts.blocName).addClass("formInputVarcharSuccessOnlyTicker");
            } else {
                $("#" + opts.blocName).removeClass("formInputVarcharSuccessOnlyTicker");
                $("#" + opts.blocName).addClass("formInputVarcharErrorOnlyTicker");
            }
        }

    };

})(jQuery);