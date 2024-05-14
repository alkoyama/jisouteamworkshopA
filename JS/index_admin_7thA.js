$(document).ready(function() {
  $('.admin-link').click(function(e) {
    e.preventDefault();
    var password = prompt("管理者パスワードを入力してください:");
    if (password === "123") {
      window.location.href = $(this).attr('href');
    } else {
      alert("パスワードが違います。");
    }
  });
});