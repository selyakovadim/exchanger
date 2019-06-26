$(function () {
    "use strict";

    function changeGivePaymentSystem() {
        var url = $(this)
            .find("option:selected")
            .data("url");
        console.log(url);
        window.location.href = url;
    }

    function changeGetPaymentSystem() {
        var url = $(this)
            .find("option:selected")
            .data("url");
        console.log(url);
        window.location.href = url;
    }

    $("#select_give")
        .change(changeGivePaymentSystem);

    $("#select_get")
        .change(changeGetPaymentSystem);

    function round(amount, currency) {
         if (currency === 'BTC')
             return amount.toFixed(8);
         return amount.toFixed(2);
    }

    //ввожу сумму которую хочу отдать
    function calcResultFromGiveSum() {
        var $sumGive =  $(".js_summ1");
        var $sumReceive = $(".js_summ2");

        var sumGive = (+$sumGive.val());

        var giveCurrency = $sumGive.data('currency');
        var giveMin = +$sumGive.data('min');
        var receiveMax = +$sumReceive.data('max');
        var receiveCurrency = $sumReceive.data('currency');
        var convert = +$sumGive.data('rate');
        var from_system_commission =  +$sumGive.data('system-commission');
        var to_system_commission = +$sumReceive.data('system-commission');

        $(".js_error").text("");
        $(".xchange_sum_input.js_wrap_error.js_wrap_error_br.error")
            .removeClass('error');

        if (sumGive < giveMin) {
            $sumGive
                .closest("div")
                .addClass("error")
                .find("div").html("Минимум " + round(giveMin, giveCurrency));
        }

        var sumReceive = sumGive;
        from_system_commission = round(sumGive * from_system_commission / 100, giveCurrency);
        sumReceive -= from_system_commission;
        sumReceive = sumReceive * convert;
        to_system_commission = round(sumReceive * to_system_commission / 100, receiveCurrency);
        sumReceive = round(sumReceive - to_system_commission, receiveCurrency);

        $sumReceive.val(sumReceive);

        if (sumReceive > receiveMax) {
            $sumReceive
                .closest("div")
                .addClass("error")
                .find("div").html("Максимум " + round(receiveMax, receiveCurrency));
        }
    }

    //ввожу сумму которую я получу c учетом комиссии
    function calcResultFromRecivedSum() {
        var $sumGive =  $(".js_summ1");
        var $sumReceive = $(".js_summ2");

        var sumReceive = +$sumReceive.val();

        var receiveCurrency = $sumReceive.data('currency');
        var receiveMax = +$sumReceive.data('max');
        var giveMin = +$sumGive.data('min');
        var giveCurrency = $sumGive.data('currency');
        var convert = +$sumReceive.data('rate');
        var to_system_commission =  +$sumReceive.data('system-commission');
        var from_system_commission =  +$sumGive.data('system-commission');

        $(".js_error").text("");
        $(".xchange_sum_input.js_wrap_error.js_wrap_error_br.error")
            .removeClass('error');

        if (sumReceive > receiveMax) {
            $sumReceive
                .closest("div")
                .addClass("error")
                .find("div").html("Максимум " + round(receiveMax, receiveCurrency));
        }

        var sumGive = sumReceive;
        to_system_commission = 100 / (100 - to_system_commission);
        sumGive = sumGive * to_system_commission;
        sumGive = sumGive / convert;
        from_system_commission = (100 / (100 - from_system_commission));
        sumGive = round(sumGive * from_system_commission, giveCurrency);
        $sumGive.val(sumGive);

        if (sumGive < giveMin) {
            $sumGive
                .closest("div")
                .addClass("error")
                .find("div").html("Минимум " + round(giveMin, giveCurrency));
        }
    }

    $(".js_summ1").keyup(calcResultFromGiveSum);
    $(".js_summ2").keyup(calcResultFromRecivedSum);

});
