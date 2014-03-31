function autoBid() {
    $.ajax({
        type: "POST",
        url: 'https://khuyenmai.zing.vn/123pay/vua-dau-gia/ajax/setauction.'+bidUrl+'.php',
        data: {i: 0},
        success: function(rs) {
            rs = parseInt(rs);
            if (rs > 0) {
                numBid = $('#numBid').html();
                $('#numBid').html(parseInt(numBid) - 1);
                console.log("Đấu giá thành công!");
                return;
            } else {
                mss = '';
                if (rs == -1) {
                    mss = 'Bạn không đủ số lượt đấu giá';
                } else if (rs == -5) {
                    mss = 'Bạn đã đấu giá quá số lần cho phiên này';
                } else {
                    mss = 'Bạn đấu giá không thành công, vui lòng thử lại. Mã lỗi: ' + rs;
                }
                console.log(mss);
                return;
            }
        }
    }); 
}
var bidUrl = '';
function run() {
    if(bidUrl == '') {
        //var str = "https://khuyenmai.zing.vn/123pay/vua-dau-gia/dau-gia/nkvn.189.html";
        srctext = document.URL;
        bidUrl = (srctext.match(/.*\.(\d+).html/i)[1]);
    }
    var num = parseInt($.trim($("#timeleft").text()));
    if(num < 3 && num > 0) {
        autoBid();
        setTimeout("run()",3000);
    } else {
        setTimeout("run()",1000);
    }
    
}
run();