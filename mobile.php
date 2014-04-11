<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
define('STATIC_PATH', 'https://img.123pay.vn/img123ibstaging/atm/static');
define('GA_ACCOUNT', 'UA-29568265-2');
define('CANCEL_URL', 'https://123pay.vn/payport.php?cancel=yes&vpc_MerchTxnRef=');
$orderNo = '123P1402204006790';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <title>123Pay - Cổng thanh toán trực tuyến </title>
        <meta name="description" content="Cổng thanh toán trực tuyến cho các giao dịch thương mại điện tử (e-commerce), giao dịch trên internet. Nhanh chóng, tiện lợi, an toàn với 123Pay" />
        <meta name="keywords" content="123, 123pay, 123 pay, 1 2 3 pay, 123-pay, 123_pay, cổng thanh toán trực tuyến, thanh toán trực tuyến, thanh toán, trực tuyến, thương mại điện tử" />
        <link rel="shortcut icon" href="https://img.123pay.vn/img123pay/images/icon/123pay_icon.ico" type="image/ico"></link>
        <link rel="stylesheet"  href="<?php echo STATIC_PATH ?>/mobile/css/jquery.mobile-1.3.2.min.css" />
        <link rel="stylesheet" href="<?php echo STATIC_PATH ?>/mobile/css/jqm-docs.css"/>
        <link rel="stylesheet"  href="<?php echo STATIC_PATH ?>/mobile/css/pay_mobile.css" />
        <script src="<?php echo STATIC_PATH ?>/mobile/js/jquery-1.8.3.min.js"></script>
        <script src="<?php echo STATIC_PATH ?>/mobile/js/jqm-docs.js"></script>
        <script src="<?php echo STATIC_PATH ?>/mobile/js/jquery.mobile-1.3.2.min.js"></script>
        <style type="text/css">
            .ext-bank-icon {
                max-height: 50px !important;
                max-width: 50px !important;
                height:60px;
                width:80px;
                left: 39px !important;
                top: 4px !important;
            }
            .ext-ui-input-text {
                font-size:14px !important;
            }
            .price {
                margin-top:15px;
                font-size:20px;
                font-weight:bold;
                color:#b12704
            }
            table {
                padding:0;
                margin:0
            }
            table tr {
                padding:0;
                margin:0
            }
            table tr td {
                padding:0;
                margin:0
            }
            .box
            {
                background: #fff;
                border: 1px solid #194b7e;    
                border-radius: 10px;
                -moz-border-radius: 10px;
                -webkit-border-radius: 10px;
                    height:30px;width:113px;
                    box-shadow: 0px 0px 1px 1px rgba(78, 145, 199, 0.71);
                    -moz-box-shadow: 0px 0px 1px 1px rgba(78, 145, 199, 0.71);
                    -webkit-box-shadow: 0px 0px 1px 1px rgba(78, 145, 199, 0.71);
                    padding:3px 0 3px 0;
            }
            .ui-fullsize .ui-btn-inner, .ui-fullsize .ui-btn-inner {
                font-size: 13px;
              }
              .ui-mobile a img {
                  border-color: #fff;
                    border-width: 1px;
              }
              .ui-mobile a img.selected {
                border-color: red;
              }
        </style>
        <script>
            var STATIC_PATH = '<?php echo STATIC_PATH ?>';
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?php echo GA_ACCOUNT ?>']);
            _gaq.push(['_trackPageview']);
            function closeIt(){ 
                    _gaq.push(['_trackEvent', 'EXIT_PAGE', window.location.href]);
            } 
            function selectBank(this_) {
                //debugger;
                $("#content_atm").find("a img.selected").removeClass("selected");
                $(this_).find("img").addClass("selected");
                
                //alert(src);
                var subBank = "123P" + this_.id;
                $("#frmSelectBank #txtBankCode").val(subBank);
                window.location.href = "#frmSelectBank";
                //alert(subBank);
            }
            window.onbeforeunload = closeIt;
            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
                _gaq.push(['_trackEvent', 'NHOMMUACOM', 'PAY_INIT', 'selectbank']);
            })();
        </script>
        <script type="text/JavaScript" src="<?php echo STATIC_PATH ?>/js/jquery.blockUI.js"></script>
    </head>
    <body>
       <div id="newspage" data-role="page" data-url="newspage" tabindex="0" class="ui-page ui-body-c ui-page-footer-fixed ui-page-active" style="padding-bottom: 42px; min-height: 360px;">
            <div align="center" style="height:38px;" data-theme="b" data-role="header" class="ui-header ui-bar-b" role="banner"><img src="<?php echo STATIC_PATH ?>/mobile/images/123paylogo.png" height="35px"></div>
            <div align="left" style="line-height:10px;font-size:12px;margin:0 10px 0 10px;">
                <ul>
                    <li style="border-bottom:none"><span>Thanh toan don hang 1434394 tai NhomMua.com</span>
                    </li>
                    <li style="border-bottom:none"><span>Đơn vị bán hàng</span>
                        <div style="float:right;font-size:14px;color:#C60;">123Alo</div>
                    </li>
                    <li style="margin-bottom: 5px;"><span>Thanh toán (VND)</span>
                        <div style="float:right"><span class="price">50,000</span></div>
                    </li>
                </ul>
            </div>
            <div class="ui-content" style="padding-top: 0px; padding-left: 3px; padding-right: 3px;" data-role="content" role="main">
                <h4 style="margin: 4px; font-size: 13px;">Chọn loại thẻ và nhấn nút "Tiếp tục" </h4>
                <img align="absmiddle" class="box" src="<?php echo STATIC_PATH ?>/mobile/images/bank/abb.png">
                <img align="absmiddle" class="box" src="<?php echo STATIC_PATH ?>/mobile/images/bank/abb.png">
                <img align="absmiddle" class="box" src="<?php echo STATIC_PATH ?>/mobile/images/bank/abb.png">
                <img align="absmiddle" class="box" src="<?php echo STATIC_PATH ?>/mobile/images/bank/abb.png">
                <img align="absmiddle" class="box" src="<?php echo STATIC_PATH ?>/mobile/images/bank/abb.png">
                <img align="absmiddle" class="box" src="<?php echo STATIC_PATH ?>/mobile/images/bank/abb.png">
                <form id="frmSelectBank" method="post" action="/payment/index.409831.html" name="frmSelectBank" onsubmit="return checkSelectBank();" data-ajax="false">
                    
                    <input type="submit" id="btSubmit" data-disabled="false" data-theme="e" class="ui-btn-hidden" aria-disabled="false" data-icon="arrow-r" data-iconpos="right" value="Tiếp tục">
                    <a style="font-size: 12px; text-decoration: none; padding-left: 3px;" href="<?php echo CANCEL_URL.$orderNo?>">Hủy giao dịch</a>
                    <input type="hidden" value="" name="txtBankCode" id="txtBankCode" />
                </form>  
            </div>
            <div data-position="fixed" style="line-height:18px;font-size:11px;margin-top:30px;" data-type="horizontal" class="ui-bar ui-footer ui-bar-b ui-footer-fixed slideup" data-theme="b" data-role="footer" role="contentinfo"> 	
                <span style="float:left">Copyright &copy; 2013, 123Pay <br>
                    Công ty Cổ phần VNG
                </span>
                <a href="tel:1800585888" class="ui-btn ui-btn-up-b ui-shadow ui-btn-corner-all" style="float:right;margin-right:20px;" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="b"><span class="ui-btn-inner"><span class="ui-btn-text">1800 585 888</span></span></a>    
            </div> 
        </div>
    </body>
</html>
