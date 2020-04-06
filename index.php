<?php

// Url trang chủ
$base_url = 'https://quocthang.herokuapp.com';
// Tiêu đề
$tieude = 'Notepad';
// Vô hiệu hóa caching.
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Nếu tên của một ghi chú không được cung cấp hoặc chứa các ký tự không phải chữ và số / không phải ASCII.
if (!isset($_GET['note']) || !preg_match('/^[a-zA-Z0-9]+$/', $_GET['note'])) {

    // Tạo tên với 5 ký tự ngẫu nhiên rõ ràng. Chuyển hướng đến nó.
    header("Location: $base_url/" . substr(md5(time().'-'.rand(100000, 999999)), 0, 6));
    die;
}

$path = '_tmp/' . $_GET['note'];

if (isset($_POST['text'])) {

    // Cập nhật tệp.
    file_put_contents($path, $_POST['text']);

    // Nếu đầu vào được cung cấp trống, hãy xóa tệp.
    if (!strlen($_POST['text'])) {
        unlink($path);
    }
    die;
}

// Đầu ra tập tin thô nếu khách hàng là curl.
if (strpos($_SERVER['HTTP_USER_AGENT'], 'curl') === 0) {
    if (is_file($path)) {
        print file_get_contents($path);
    }
    die;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print $tieude; ?> with ID <?php print $_GET['note']; ?></title>
    <link rel="shortcut icon" href="<?php print $base_url; ?>/favicon.ico">
    <link rel='stylesheet' href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="<?php print $base_url; ?>/assets/css/style.css">
</head>
<body>
  <div align="center">
    <section id="main-content">
      <h3><a class="navbar-brand" href="<?php print $base_url; ?>"><?php print $tieude; ?></a></h3>
    </section>
  </div>
  <div class="container">
    <p><a href="https://quocthang.me/">- My Site</a></p>
    <p><a href="https://quocthang.me/contact/">- Contact Me</a></p>
  </div>

  <div class="line"></div>

  <form class="form">
    <textarea placeholder="Nhập nội dung cần lưu trữ vào đây.." class="input" id="content"><?php
    if (is_file($path)) {
      print htmlspecialchars(file_get_contents($path), ENT_QUOTES, 'UTF-8');
    }
    ?></textarea>
  </form>

  <div class="form-group">
    <a onclick="window.location.reload(true);">
      <button onclick="myFunction()" type="submit" class="button">
        <i class="fas fa-save" aria-hidden="true">&nbsp;</i>Saved
      </button>
    </a>
    <a href='javascript:;'>
      <button onclick='CopyLink()' type="submit" class="button">
        <i class="fas fa-copy">&nbsp;</i>Copy Link
      </button>
    </a>
    <script>
      function copyTextToClipboard(e){var t=document.createElement("textarea");t.style.position="fixed",t.style.top=0,t.style.left=0,t.style.width="2em",t.style.height="2em",t.style.padding=0,t.style.border="none",t.style.outline="none",t.style.boxShadow="none",t.style.background="transparent",t.value=e,document.body.appendChild(t),t.select();try{document.execCommand("copy"),alert("Success!")}catch(o){alert("Unsuccess!")}document.body.removeChild(t)}function CopyLink(){copyTextToClipboard(location.href)}
    </script>
    <script>
      function myFunction(){
        alert("Success!");
      }
    </script>
    <script>
      function Copy(){
        urlCopied.innerHTML = window.location.href;
      }
    </script>
    <script>document.getElementById("demo").innerHTML = "" + window.location.href;</script>
  </div>

  <div class="line"></div>
  <div class="footer">&copy; 2020 made with by <a href="https://facebook.com/100012349937086" target="_blank" rel="nofollow">Quoc Thang</a>.</div>

  <pre id="printable"></pre>

  <script src="<?php print $base_url; ?>/assets/js/script.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
