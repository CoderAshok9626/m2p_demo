(function( $ ) {
    'use strict';
    $(document).ready(function(){ 
        $('#emi_stage_2').addClass('hide');
        //$('#otp_verify').addClass('hide');
        $('.emi-select-options .has-error').addClass('hide');
        $('.emi-lender').addClass('hide');
        $('.lender_3').removeClass('hide');

        var fn = $('#full_name');
        var cn = $('#card_number');
        var yr = $('#ex_year');
        var mn = $('#ex_month');
        var cvv = $('#cvv');

        var full = $('#f_name');
        var mn = $('#mobile_no');
        var dob = $('#dob');
        var pan = $('#pan');
        $('#btn_pay_on_card').on('click',function(event){
            event.preventDefault();
            $('#btn_pay_on_card').html('Loading....');
            var ret = 1; 
            $('.field span').removeClass('has-error');
            var full_name = $('#full_name').val();
            var card_number = $('#card_number').val(); 
            if(full_name == '') {
                fn.next('span').addClass('has-error');
                ret = 0;
            } else if(isNumber(fn.val())){
                fn.next('span').addClass('has-error');
                ret = 0;
            } 
            if(card_number == '') {
                cn.next('span').addClass('has-error');
                ret = 0;
            } else if(parseInt(cn.val().length)!= 16){
                cn.next('span').addClass('has-error');
                ret = 0;
            } else if(!isNumber(cn.val())){
                cn.next('span').addClass('has-error');
                ret = 0;
            } 
            if(cvv == '') {
                cvv.next('span').addClass('has-error');
                ret = 0;
            } else if(parseInt(cvv.val().length) !=3){
                cvv.next('span').addClass('has-error');
                ret = 0;
            } else if(!isNumber(cvv.val())){
                cvv.next('span').addClass('has-error');
                ret = 0;
            }
           
            if(ret != 0) {
                setTimeout(function(){
                    $('#frm_pay_on_card').submit();
                }, 2000);
                //return true;
            } else {
                $('#btn_pay_on_card').html('Pay Now');
                //return false;
            }
        });
        fn.on('blur',function(){
            if(fn.val() == '') {
                fn.next('span').addClass('has-error');
            } else if(isNumber(fn.val())){
                fn.next('span').addClass('has-error');
            } else {                
                fn.next('span').removeClass('has-error');
            }
        });
        cn.on('blur',function(){
            if(cn.val() == '') {
                cn.next('span').addClass('has-error');
            } else if(!isNumber(cn.val())){
                cn.next('span').addClass('has-error');
            } else if(parseInt(cn.val().length)!= 16){
                cn.next('span').addClass('has-error');
            } else {                
                cn.next('span').removeClass('has-error');
            }
        });
        cvv.on('blur',function(){
            if(cvv.val() == '') {
                cvv.next('span').addClass('has-error');
            } else if(!isNumber(cvv.val())){
                cvv.next('span').addClass('has-error');
            } else if(parseInt(cvv.val().length)!= 3){
                cvv.next('span').addClass('has-error');
            } else {                
                cvv.next('span').removeClass('has-error');
            }
        });

        function isEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }
        function isNumber(number) {
            var regex = /^[0-9]+$/;
            return regex.test(number);
        }
        $('.emi-option').click(function(){
            var v = $(this).data('emi-val');
            var o = $(this).data('emi-opt');
            $('.emi-options'+o+' .emi-option').removeClass('fill');
            $(this).addClass('fill');
            $('.emi-select-options .has-error').addClass('hide');
            $('.emi-lenders-list'+o+' .emi-lender').addClass('hide');
            $('.emi-lenders-list'+o+' .lender_'+v).removeClass('hide');
        });
        $('.emi-lender').click(function(){
            var l = $(this).find('input');
            var p = parseInt($(this).data('period'));$('.period').html(p);
            var i = parseInt($(this).data('interest'));$('.interest').html(i);
            var t = parseInt($(this).data('type'));
            var str = $('.purchase_amount').html();
            var tl = parseInt(str.replace(",", ""));
            var amt_int = tl*(i/100);
            var amt_emi = ((tl+amt_int)/p).toFixed(2);
            if(t==1) {
                var amt_total = tl;
            } if(t==2) {
                var amt_total = tl+amt_int;
            }

            $('.amt_emi').html(amt_emi);
            $('.amt_total').html(amt_total);
            l.prop('checked', true);
            $('#emi-option').val(l.val());
            $('.emi-lender').removeClass('fill');
            $(this).addClass('fill');
            $('.emi-select-lenders .has-error').addClass('hide');       
        });
        $('#btn_emi_1,#btn_emi_11').click(function(){
            $(this).html('Loading....');
            $('#emi_stage_2,#otp_verify').addClass('hide');
            $('.has-error').addClass('hide');
            var eo = $('#emi-option').val();
            var el = $('input[name=emi-lender]:checked').val();
            var ret = 1; 
            if (!$('input[name=emi-lender]:checked').val()) {
                $('.emi-select-lenders .has-error').removeClass('hide');
                ret = 0; 
            }
            // if(eo == '') {
            //     $('.emi-select-options .has-error').removeClass('hide');
            //     ret = 0; 
            // } 
            if(ret != 0) {
                $('#emi_stage_1').addClass('hide');
                $('#emi_stage_2').removeClass('hide');
            }
        });
        $('#btn_emi_2').click(function(){
            var full = $('#f_name');
            var mn = $('#mobile_no');
            var dob = $('#dob');
            var pan = $('#pan');
            $(this).html('Loading....');
            $('#emi_stage_1,#otp_verify').addClass('hide');
            $('.has-error').addClass('hide');
            var ret = 1; 
            if(full.val() == '') {
                full.next('span').removeClass('hide');
                ret = 0;
            } else if(isNumber(full.val())){
                full.next('span').removeClass('hide');
                ret = 0;
            } 
            if(mn.val() == '') {
                mn.next('span').removeClass('hide');
                ret = 0;
            } else if(parseInt(mn.val().length)> 13){
                mn.next('span').removeClass('hide');
                ret = 0;
            } else if(!isNumber(mn.val())){
                mn.next('span').removeClass('hide');
                ret = 0;
            } 
            if (dob.val() == '') {
                dob.next('span').removeClass('hide');
                ret = 0; 
            }
            if(pan.val() == '') {
                pan.next('span').removeClass('hide');
                ret = 0; 
            } else if(parseInt(mn.val().length)> 10){
                pan.next('span').removeClass('hide');
                ret = 0;
            } 
            if(ret != 0) {
                setTimeout(function(){
                    $('#frm_emi_1').submit();
                }, 2000);
            } else {
                $(this).html('Continue');
            }
        });
        full.on('blur',function(){
            if(full.val() == '') {
                full.next('span').addClass('has-error');
            } else if(isNumber(full.val())){
                full.next('span').addClass('has-error');
            } else {                
                full.next('span').removeClass('has-error');
            }
        });
        mn.on('blur',function(){
            if(mn.val() == '') {
                mn.next('span').addClass('has-error');
            } else if(!isNumber(mn.val())){
                mn.next('span').addClass('has-error');
            } else if(parseInt(mn.val().length) < 9){
                mn.next('span').addClass('has-error');
            } else {                
                mn.next('span').removeClass('has-error');
            }
        });
        pan.on('blur',function(){
            if(pan.val() == '') {
                pan.next('span').addClass('has-error');
            } else if(parseInt(pan.val().length) != 10){
                pan.next('span').addClass('has-error');
            } else {                
                pan.next('span').removeClass('has-error');
            }
        });
        dob.on('blur',function(){
            if(dob.val() == '') {
                dob.next('span').addClass('has-error');
            } else {                
                dob.next('span').removeClass('has-error');
            }
        });
        $('#btn_otp_verify').click(function(){
            $('.has-error').addClass('hide');
            var otp = $('#otp').val();
            $(this).html('Loading....');
            if (otp == '') {
                $(this).html('Continue');
                $('#otp_verify .otp .has-error').removeClass('hide');
            } else {
                setTimeout(function(){
                    $('#frm_otp_verify').submit();
                }, 2000);
            }
        });
        $('#tab2').click(function(){
            if($('.emi-container').hasClass('hide')){
                $('#tab-2').removeClass('hide');
                $('#otp_verify').removeClass('hide');
            } else {
                $('#otp_verify').addClass('hide');
            }
        });

        $('#dob').datepicker({
            format:"dd/mm/yyyy",
            changeMonth: true,
            changeYear: true,
            startDate: new Date('1980-01-01'),
            endDate: new Date('2003-01-01'),
            autoclose: true
        }).on('change', function(){
            dob.next('span').removeClass('has-error');
        });
    });
    
    $('#emiPaymentAlertSuccess').on('show.bs.modal', function() {
        setTimeout(function(){ $('.reload').removeClass('hide'); }, 2000);
        setTimeout(function(){ window.location.href="/m2p_demo/thank-you"; }, 6000);
    });

})( jQuery );
