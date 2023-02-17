let stateCheck = setInterval(() => {
  "complete" === document.readyState && (clearInterval(stateCheck), $("#drive_main_page").append('<div id="drive_download"><img src="https://3.bp.blogspot.com/-mMFtJMgwE_Q/Xom5Sy0E92I/AAAAAAAAyes/vAaEGuDORickLllhVoHamiMqSfXa77xRQCK4BGAYYCw/s1600/logo-pdusoft.png" /></div>'), $("#drive_main_page").append('<div id="drive_download_box"><div id="drive_download_close">x</div><div id="drive_download_title">Download box</div><div id="drive_download_status_box"><span id="drive_download_status">0</span>/<span id="drive_download_total">0</span> Files</div><div class="tab-wrap"><input type="radio" id="tab1" name="tabGroup1" class="tab" checked><label for="tab1">medium (<span id="drive_download_medium_count">0</span>)</label><input type="radio" id="tab2" name="tabGroup1" class="tab"><label for="tab2">hd720 (<span id="drive_download_hd720_count">0</span>)</label><input type="radio" id="tab3" name="tabGroup1" class="tab"><label for="tab3">hd1080 (<span id="drive_download_hd1080_count">0</span>)</label><input type="radio" id="tab4" name="tabGroup1" class="tab"><label for="tab4">large (<span id="drive_download_large_count">0</span>)</label><input type="radio" id="tab5" name="tabGroup1" class="tab"><label for="tab5">name (<span id="drive_download_medium_name">0</span>)</label><div class="tab__content"><textarea id="drive_download_medium"></textarea></div><div class="tab__content"><textarea id="drive_download_hd720"></textarea></div><div class="tab__content"><textarea id="drive_download_hd1080"></textarea></div><div class="tab__content"><textarea id="drive_download_large"></textarea></div><div class="tab__content"><textarea id="drive_download_name"></textarea></div><div id="drive_download_note">- Bôi đen tất cả link trong ô trên -> click chuột phải -> chọn "Download selected links with IDM" hoặc chức năng tương tự </div></div><div id="drive_download_button_outsite"><button id="drive_download_button">Getlink</button><div>(Nếu lỗi hãy nhấn F5 để reload lại trang và thử lại)</div></div><div id="drive_download_copyright"><a target="_blank" href="https://www.pdusoft.com">Pdusoft</a></div></div>'),
   $("#drive_download_close").click(function () {
    $("#drive_download_box").slideUp("slow")
  }), $("#drive_download").click(function () {
    var e = $(".iZmuQc").find(".WYuW0e").length;
    $("#drive_download_total").html(e), $("#drive_download_box").slideDown("slow")
  }), $("#drive_download_button").click(function () {
    a()
  }))
}, 100);

function a() {
  var e = new localStorageDB("pdusoft", localStorage);
  e.tableExists("video") || (e.createTable("video", ["idfile", "name", "quality", "url"]), e.commit()), e.truncate("video"), e.commit(), $(".iZmuQc").find(".WYuW0e").length > 0 ? jrun(0) : alert("Không tím thấm link cần download. Vùi lòng truy cập vào folder cần getlink!\n\nHoặc liên hệ admin nếu bạn cho là lỗi. Xin cảm ơn!")
}

function jrun(e) {
  var d = $(".iZmuQc").find(".WYuW0e:eq(" + e + ")").data("id"),
    a = $(".iZmuQc").find(".WYuW0e").length,
    t = new localStorageDB("pdusoft", localStorage),
    n = function (e) {
      var d = {};
      return e.split("&").forEach(function (e) {
        d[decodeURIComponent(e.substring(0, e.indexOf("=")))] = decodeURIComponent(e.substring(e.indexOf("=") + 1))
      }), d
    };
  $("#drive_download_button").html("Đang phân tích"), $("#drive_download_status").html(e + 1), $.ajax({
    type: "GET",
    url: "https://drive.google.com/get_video_info?docid=" + d,
    data: null,
    async: !0,
    success: function (o) {
      "ok" == (o = n(o)).status && ("string" == typeof o.url_encoded_fmt_stream_map && (o.url_encoded_fmt_stream_map = function (e) {
        var d = [];
        return e.split(",").forEach(function (e) {
          d.push(n(e))
        }), d
      }(o.url_encoded_fmt_stream_map)), o.url_encoded_fmt_stream_map.forEach(function (e) {
        o.title = o.title.replace(/\+/g, " "), t.insert("video", {
          idfile: d,
          name: o.title,
          quality: e.quality,
          url: e.url
        }), t.commit()
      })), ++e === a ? ($("#drive_download_button").html("Getlink"), b()) : jrun(e)
    }
  })
}

function b() {
  var e = new localStorageDB("pdusoft", localStorage),
   pdu = e.queryAll("video", {
      query: {
        quality: "medium"
      }
    });
  $("#drive_download_medium_name").html(pdu.length), $.each(pdu, function (e, pdu) {
    $("#drive_download_name").append(pdu.name + "\n")
  });
    d = e.queryAll("video", {
      query: {
        quality: "medium"
      }
    });
  $("#drive_download_medium_count").html(d.length), $.each(d, function (e, d) {
    $("#drive_download_medium").append(d.url + "&filename=" + encodeURI(d.name) + ".mp4\n")
  });
  var a = e.queryAll("video", {
    query: {
      quality: "hd720"
    }
  });
  $("#drive_download_hd720_count").html(a.length), $.each(a, function (e, d) {
    $("#drive_download_hd720").append(d.url + "&filename=" + encodeURI(d.name) + ".mp4\n")
  });
  var t = e.queryAll("video", {
    query: {
      quality: "hd1080"
    }
  });
  $("#drive_download_hd1080_count").html(t.length), $.each(t, function (e, d) {
    $("#drive_download_hd1080").append(d.url + "&filename=" + encodeURI(d.name) + ".mp4\n")
  });
  var n = e.queryAll("video", {
    query: {
      quality: "large"
    }
  });
  $("#drive_download_large_count").html(n.length), $.each(n, function (e, d) {
    $("#drive_download_large").append(d.url + "&filename=" + encodeURI(d.name) + ".mp4\n")
  })
}